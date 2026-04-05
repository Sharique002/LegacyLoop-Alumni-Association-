<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'subject',
        'content',
        'target_audience',
        'target_value',
        'recipients_count',
        'opens_count',
        'status',
        'scheduled_at',
        'sent_at',
    ];

    protected $casts = [
        'recipients_count' => 'integer',
        'opens_count' => 'integer',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function getOpenRateAttribute()
    {
        if ($this->recipients_count <= 0) return 0;
        return round(($this->opens_count / $this->recipients_count) * 100, 1);
    }
}
