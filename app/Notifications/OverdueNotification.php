<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OverdueNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $borrowingLog;
    /**
     * Create a new notification instance.
     */
    public function __construct($borrowingLog)
    {
        $this->borrowingLog = $borrowingLog;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'This book is overdue!',
            'book_title' => $this->borrowingLog->book->title,
            'book_image' => $this->borrowingLog->book->image,
            'member_name' => $this->borrowingLog->member->username,
            'due_date' => $this->borrowingLog->return_date,
        ];
    }

    public function toBroadCast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => 'Hello, this is a notification!'
        ]);
    }
}
