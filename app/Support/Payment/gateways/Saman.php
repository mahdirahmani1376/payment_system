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
        // TODO: Implement verify() method.
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }
}
