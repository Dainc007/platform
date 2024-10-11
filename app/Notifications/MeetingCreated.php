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
        $username = $this->meeting->user->name;

        $mailMessage = (new MailMessage)
            ->subject($username . ' Zaplanował Spotkanie')
            ->greeting('Witaj')
            ->line($username . ' zaplanował nowe spotkanie.')
            ->line('godzina rozpoczęcia: ' . $this->meeting->start_at);

        if ($this->meeting->notes && $this->meeting->notes->isNotEmpty()) {
            $mailMessage->line("Dodatkowa notatka: {$this->meeting->notes?->first()->content}");
        }

        $mailMessage->salutation('Pozdrawiam');

        return $mailMessage;
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
