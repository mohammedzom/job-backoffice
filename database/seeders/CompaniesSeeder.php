<?php

namespace Database\Seeders;

use App\Models\Companies;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(array $jobData): void
    {
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
    }
}
