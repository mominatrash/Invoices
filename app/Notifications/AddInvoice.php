<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddInvoice extends Notification
{
    use Queueable;
    private $inv_mail_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($inv_mail_id)
    {
        $this->inv_mail_id = $inv_mail_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = 'http://127.0.0.1:8000/invoice_details/'.$this->inv_mail_id;

        return (new MailMessage)                 
                    ->subject('إضافة فاتورة جديدة')
                    ->line('إضافة فاتورة جديدة')
                    ->action('عرض الفاتورة', $url)
                    ->line('شكرا لاستخدامك برنامجنا لإدارة الفواتير');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
