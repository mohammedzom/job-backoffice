<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(array $jobData): void
    {
        foreach ($jobData['jobCategories'] as $category) {
            JobCategory::firstOrCreate([
                'name' => $category,
            ]);
        }
    }
}
