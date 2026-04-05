<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Application Details
            $table->text('cover_letter')->nullable();
            $table->string('resume_url')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->decimal('ai_match_score', 5, 2)->nullable(); // AI-powered matching
            $table->json('skills_matched')->nullable();
            
            // Status Tracking
            $table->enum('status', [
                'pending', 'reviewing', 'shortlisted', 
                'interview', 'rejected', 'accepted'
            ])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            
            $table->timestamps();
            
            // Unique constraint
            $table->unique(['job_id', 'user_id']);
            
            // Indexes
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
