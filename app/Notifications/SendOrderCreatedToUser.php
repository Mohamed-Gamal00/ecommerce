<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Validator;

class SendOrderCreatedToUser extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $validator = Validator::make(['email' => $this->order->addresses()->first()->email], ['email' => 'email']);

        if ($validator->fails()) {
            return new MailMessage();
        }

        return (new MailMessage)
            ->subject('طلب جديد')
            ->greeting("أهلا {$this->order->addresses()->first()->first_name}")
            ->line("تم انشاء طلب جديد برقم (#{$this->order->number}) ")
            ->action('مشاهدة أفضل العروض والخصومات', url('/'))
            ->line('نحن سعداء لاستخدامك متجرنا الالكتروني .');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
