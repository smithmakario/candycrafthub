<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPaymentReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
        $this->order->loadMissing('items');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: [
                new Address($this->order->email),
            ],
            subject: 'Payment confirmed — Order #'.$this->order->reference,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders.receipt',
            with: [
                'order' => $this->order,
                'bankAccountLabel' => $this->order->paidToBankAccountLabel(),
            ],
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
