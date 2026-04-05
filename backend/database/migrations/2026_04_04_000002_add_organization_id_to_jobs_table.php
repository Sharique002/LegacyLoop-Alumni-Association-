<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Add organization_id for jobs posted by organizations
            $table->foreignId('organization_id')->nullable()->after('id')->constrained()->onDelete('set null');
            
            // Make posted_by nullable for organization-posted jobs
            $table->unsignedBigInteger('posted_by')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });
    }
};
