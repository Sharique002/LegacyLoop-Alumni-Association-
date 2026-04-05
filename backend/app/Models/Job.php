<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'posted_by',
        'title',
        'description',
        'company_name',
        'company_logo',
        'job_type',
        'experience_level',
        'salary_min',
        'salary_max',
        'salary_currency',
        'location',
        'city',
        'country',
        'is_remote',
        'requirements',
        'responsibilities',
        'benefits',
        'skills_required',
        'min_experience_years',
        'application_url',
        'application_email',
        'application_deadline',
        'openings',
        'status',
        'views_count',
        'applications_count',
        'is_featured',
    ];

    protected $casts = [
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'is_remote' => 'boolean',
        'skills_required' => 'array',
        'application_deadline' => 'date',
        'is_featured' => 'boolean',
    ];

    // Relationships
    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
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
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRemote($query)
    {
        return $query->where('is_remote', true);
    }

    public function scopeByOrganization($query, $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }

    // Helpers
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function incrementApplications()
    {
        $this->increment('applications_count');
    }
}
