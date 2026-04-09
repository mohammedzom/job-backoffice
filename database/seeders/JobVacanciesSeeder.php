<?php

namespace Database\Seeders;

use App\Models\Companies;
use App\Models\JobCategory;
use App\Models\JobVacancies;
use Illuminate\Database\Seeder;

class JobVacanciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(array $jobData): void
    {
        foreach ($jobData['jobVacancies'] as $jobVacancyData) {
            $techs = is_array($jobVacancyData['technologies'])
                ? $jobVacancyData['technologies']
                : explode(',', $jobVacancyData['technologies']);
            $technologies = array_values(array_filter(array_map('trim', $techs)));

            $jobVacancy = JobVacancies::firstOrCreate([
                'title' => $jobVacancyData['title'],
            ], [
                'description' => $jobVacancyData['description'],
                'location' => $jobVacancyData['location'],
                'type' => $jobVacancyData['type'],
                'salary' => $jobVacancyData['salary'],
                'status' => $jobVacancyData['status'] ?? 'open',
                'company_id' => Companies::where('name', $jobVacancyData['company'])->first()->id,
                'technologies' => $technologies,
            ]);

            $categoryId = JobCategory::where('name', $jobVacancyData['category'])->first()->id;
            $jobVacancy->categories()->syncWithoutDetaching([$categoryId]);
        }
    }
}
