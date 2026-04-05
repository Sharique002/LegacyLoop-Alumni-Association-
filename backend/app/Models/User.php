<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'email',
        'password',
        'first_name',
        'last_name',
        'phone',
        'avatar',
        'bio',
        'graduation_year',
        'degree',
        'branch',
        'enrollment_no',
        'current_company',
        'job_title',
        'industry',
        'skills',
        'experience_years',
        'city',
        'state',
        'country',
        'latitude',
        'longitude',
        'linkedin_url',
        'github_url',
        'twitter_url',
        'website_url',
        'is_profile_public',
        'is_open_to_mentor',
        'is_seeking_opportunities',
        'is_active',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'skills' => 'array',
        'is_profile_public' => 'boolean',
        'is_open_to_mentor' => 'boolean',
        'is_seeking_opportunities' => 'boolean',
        'is_active' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    // Password mutator - only hash if not already hashed
    public function setPasswordAttribute($value)
    {
        // Check if the value is already a bcrypt hash (starts with $2y$ or $2a$)
        if (preg_match('/^\$2[ayb]\$/', $value)) {
            $this->attributes['password'] = $value;
        } else {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    // Relationships
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'posted_by');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    public function eventAttendances()
    {
        return $this->hasMany(EventAttendee::class);
    }

    public function successStories()
    {
        return $this->hasMany(SuccessStory::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function sentConnections()
    {
        return $this->hasMany(Connection::class, 'sender_id');
    }

    public function receivedConnections()
    {
        return $this->hasMany(Connection::class, 'receiver_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function mentorships()
    {
        return $this->hasMany(MentorshipProgram::class, 'mentor_id');
    }

    public function menteeProgrammes()
    {
        return $this->hasMany(MentorshipProgram::class, 'mentee_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Helper methods
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function isAdmin()
    {
        return (bool) $this->is_admin;
    }

    // Alias for accepted connections (sent direction) used in controllers
    public function connections()
    {
        return $this->hasMany(Connection::class, 'sender_id')->where('status', 'accepted');
    }

    public function getInitials(): string
    {
        $first = strtoupper(substr($this->first_name ?? '', 0, 1));
        $last  = strtoupper(substr($this->last_name  ?? '', 0, 1));
        return $first . $last ?: 'AL';
    }

    public function unreadNotificationsCount(): int
    {
        return $this->notifications()->where('is_read', false)->count();
    }

    public function getUnreadMessagesCount()
    {
        return $this->receivedMessages()->where('is_read', false)->count();
    }

    public function getConnectionsCount()
    {
        return Connection::where(function ($query) {
            $query->where('sender_id', $this->id)
                  ->orWhere('receiver_id', $this->id);
        })->where('status', 'accepted')->count();
    }

    // Get all users this user has conversations with
    public function conversations()
    {
        // Get all unique users that this user has exchanged messages with
        $sentToIds = $this->sentMessages()->distinct()->pluck('receiver_id');
        $receivedFromIds = $this->receivedMessages()->distinct()->pluck('sender_id');
        
        $userIds = $sentToIds->merge($receivedFromIds)->unique();
        
        return User::whereIn('id', $userIds);
    }
}
