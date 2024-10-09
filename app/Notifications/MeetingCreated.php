<?php

namespace App\Notifications;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MeetingCreated extends Notification
{
    use Queueable;


    private Meeting $meeting;
    /**
     * Create a new notification instance.
     */
    public function __construct( Meeting $meeting)
    {
        $this->meeting = $meeting;
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
        return (new MailMessage)
            ->subject('Notification Subject')
            ->greeting('Witaj')
            ->line($notifiable->name . ' zaplanował nowe spotkanie.')
            ->line('godzina rozpoczęcia:' . $this->meeting->start_at)
            ->lineIf($this->meeting->notes, "Dodatkowa notatka: {$this->meeting->notes->first()->content}");
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
