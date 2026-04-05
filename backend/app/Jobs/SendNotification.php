<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $type;
    public $data;
    public $tries = 3;

    public function __construct(User $user, string $type, array $data)
    {
        $this->user = $user;
        $this->type = $type;
        $this->data = $data;
    }

    public function handle(): void
    {
        try {
            Log::info("Sending {$this->type} notification to {$this->user->email}");
            // Create notification in database
            // TODO: Send push/email if enabled
        } catch (\Exception $e) {
            Log::error("Failed to send notification: " . $e->getMessage());
            throw $e;
        }
    }
}
