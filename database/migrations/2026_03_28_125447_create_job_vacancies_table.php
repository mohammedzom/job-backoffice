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
            $table->foreignUuid('company_id')->constrained('companies')->restrictOnDelete();
            $table->foreignUuid('category_id')->constrained('job_categories')->restrictOnDelete();

            $table->string('title');
            $table->text('description');
            $table->string('salary');
            $table->string('location');
            $table->enum('type', ['full_time', 'part_time', 'contract', 'remote', 'hybrid', 'other'])->default('full_time');
            $table->enum('status', ['open', 'closed', 'pending'])->default('pending');
            $table->date('application_deadline')->nullable();
            $table->integer('view_count')->default(0);
            $table->integer('apply_count')->default(0);
            $table->json('technologies');
            $table->timestamps();
            $table->softDeletes();
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
