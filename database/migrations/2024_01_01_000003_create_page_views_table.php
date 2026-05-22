<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('company_id')->nullable()->constrained('companies_directory')->nullOnDelete();
            $table->string('ip_address', 45);
            $table->string('url_path', 2048);
            $table->string('full_url', 2048)->nullable();
            $table->string('referrer', 2048)->nullable();
            $table->string('session_id', 64);
            $table->string('device_type', 32)->nullable();
            $table->string('screen_resolution', 32)->nullable();
            $table->unsignedInteger('duration')->default(0);
            $table->timestamps();

            $table->index(['client_id', 'session_id']);
            $table->index(['client_id', 'ip_address', 'created_at']);
            $table->index(['client_id', 'company_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
