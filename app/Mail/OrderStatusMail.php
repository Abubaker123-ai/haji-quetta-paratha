<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public string $kind; // 'received' | 'status_change'

    public function __construct(Order $order, string $kind = 'status_change')
    {
        $this->order = $order;
        $this->kind = $kind;
    }

    public function envelope(): Envelope
    {
        $subject = match (true) {
            $this->kind === 'received' => "Order #{$this->order->id} confirmed — Haji Quetta Paratha",
            $this->order->status === 'preparing' => "Order #{$this->order->id} is being prepared",
            $this->order->status === 'ready' => "Order #{$this->order->id} is ready!",
            $this->order->status === 'completed' => "Order #{$this->order->id} completed — thank you!",
            $this->order->status === 'cancelled' => "Order #{$this->order->id} was cancelled",
            default => "Order #{$this->order->id} update",
        };
        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order_status',
            with: [
                'order'        => $this->order,
                'kind'         => $this->kind,
                'statusLabel'  => $this->statusLabel(),
                'statusEmoji'  => $this->statusEmoji(),
                'mainMessage'  => $this->mainMessage(),
            ],
        );
    }

    private function statusLabel(): string
    {
        return match ($this->order->status) {
            'pending'   => 'Order Received',
            'preparing' => 'Being Prepared',
            'ready'     => 'Ready for Pickup / On the Way',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            default     => ucfirst($this->order->status),
        };
    }

    private function statusEmoji(): string
    {
        return match ($this->order->status) {
            'pending'   => '🟡',
            'preparing' => '🟠',
            'ready'     => '🔵',
            'completed' => '🟢',
            'cancelled' => '🔴',
            default     => '📦',
        };
    }

    private function mainMessage(): string
    {
        if ($this->kind === 'received') {
            return 'Thank you for your order! We have received it and will start preparing shortly.';
        }
        return match ($this->order->status) {
            'preparing' => 'Good news — we have started preparing your order. It will be ready in 20–30 minutes.',
            'ready'     => $this->order->order_type === 'delivery'
                            ? 'Your order is ready and our rider is on the way. Expect arrival in 10–15 minutes.'
                            : 'Your order is ready for pickup at the restaurant.',
            'completed' => 'Your order has been completed. We hope you enjoyed your meal!',
            'cancelled' => 'Your order has been cancelled. If this is a mistake, please contact us.',
            default     => 'Your order status has been updated.',
        };
    }
}
