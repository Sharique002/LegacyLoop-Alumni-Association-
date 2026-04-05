<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'currency',
        'campaign_name',
        'purpose',
        'message',
        'is_anonymous',
        'donor_name',
        'donor_email',
        'payment_method',
        'transaction_id',
        'payment_status',
        'payment_metadata',
        'payment_completed_at',
        'requires_tax_receipt',
        'tax_receipt_number',
        'receipt_url',
        'recognition_level',
        'show_in_donors_wall',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_anonymous' => 'boolean',
        'payment_metadata' => 'array',
        'payment_completed_at' => 'datetime',
        'requires_tax_receipt' => 'boolean',
        'show_in_donors_wall' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('payment_status', 'completed');
    }

    public function scopeByCampaign($query, $campaign)
    {
        return $query->where('campaign_name', $campaign);
    }

    // Helpers
    public function markAsCompleted()
    {
        $this->update([
            'payment_status' => 'completed',
            'payment_completed_at' => now(),
        ]);
    }

    public function getDonorDisplayName()
    {
        if ($this->is_anonymous) {
            return 'Anonymous Donor';
        }
        return $this->donor_name ?: $this->user->full_name;
    }
}
