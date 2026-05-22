<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('identified_leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('company_id')->constrained('companies_directory')->cascadeOnDelete();
            $table->string('ip_address', 45);
            $table->unsignedTinyInteger('lead_score')->default(0);
            $table->enum('status', ['hot', 'medium', 'cold'])->default('cold');
            $table->unsignedInteger('total_time_spent')->default(0);
            $table->unsignedInteger('visit_count')->default(1);
            $table->json('pages_visited')->nullable();
            $table->timestamp('last_active_at')->nullable();
            $table->timestamps();

            $table->unique(['client_id', 'company_id', 'ip_address']);
            $table->index(['client_id', 'status']);
            $table->index(['client_id', 'last_active_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('identified_leads');
    }
};
