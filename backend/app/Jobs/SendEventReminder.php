<?php

namespace App\Jobs;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendEventReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $event;
    public $attendees;
    public $tries = 3;

    public function __construct(Event $event, $attendees)
    {
        $this->event = $event;
        $this->attendees = $attendees;
    }

    public function handle(): void
    {
        try {
            Log::info("Sending event reminder for: {$this->event->title}");
            foreach ($this->attendees as $attendee) {
                // TODO: Send actual email
                Log::info("Event reminder sent to {$attendee->email}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to send event reminders: " . $e->getMessage());
            throw $e;
        }
    }
}
