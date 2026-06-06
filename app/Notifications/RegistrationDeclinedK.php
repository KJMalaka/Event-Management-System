<?php

namespace App\Notifications;

use App\Models\RegistrationK;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationDeclinedK extends Notification
{
    use Queueable;

    public function __construct(private readonly RegistrationK $registration) {}

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        $event = $this->registration->event;

        return (new MailMessage)
            ->subject('Registration Update: ' . $event->title)
            ->greeting('Hello ' . $this->registration->user->name . ',')
            ->line('We regret to inform you that your registration for **' . $event->title . '** was not approved at this time.')
            ->line('Please check our other upcoming events.')
            ->action('Browse Events', route('events.index'))
            ->line('Thank you for your interest.');
    }
}
