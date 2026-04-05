<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Registration Details
            $table->enum('status', ['registered', 'waitlisted', 'attended', 'cancelled'])->default('registered');
            $table->string('ticket_number')->unique()->nullable();
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->string('payment_status')->default('pending'); // pending, completed, refunded
            $table->string('payment_transaction_id')->nullable();
            
            // Attendance
            $table->timestamp('checked_in_at')->nullable();
            $table->integer('rating')->nullable(); // 1-5 star rating after event
            $table->text('feedback')->nullable();
            
            $table->timestamps();
            
            // Unique constraint
            $table->unique(['event_id', 'user_id']);
            
            // Indexes
            $table->index('status');
            $table->index('ticket_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_attendees');
    }
};
