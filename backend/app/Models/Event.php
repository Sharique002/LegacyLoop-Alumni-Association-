<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'created_by',
        'title',
        'description',
        'banner_image',
        'event_type',
        'start_date',
        'end_date',
        'timezone',
        'location_type',
        'venue_name',
        'venue_address',
        'city',
        'country',
        'meeting_link',
        'requires_registration',
        'max_attendees',
        'registration_fee',
        'registration_deadline',
        'speakers',
        'agenda',
        'prerequisites',
        'target_audience',
        'status',
        'is_featured',
        'views_count',
        'attendees_count',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'registration_deadline' => 'date',
        'requires_registration' => 'boolean',
        'registration_fee' => 'decimal:2',
        'speakers' => 'array',
        'agenda' => 'array',
        'is_featured' => 'boolean',
    ];

    // Relationships
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attendees()
    {
        return $this->hasMany(EventAttendee::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now())
                     ->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Helpers
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function incrementAttendees()
    {
        $this->increment('attendees_count');
    }

    public function isFull()
    {
        return $this->max_attendees && $this->attendees_count >= $this->max_attendees;
    }

    public function isRegistrationOpen()
    {
        if (!$this->requires_registration) return false;
        if ($this->isFull()) return false;
        if ($this->registration_deadline && $this->registration_deadline->isPast()) return false;
        return true;
    }
}
