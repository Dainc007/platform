<?php

namespace App\Notifications;

use App\Models\Meeting;
use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MeetingCreated extends Notification
{
    use Queueable;


    private Meeting $meeting;
    private SmsService $smsService;
    /**
     * Create a new notification instance.
     */
    public function __construct( Meeting $meeting)
    {
        $this->meeting = $meeting;
        $this->smsService = new SmsService();

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
        $user = $this->meeting->user;

        $startDateLine = 'godzina rozpoczęcia: ' . $this->meeting->start_date;

        if($number = $user->phone_number)
        {
            $this->smsService->sendSMS($number, $startDateLine . ' Czekaj na wiadomość zwrotna z potwierdzeniem lub odrzuceniem  wybranego przez ciebie terminu.');
        }

        $username = $user->name;

        $mailMessage = (new MailMessage)
            ->subject($username . ' Zaplanował Spotkanie')
            ->greeting('Witaj')
            ->line($username . ' zaplanował nowe spotkanie.')
            ->line($startDateLine);

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
