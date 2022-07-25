<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $ticket;
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if($this->ticket->file != ''){
            return (new MailMessage)
                ->from(auth()->user()->email)
                ->subject($this->ticket->subject)
                ->greeting('Hello!')
                ->line($this->ticket->description)
                ->attach('backend/images/support/'.$this->ticket->file);
        } else {
            return (new MailMessage)
                ->from(auth()->user()->email)
                ->subject($this->ticket->subject)
                ->greeting('Hello!')
                ->line($this->ticket->description);
        }
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
            'title'=>"Ticket opened by ". $this->ticket->user->location,
            'ticket_id'=>$this->ticket->id
        ];
    }
}
