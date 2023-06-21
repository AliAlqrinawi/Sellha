<?php

namespace App\Notifications;

use App\Helpers\Messages;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;

class CreatedMessageNotification extends Notification
{
    use Queueable;

    protected Message $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
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

    public function toFcm($notifiable)
    {
        if($this->message->lat != NULL){
            $this->message->content = Messages::getMessage('A site has been sent');
        }
        return FcmMessage::create()
        ->setData(['chat_id' => $this->message->chat_id.''])
        ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
        ->setTitle(Messages::getMessage('New Message'))
        ->setBody($this->message->content));
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => Messages::getMessage('New Message'),
            'body' => $this->message->content,
            'chat_id' => $this->message->chat_id
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
