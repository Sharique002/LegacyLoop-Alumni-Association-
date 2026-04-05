<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create organization announcements table
        if (!Schema::hasTable('organization_announcements')) {
            Schema::create('organization_announcements', function (Blueprint $table) {
                $table->id();
                $table->foreignId('organization_id')->constrained()->onDelete('cascade');
                $table->string('title');
                $table->text('content');
                $table->string('target_audience')->default('all');
                $table->string('priority')->default('normal');
                $table->boolean('is_published')->default(false);
                $table->timestamp('published_at')->nullable();
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();
            });
        }

        // Create donation campaigns table
        if (!Schema::hasTable('donation_campaigns')) {
            Schema::create('donation_campaigns', function (Blueprint $table) {
                $table->id();
                $table->foreignId('organization_id')->constrained()->onDelete('cascade');
                $table->string('title');
                $table->text('description');
                $table->string('category')->default('general');
                $table->decimal('goal_amount', 12, 2);
                $table->decimal('raised_amount', 12, 2)->default(0);
                $table->integer('donors_count')->default(0);
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->string('status')->default('draft');
                $table->string('image')->nullable();
                $table->timestamps();
            });
        }

        // Create organization messages table
        if (!Schema::hasTable('organization_messages')) {
            Schema::create('organization_messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('organization_id')->constrained()->onDelete('cascade');
                $table->string('subject');
                $table->text('content');
                $table->string('target_audience')->default('all');
                $table->string('target_value')->nullable();
                $table->integer('recipients_count')->default(0);
                $table->integer('opens_count')->default(0);
                $table->string('status')->default('draft');
                $table->timestamp('scheduled_at')->nullable();
                $table->timestamp('sent_at')->nullable();
                $table->timestamps();
            });
        }

        // Add organization_id to success_stories if not exists
        if (Schema::hasTable('success_stories') && !Schema::hasColumn('success_stories', 'organization_id')) {
            Schema::table('success_stories', function (Blueprint $table) {
                $table->foreignId('organization_id')->nullable()->after('id')->constrained()->onDelete('set null');
            });
        }

        // Add campaign_id to donations table if not exists
        if (Schema::hasTable('donations') && !Schema::hasColumn('donations', 'campaign_id')) {
            Schema::table('donations', function (Blueprint $table) {
                $table->foreignId('campaign_id')->nullable()->after('id')->constrained('donation_campaigns')->onDelete('set null');
            });
        }
    }

    public function down()
    {
        // Remove foreign keys first
        if (Schema::hasTable('donations') && Schema::hasColumn('donations', 'campaign_id')) {
            Schema::table('donations', function (Blueprint $table) {
                $table->dropForeign(['campaign_id']);
                $table->dropColumn('campaign_id');
            });
        }

        if (Schema::hasTable('success_stories') && Schema::hasColumn('success_stories', 'organization_id')) {
            Schema::table('success_stories', function (Blueprint $table) {
                $table->dropForeign(['organization_id']);
                $table->dropColumn('organization_id');
            });
        }

        Schema::dropIfExists('organization_messages');
        Schema::dropIfExists('donation_campaigns');
        Schema::dropIfExists('organization_announcements');
    }
};
