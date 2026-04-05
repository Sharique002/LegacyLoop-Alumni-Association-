<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentorship_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mentee_id')->constrained('users')->onDelete('cascade');
            
            // Program Details
            $table->string('program_name')->nullable();
            $table->text('goals')->nullable();
            $table->text('areas_of_focus')->nullable(); // Career, Technical Skills, etc.
            $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])->default('pending');
            
            // Duration
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('duration_months')->default(3);
            
            // Meeting Schedule
            $table->string('meeting_frequency')->nullable(); // weekly, bi-weekly, monthly
            $table->integer('total_sessions')->default(0);
            $table->integer('completed_sessions')->default(0);
            
            // Feedback & Rating
            $table->integer('mentor_rating')->nullable(); // 1-5
            $table->integer('mentee_rating')->nullable(); // 1-5
            $table->text('mentor_feedback')->nullable();
            $table->text('mentee_feedback')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index(['mentor_id', 'status']);
            $table->index(['mentee_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentorship_programs');
    }
};
