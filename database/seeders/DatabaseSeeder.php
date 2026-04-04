<?php

namespace Database\Seeders;

use App\Models\Companies;
use App\Models\JobApplications;
use App\Models\JobCategory;
use App\Models\JobVacancies;
use App\Models\Resumes;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        // Users
        $this->call([
            UserSeeder::class,
        ]);

        $jobData = json_decode(file_get_contents(database_path('./data/job_data.json')), true);

        // Job Categories
        foreach ($jobData['jobCategories'] as $category) {
            JobCategory::firstOrCreate([
                'name' => $category,
            ]);
        }

        // Companies
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

        // Job Vacancies
        foreach ($jobData['jobVacancies'] as $jobVacancyData) {
            $jobVacancy = JobVacancies::firstOrCreate([
                'title' => $jobVacancyData['title'],
            ], [
                'description' => $jobVacancyData['description'],
                'location' => $jobVacancyData['location'],
                'type' => $jobVacancyData['type'],
                'salary' => $jobVacancyData['salary'],
                'company_id' => Companies::where('name', $jobVacancyData['company'])->first()->id,
                'technologies' => json_encode($jobVacancyData['technologies']),
            ]);
            $categoryId = JobCategory::where('name', $jobVacancyData['category'])->first()->id;
            $jobVacancy->categories()->syncWithoutDetaching([$categoryId]);
        }

        // Job Applications
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
            $jobVacancyIds = JobVacancies::inRandomOrder()->first()->id;

            $resume_data = $jobApplication['resume'];
            $resume = Resumes::firstOrCreate([
                'file_name' => $resume_data['filename'],
            ], [
                'file_url' => $resume_data['fileUri'],
                'contact_details' => $resume_data['contactDetails'],
                'summary' => $resume_data['summary'],
                'skills' => $resume_data['skills'],
                'experience' => $resume_data['experience'],
                'education' => $resume_data['education'],
                'user_id' => $applicantUser->id,
            ]);

            JobApplications::firstOrCreate([
                'resume_id' => $resume->id,
            ], [
                'status' => $jobApplication['status'],
                'ai_generated_score' => $jobApplication['aiGeneratedScore'],
                'ai_generated_feedback' => $jobApplication['aiGeneratedFeedback'],
                'job_id' => $jobVacancyIds,
                'user_id' => $applicantUser->id,
            ]);
        }

        /**
         *    "resume": {
         *        "summary": "Experienced frontend developer with 5+ years of experience building responsive and interactive user interfaces. Proficient in React.js, TypeScript, and modern CSS frameworks.",
         *        "skills": "React.js, TypeScript, JavaScript, HTML5, CSS3, Tailwind CSS, Redux, Next.js, Git, Responsive Design",
         *        "experience": "Senior Frontend Developer at WebTech Inc. (2020-Present)\n- Led development of company's main web application\n- Implemented responsive designs and improved performance\n- Mentored junior developers\n\nFrontend Developer at Digital Solutions (2018-2020)\n- Developed and maintained multiple client websites\n- Collaborated with backend team on API integration\n- Implemented UI/UX improvements based on user feedback",
         *        "education": "Bachelor of Science in Computer Science, University of Technology (2014-2018)\n- Graduated with honors\n- Relevant coursework: Web Development, UI/UX Design, Database Systems"
         *    }
         * */
    }
}
