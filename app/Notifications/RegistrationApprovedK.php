<?php

namespace App\Notifications;

use App\Models\RegistrationK;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationApprovedK extends Notification
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
            ->subject('Registration Approved: ' . $event->title)
            ->greeting('Great news, ' . $this->registration->user->name . '!')
            ->line('Your registration for **' . $event->title . '** has been **approved**.')
            ->line('Event Date: ' . $event->start_date->format('D, d M Y H:i'))
            ->line('Venue: ' . ($event->venue ?? $event->location))
            ->action('View Event', route('events.show', $event->slug))
            ->line('We look forward to seeing you there!');
    }
}
