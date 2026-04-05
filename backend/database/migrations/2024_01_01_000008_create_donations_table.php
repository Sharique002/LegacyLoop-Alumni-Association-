<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Donation Details
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('campaign_name')->nullable(); // scholarship, infrastructure, alumni-fund
            $table->text('purpose')->nullable();
            $table->text('message')->nullable(); // Donor's message
            
            // Donor Information
            $table->boolean('is_anonymous')->default(false);
            $table->string('donor_name')->nullable(); // If different from user name
            $table->string('donor_email')->nullable();
            
            // Payment Information
            $table->string('payment_method'); // stripe, paypal, bank_transfer
            $table->string('transaction_id')->unique();
            $table->string('payment_status'); // pending, completed, failed, refunded
            $table->json('payment_metadata')->nullable();
            $table->timestamp('payment_completed_at')->nullable();
            
            // Tax & Receipt
            $table->boolean('requires_tax_receipt')->default(false);
            $table->string('tax_receipt_number')->nullable();
            $table->string('receipt_url')->nullable();
            
            // Recognition
            $table->enum('recognition_level', ['bronze', 'silver', 'gold', 'platinum', null])->nullable();
            $table->boolean('show_in_donors_wall')->default(true);
            
            $table->timestamps();
            
            // Indexes
            $table->index(['payment_status', 'created_at']);
            $table->index('campaign_name');
            $table->index('transaction_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
