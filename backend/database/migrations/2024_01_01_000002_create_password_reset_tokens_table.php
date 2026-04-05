<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Note: personal_access_tokens is created by Laravel Sanctum migration
        // No need to create it here
    }

    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
        // personal_access_tokens is handled by Sanctum
    }
};
