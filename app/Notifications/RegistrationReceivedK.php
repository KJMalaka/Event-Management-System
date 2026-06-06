<?php

namespace App\Notifications;

use App\Models\RegistrationK;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationReceivedK extends Notification
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
            ->subject('Registration Received: ' . $event->title)
            ->greeting('Hello ' . $this->registration->user->name . ',')
            ->line('Your registration for **' . $event->title . '** has been received.')
            ->line('Status: ' . ucfirst($this->registration->status))
            ->line('Event Date: ' . $event->start_date->format('D, d M Y H:i'))
            ->line('Location: ' . $event->location)
            ->when($event->requires_approval, fn($m) => $m->line('Your registration is pending organizer approval.'))
            ->action('View Event', route('events.show', $event->slug))
            ->line('Thank you for registering!');
    }
}
