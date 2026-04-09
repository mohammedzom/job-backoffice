<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $jsonPath = database_path('data/job_data.json');
        if (! file_exists($jsonPath)) {
            Log::error('file not found');

            return;
        }
        $jobData = json_decode(file_get_contents($jsonPath), true);
        $this->call([
            UserSeeder::class,
        ]);
        $this->callWith(JobCategorySeeder::class, ['jobData' => $jobData]);
        $this->callWith(CompaniesSeeder::class, ['jobData' => $jobData]);
        $this->callWith(JobVacanciesSeeder::class, ['jobData' => $jobData]);
        $this->call(JobApplicationsSeeder::class);

    }
}
