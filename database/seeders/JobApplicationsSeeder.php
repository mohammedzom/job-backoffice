<?php

namespace Database\Seeders;

use App\Models\JobApplications;
use App\Models\JobUserViews;
use App\Models\JobVacancies;
use App\Models\Resumes;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class JobApplicationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobApplicationsData = json_decode(file_get_contents(database_path('./data/job_applications.json')), true);

        foreach ($jobApplicationsData['jobApplications'] as $jobApplication) {
            $applicantUser = User::firstOrCreate(
                ['email' => fake()->unique()->safeEmail()],
                [
                    'name' => fake()->name(),
                    'password' => Hash::make('12345678@'),
                    'role' => 'job_seeker',
                    'email_verified_at' => now(),
                ]
            );
            $jobVacancy = JobVacancies::inRandomOrder()->first();
            $jobVacancyIds = $jobVacancy->id;

            $viewRecord = JobUserViews::firstOrCreate([
                'job_id' => $jobVacancy->id,
                'user_id' => $applicantUser->id,
            ]);

            if ($viewRecord->wasRecentlyCreated) {
                $jobVacancy->increment('view_count');
            }

            $jobVacancy->increment('view_count', rand(1, 5));
            $jobVacancy->increment('apply_count');

            $resume_data = $jobApplication['resume'];

            $skillsArray = array_map('trim', explode(',', $resume_data['skills']));

            $experienceArray = [
                [
                    'company' => 'Previous Company',
                    'position' => 'Previous Role',
                    'start_date' => 'N/A',
                    'end_date' => 'N/A',
                    'responsibilities' => $resume_data['experience'],
                ],
            ];

            $educationArray = [
                [
                    'degree' => 'Degree',
                    'university' => 'University',
                    'graduation_year' => 'N/A',
                    'field_of_study' => $resume_data['education'],
                ],
            ];

            $resume = Resumes::firstOrCreate([
                'file_name' => $resume_data['filename'],
            ], [
                'file_url' => $resume_data['fileUri'],
                'contact_details' => $resume_data['contactDetails'],
                'summary' => $resume_data['summary'],
                'skills' => $skillsArray,
                'experience' => $experienceArray,
                'education' => $educationArray,
                'user_id' => $applicantUser->id,
            ]);

            JobApplications::firstOrCreate([
                'resume_id' => $resume->id,
            ], [
                'status' => $jobApplication['status'],
                'ai_generated_score' => $jobApplication['aiGeneratedScore'] * 10,
                'ai_generated_feedback' => $jobApplication['aiGeneratedFeedback'],
                'job_id' => $jobVacancyIds,
                'user_id' => $applicantUser->id,
            ]);
        }
    }
}
