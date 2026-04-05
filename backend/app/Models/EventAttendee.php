<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAttendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'status',
        'ticket_number',
        'amount_paid',
        'payment_status',
        'payment_transaction_id',
        'checked_in_at',
        'rating',
        'feedback',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'checked_in_at' => 'datetime',
    ];

    // Relationships
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helpers
    public function checkIn()
    {
        $this->update([
            'status' => 'attended',
            'checked_in_at' => now(),
        ]);
    }

    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
    }
}
