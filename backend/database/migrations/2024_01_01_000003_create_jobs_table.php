<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('posted_by')->constrained('users')->onDelete('cascade');
            
            // Job Details
            $table->string('title');
            $table->text('description');
            $table->string('company_name');
            $table->string('company_logo')->nullable();
            $table->string('job_type'); // full-time, part-time, contract, internship
            $table->string('experience_level'); // entry, mid, senior, lead
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->string('salary_currency', 3)->default('USD');
            
            // Location
            $table->string('location');
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->boolean('is_remote')->default(false);
            
            // Requirements
            $table->text('requirements')->nullable();
            $table->text('responsibilities')->nullable();
            $table->text('benefits')->nullable();
            $table->text('skills_required')->nullable(); // JSON array
            $table->integer('min_experience_years')->default(0);
            
            // Application
            $table->string('application_url')->nullable();
            $table->string('application_email')->nullable();
            $table->date('application_deadline')->nullable();
            $table->integer('openings')->default(1);
            
            // Status & Metadata
            $table->enum('status', ['active', 'closed', 'filled'])->default('active');
            $table->integer('views_count')->default(0);
            $table->integer('applications_count')->default(0);
            $table->boolean('is_featured')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['status', 'created_at']);
            $table->index('job_type');
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
