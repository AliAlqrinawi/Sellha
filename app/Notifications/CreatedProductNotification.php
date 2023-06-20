<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

class CreatedProductNotification extends Notification
{
    use Queueable;

    protected Product $product;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            'database',
            FcmChannel::class,
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
        ->setData(['product_id' => $this->product->id.''])
        ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
        ->setTitle($this->product->title_ar)
        ->setBody($this->product->description_ar)
        ->setImage($this->product->file));
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->product->title_ar,
            'body' => $this->product->description_ar,
            'product_id' => $this->product->id,
            'file' => $this->product->file,
        ];
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
