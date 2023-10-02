<?php

namespace App\Support\Payment\gateways;

use App\Models\Order;
use Illuminate\Http\Request;

class Saman implements GatewayInterface
{

    public function __construct(
    )
    {
        $this->merchantID = '452585658';
        $this->callback = route('payment.verify',$this->getName());
    }

    private function redirectToBank($order)
    {
        $amount = $order->amount + 10000;


    }

    public function pay(Order $order)
    {
        $this->redirectToBank($order);
    }

    public function verify(Request $request)
    {
        if (! $request->has('State') || $request->input('State') !== 'OK') {
            return $this->transactionFailed();
        }

        $soapClient = new \SoapClient('');

        $response = $soapClient->verifyTransaction($request->input('RefNum',$this->merchantID));

        $order = $this->getOrder($request->input('ResNum'));

        $response = $order->amount + 10000;
        $request->merge(['RefNum' => '2323232']);

        return $response = ($order->amount + 10000)
            ? $this->transactionSuccess($order,$request->input('ResNum'))
            : $this->transactionFailed();
    }

    private function getOrder($resNum)
    {
        return Order::where('code',$resNum)->firstOrFail();
    }

    private function transactionSuccess($order, $refNum)
    {
        return [
            'status' => self::TRANSACTION_FAILED,
            'order' => $order,
            'refNum' => $refNum,
            'gateway' => $this->getName()
        ];
    }

    private function transactionFailed()
    {
        return [
            'status' => self::TRANSACTION_FAILED
        ];
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }
}
