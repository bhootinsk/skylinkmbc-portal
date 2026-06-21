<?php

namespace App\Notifications;

use App\Models\ClientFile;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientFileActivityNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $action,
        public ClientFile $file,
        public User $actor,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $actionLabel = $this->action === 'upload' ? 'uploaded' : 'deleted';
        $client = $this->file->user;

        return (new MailMessage)
            ->subject('Client file '.$actionLabel.' — '.$this->file->original_name)
            ->greeting('Portal file activity')
            ->line('A client file was '.$actionLabel.' in the SkyLink MBC portal.')
            ->line('**Client:** '.$client->name.' ('.$client->email.')')
            ->line('**File:** '.$this->file->original_name)
            ->line('**Action by:** '.$this->actor->name.' ('.$this->actor->email.')')
            ->line('**Time:** '.now()->format('M j, Y g:i A T'))
            ->action('Open Admin Portal', url('/admin'));
    }
}
