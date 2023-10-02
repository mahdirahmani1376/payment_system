<?php

namespace App\Support\Payment;

use App\Models\Order;
use App\Models\Payment;
use App\Support\Basket\Basket;
use Illuminate\Http\Request;
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
        $order = $this->makeOrder();

        $payment = $this->makePayment($order);

        $this->basket->clear();

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

}