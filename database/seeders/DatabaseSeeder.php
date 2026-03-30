<?php

namespace Database\Seeders;

use App\Models\Companies;
use App\Models\JobCategories;
use App\Models\JobVacancies;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);
        $jobData = json_decode(file_get_contents(database_path('./data/job_data.json')), true);

        foreach ($jobData['jobCategories'] as $category) {
            JobCategories::firstOrCreate([
                'name' => $category,
            ]);
        }

        foreach ($jobData['companies'] as $company) {

            $company_owner = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail(),
            ], [
                'name' => fake()->name(),
                'password' => Hash::make('12345678@'),
                'role' => 'company',
                'email_verified_at' => now(),
            ]);
            Companies::firstOrCreate([
                'name' => $company['name'],
            ], [
                'address' => $company['address'],
                'industry' => $company['industry'],
                'website' => $company['website'],
                'description' => $company['description'],
                'owner_id' => $company_owner->id,
            ]);
        }

        foreach ($jobData['jobVacancies'] as $jobVacancy) {
            $jobVacancy = JobVacancies::firstOrCreate([
                'title' => $jobVacancy['title'],
            ], [
                'description' => $jobVacancy['description'],
                'location' => $jobVacancy['location'],
                'type' => $jobVacancy['type'],
                'salary' => $jobVacancy['salary'],
                'category_id' => JobCategories::where('name', $jobVacancy['category'])->first()->id,
                'company_id' => Companies::where('name', $jobVacancy['company'])->first()->id,
                'technologies' => json_encode($jobVacancy['technologies']),
            ]);
        }
    }
}
