<?php

namespace App\Notifications;

use App\Models\ContactUs;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Validator;


class NewMessageEmail extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(ContactUs $message)
    {
        $this->message = $message;
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
        $validator = Validator::make(['email' => $this->message->email], ['email' => 'email']);

        if ($validator->fails()) {
            return new MailMessage();
        }

        return (new MailMessage)
            ->subject('يوجد لدسك رسالة جديده')
            ->line("يوجد لديك رسالة جديده")
            ->line("اسم المرسل: {$this->message->name}")
            ->line("البريد الالكتروني الخاص بالمرسل: {$this->message->email} ");
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
