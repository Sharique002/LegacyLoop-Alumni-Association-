<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'user_id',
        'cover_letter',
        'resume_url',
        'portfolio_url',
        'ai_match_score',
        'skills_matched',
        'status',
        'admin_notes',
        'reviewed_at',
    ];

    protected $casts = [
        'ai_match_score' => 'decimal:2',
        'skills_matched' => 'array',
        'reviewed_at' => 'datetime',
    ];

    // Relationships
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeShortlisted($query)
    {
        return $query->where('status', 'shortlisted');
    }

    // Helpers
    public function markAsReviewed()
    {
        $this->update(['reviewed_at' => now()]);
    }
}
