<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Notification Details
            $table->string('type'); // job_posted, event_reminder, connection_request, etc.
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // Additional data (links, IDs, etc.)
            
            // Reference to related entity
            $table->string('related_type')->nullable(); // Model class name
            $table->unsignedBigInteger('related_id')->nullable(); // Model ID
            
            // Status
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'is_read', 'created_at']);
            $table->index(['related_type', 'related_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
