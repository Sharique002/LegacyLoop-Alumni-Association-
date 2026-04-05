<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            
            // Event Details
            $table->string('title');
            $table->text('description');
            $table->string('banner_image')->nullable();
            $table->string('event_type'); // reunion, networking, webinar, workshop, conference
            
            // Date & Time
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('timezone')->default('UTC');
            
            // Location
            $table->string('location_type'); // physical, virtual, hybrid
            $table->string('venue_name')->nullable();
            $table->string('venue_address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('meeting_link')->nullable(); // Zoom/Google Meet link
            
            // Registration
            $table->boolean('requires_registration')->default(true);
            $table->integer('max_attendees')->nullable();
            $table->decimal('registration_fee', 10, 2)->default(0);
            $table->date('registration_deadline')->nullable();
            
            // Event Details
            $table->json('speakers')->nullable(); // Array of speaker objects
            $table->json('agenda')->nullable(); // Event schedule
            $table->text('prerequisites')->nullable();
            $table->text('target_audience')->nullable();
            
            // Status & Metadata
            $table->enum('status', ['draft', 'published', 'ongoing', 'completed', 'cancelled'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->integer('views_count')->default(0);
            $table->integer('attendees_count')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['status', 'start_date']);
            $table->index('event_type');
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
