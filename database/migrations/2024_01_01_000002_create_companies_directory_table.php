<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies_directory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ip_range_start');
            $table->unsignedBigInteger('ip_range_end');
            $table->string('company_name');
            $table->string('industry');
            $table->string('city');
            $table->string('region')->default('Kosovë');
            $table->string('website')->nullable();
            $table->string('logo_url')->nullable();
            $table->timestamps();

            $table->index(['ip_range_start', 'ip_range_end']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies_directory');
    }
};
