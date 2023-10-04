<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;

class OrderRegisteredEvent
{
    use Dispatchable;

    public function __construct(
        public Order $order,
    )
    {
    }
}
