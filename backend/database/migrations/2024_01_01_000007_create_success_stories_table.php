<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('success_stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Story Content
            $table->string('title');
            $table->text('content');
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable(); // Array of image URLs
            
            // Story Details
            $table->string('category'); // career, entrepreneurship, research, social-impact, etc.
            $table->json('tags')->nullable();
            $table->string('achievement_year')->nullable();
            
            // Recognition & Awards
            $table->text('awards')->nullable();
            $table->text('media_coverage')->nullable(); // Links to news articles, etc.
            
            // Engagement
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('shares_count')->default(0);
            
            // Publication Status
            $table->enum('status', ['draft', 'pending_review', 'published', 'rejected'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->text('admin_feedback')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['status', 'published_at']);
            $table->index('category');
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('success_stories');
    }
};
