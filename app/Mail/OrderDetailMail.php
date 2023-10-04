<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderDetailMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order
    )
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Detail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-detail',
            with: [
                'order' => $this->order
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
