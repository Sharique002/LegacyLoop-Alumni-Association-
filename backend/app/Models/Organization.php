<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Organization extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'logo',
        'description',
        'website',
        'type',
        'address',
        'city',
        'state',
        'country',
        'contact_phone',
        'contact_email',
        'is_verified',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Password mutator - only hash if not already hashed
    public function setPasswordAttribute($value)
    {
        if (preg_match('/^\$2[ayb]\$/', $value)) {
            $this->attributes['password'] = $value;
        } else {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function alumni()
    {
        return $this->hasMany(User::class)->where('is_admin', false);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function messages()
    {
        return $this->hasMany(OrganizationMessage::class);
    }

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUniversities($query)
    {
        return $query->where('type', 'university');
    }

    // Helper methods
    public function isVerified(): bool
    {
        return (bool) $this->is_verified;
    }

    public function getAlumniCount(): int
    {
        return $this->alumni()->count();
    }

    public function getEventsCount(): int
    {
        return $this->events()->count();
    }
}
