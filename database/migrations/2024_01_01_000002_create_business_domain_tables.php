<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon', 8)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industry_id')->constrained('industries')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('legal_name')->nullable();
            $table->string('city');
            $table->string('region')->default('Kosovë');
            $table->string('country')->default('XK');
            $table->string('website')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 32)->nullable();
            $table->enum('size_band', ['1-10', '11-50', '51-200', '201-500', '500+'])->default('51-200');
            $table->text('description')->nullable();
            $table->boolean('is_verified')->default(true);
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['city', 'industry_id']);
            $table->index('is_active');
        });

        Schema::create('business_ip_ranges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->cascadeOnDelete();
            $table->unsignedBigInteger('ip_range_start');
            $table->unsignedBigInteger('ip_range_end');
            $table->string('label')->default('HQ');
            $table->boolean('is_primary')->default(true);
            $table->timestamps();

            $table->index(['ip_range_start', 'ip_range_end']);
            $table->index('business_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_ip_ranges');
        Schema::dropIfExists('businesses');
        Schema::dropIfExists('industries');
    }
};
