<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorshipProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id',
        'mentee_id',
        'program_name',
        'goals',
        'areas_of_focus',
        'status',
        'start_date',
        'end_date',
        'duration_months',
        'meeting_frequency',
        'total_sessions',
        'completed_sessions',
        'mentor_rating',
        'mentee_rating',
        'mentor_feedback',
        'mentee_feedback',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relationships
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function mentee()
    {
        return $this->belongsTo(User::class, 'mentee_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Helpers
    public function start()
    {
        $this->update([
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addMonths($this->duration_months),
        ]);
    }

    public function complete()
    {
        $this->update([
            'status' => 'completed',
            'end_date' => now(),
        ]);
    }

    public function incrementSession()
    {
        $this->increment('completed_sessions');
    }
}
