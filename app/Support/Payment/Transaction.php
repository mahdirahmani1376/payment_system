<?php

namespace App\Support\Payment;

use App\Events\OrderRegisteredEvent;
use App\Models\Order;
use App\Models\Payment;
use App\Support\Basket\Basket;
use App\Support\Payment\gateways\GatewayInterface;
use App\Support\Payment\gateways\Pasargad;
use App\Support\Payment\gateways\Saman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Transaction
{
    public function __construct(
        public Request $request,
        public Basket  $basket,
    )
    {

    }

    public function checkout()
    {
        DB::beginTransaction();

        try {
            $order = $this->makeOrder();

            $payment = $this->makePayment($order);
        } catch (\Exception $e) {
            DB::rollBack();
            return null;
        }


        if ($payment->isOnline()){
            $this->gatewayFactory()->pay($order);
        }

        $this->completeOrder($order);


        return $order;
    }

    private function makeOrder()
    {
        $order = Order::create([
            'user_id' => auth()->id(),
            'code' => bin2hex(Str::random(16)),
            'amount' => $this->basket->subTotal(),
        ]);

        return $order;
    }

    private function makePayment($order)
    {
        return Payment::create([
			'order_id' => $order->id,
            'method' => $this->request->method(),
            'amount' => $order->amount
        ]);
    }

    public function products()
    {
        foreach ($this->basket->all() as $product)
        {
            $product[$product->id] = ['quantity' => $product->quantity];
        }
    }

    private function gatewayFactory()
    {
        $gateway = [
			'saman' => Saman::class,
            'pasargad' => Pasargad::class
        ][$this->request->gateway];

        return app($gateway);
    }

    public function verify()
    {
        $result = $this->gatewayFactory()->verify($this->request);
        if ($result['status'] === GatewayInterface::TRANSACTION_FAILED) return false;

        $this->confirmPayment($result);

		$this->completeOrder($result['order']);

        return true;
    }

    private function confirmPayment($result)
    {
        return $result['order']->payment->confirm($result['refNum'],$result['gateWay']);
    }

    private function normalizeQuantity(mixed $order)
    {
        foreach ($order->products as $product) {
            $product->decrementStock($product->pivot->quantity);
        }
    }

    private function completeOrder($order)
    {
        $this->normalizeQuantity($order);

        event(new OrderRegisteredEvent($order));

        $this->basket->clear();
    }

}
