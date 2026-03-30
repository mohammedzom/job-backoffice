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
        Schema::create('category_job', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('job_id')->constrained('job_vacancies')->restrictOnDelete();
            $table->foreignUuid('category_id')->constrained('job_categories')->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_job');
    }
};
