<?php

namespace App\Listeners;

use App\Events\OrderRegisteredEvent;
use App\Mail\OrderDetailMail;
use Illuminate\Support\Facades\Mail;

class SendOrderDetailListener
{
    public function __construct()
    {
    }

    public function handle(OrderRegisteredEvent $event): void
    {
        Mail::to($event->order->user)->send(new OrderDetailMail($event->order));
    }
}
