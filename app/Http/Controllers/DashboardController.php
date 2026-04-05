<?php

namespace App\Http\Controllers;

use App\Models\JobApplications;
use App\Models\JobVacancies;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $activeUsers_last_30_days = User::where('last_login', '>=', now()->subDays(30))->count();

        $totalJobs = JobVacancies::whereNull('deleted_at')->count();

        $totalApplications = JobApplications::whereNull('deleted_at')->count();

        $mostAppliedJobs = JobVacancies::with('company')->whereNull('deleted_at')->orderByDesc('apply_count')->limit(5)->get();

        $ConversionData = JobVacancies::whereNull('deleted_at')
            ->where('view_count', '>', 0)
            ->orderByRaw('(apply_count / view_count) DESC')
            ->limit(5)
            ->get()
            ->map(function ($job) {
                $job->calculated_conversion_rate = round(($job->apply_count / $job->view_count) * 100, 2);

                return $job;
            });

        $analytics = [
            'activeUsers_last_30_days' => $activeUsers_last_30_days,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionData' => $ConversionData,
        ];

        return view('dashboard.index', compact('analytics'));
    }
}
