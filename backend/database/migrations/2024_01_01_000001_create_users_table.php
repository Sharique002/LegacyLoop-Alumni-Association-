<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // Alumni Profile Information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            
            // Academic Information
            $table->string('graduation_year');
            $table->string('degree');
            $table->string('branch');
            $table->string('enrollment_no')->nullable();
            
            // Professional Information
            $table->string('current_company')->nullable();
            $table->string('job_title')->nullable();
            $table->string('industry')->nullable();
            $table->text('skills')->nullable(); // JSON array
            $table->integer('experience_years')->default(0);
            
            // Location
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            
            // Social Links
            $table->string('linkedin_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('website_url')->nullable();
            
            // Privacy & Status
            $table->boolean('is_profile_public')->default(true);
            $table->boolean('is_open_to_mentor')->default(false);
            $table->boolean('is_seeking_opportunities')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_admin')->default(false);  // Admin flag
            
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['graduation_year', 'branch']);
            $table->index(['city', 'country']);
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
