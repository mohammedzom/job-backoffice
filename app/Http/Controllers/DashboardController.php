<?php

namespace App\Http\Controllers;

use App\Models\JobApplications;
use App\Models\JobVacancies;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index()
    {
        $isCompany = $this->user->role === 'company';
        $analytics = $isCompany ? $this->getCompanyDashboardData() : $this->getAdminDashboardData();
        $user = $this->user;

        return view('dashboard.index', compact('analytics', 'user'));
    }

    private function getCompanyDashboardData()
    {
        $activeUsers_last_30_days = User::where('role', 'job_seeker')->where('last_login', '>=', now()->subDays(30))->count();

        $totalJobs = JobVacancies::where('company_id', $this->user->company->id)->whereNull('deleted_at')->count();

        $totalApplications = JobApplications::whereHas('job', fn ($q) => $q->where('company_id', $this->user->company->id))->whereNull('deleted_at')->count();

        $mostAppliedJobs = JobVacancies::with('company')->where('company_id', $this->user->company->id)->whereNull('deleted_at')->orderByDesc('apply_count')->limit(5)->get();

        $ConversionData = JobVacancies::where('company_id', $this->user->company->id)->whereNull('deleted_at')
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

        return $analytics;

    }

    private function getAdminDashboardData()
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

        return $analytics;
    }
}
