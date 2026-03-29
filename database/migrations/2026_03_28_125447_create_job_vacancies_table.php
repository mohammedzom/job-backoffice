<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('salary');
            $table->string('location');
            $table->enum('type', ['full_time', 'part_time', 'contract', 'temporary', 'other'])->default('full_time');
            $table->enum('status', ['open', 'closed', 'pending'])->default('pending');
            $table->date('application_deadline');
            $table->integer('view_count')->default(0);
            $table->integer('apply_count')->default(0);
            $table->text('required_skills');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
