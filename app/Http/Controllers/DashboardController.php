<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\JobApplications;
use App\Models\JobVacancies;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private User $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index()
    {
        $isCompany = $this->user->role === 'company';
        $analytics = $isCompany
            ? $this->getCompanyDashboardData()
            : $this->getAdminDashboardData();

        return view('dashboard.index', [
            'analytics' => $analytics,
            'user' => $this->user,
        ]);
    }

    private function getCompanyDashboardData(): array
    {
        $companyId = $this->user->company->id;

        $totalJobs = JobVacancies::whereNull('deleted_at')->where('company_id', $companyId)->count();
        $totalApplications = JobApplications::whereHas('job', fn ($q) => $q->where('company_id', $companyId))->whereNull('deleted_at')->count();
        $totalViews = JobVacancies::whereNull('deleted_at')->where('company_id', $companyId)->sum('view_count');
        $activeUsers = User::where('role', 'job_seeker')->where('last_login', '>=', now()->subDays(30))->count();

        /** @var array<string,int> */
        $applicationStatusBreakdown = JobApplications::whereHas('job', fn ($q) => $q->where('company_id', $companyId))
            ->whereNull('deleted_at')
            ->get()
            ->groupBy('status')
            ->map(fn ($g) => $g->count())
            ->toArray();

        $mostAppliedJobs = JobVacancies::with('company')
            ->whereNull('deleted_at')
            ->where('company_id', $companyId)
            ->orderByDesc('apply_count')
            ->limit(5)
            ->get();

        $conversionData = JobVacancies::whereNull('deleted_at')
            ->where('company_id', $companyId)
            ->where('view_count', '>', 0)
            ->orderByRaw('(apply_count / view_count) DESC')
            ->limit(5)
            ->get()
            ->map(function ($job) {
                $job->calculated_conversion_rate = round(($job->apply_count / $job->view_count) * 100, 2);

                return $job;
            });

        $recentApplications = JobApplications::with(['job', 'user'])
            ->whereHas('job', fn ($q) => $q->where('company_id', $companyId))
            ->whereNull('deleted_at')
            ->latest()
            ->limit(6)
            ->get();

        return [
            'activeUsers_last_30_days' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'totalViews' => $totalViews,
            'totalCompanies' => null, // N/A for company role
            'applicationStatusBreakdown' => $applicationStatusBreakdown,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionData' => $conversionData,
            'recentApplications' => $recentApplications,
        ];
    }

    private function getAdminDashboardData(): array
    {
        $totalJobs = JobVacancies::whereNull('deleted_at')->count();
        $totalApplications = JobApplications::whereNull('deleted_at')->count();
        $totalCompanies = Companies::whereNull('deleted_at')->count();
        $totalViews = JobVacancies::whereNull('deleted_at')->sum('view_count');
        $activeUsers = User::where('last_login', '>=', now()->subDays(30))->count();

        /** @var array<string,int> */
        $applicationStatusBreakdown = JobApplications::whereNull('deleted_at')
            ->get()
            ->groupBy('status')
            ->map(fn ($g) => $g->count())
            ->toArray();

        $mostAppliedJobs = JobVacancies::with('company')
            ->whereNull('deleted_at')
            ->orderByDesc('apply_count')
            ->limit(5)
            ->get();

        $conversionData = JobVacancies::whereNull('deleted_at')
            ->where('view_count', '>', 0)
            ->orderByRaw('(apply_count / view_count) DESC')
            ->limit(5)
            ->get()
            ->map(function ($job) {
                $job->calculated_conversion_rate = round(($job->apply_count / $job->view_count) * 100, 2);

                return $job;
            });

        $recentApplications = JobApplications::with(['job', 'user'])
            ->whereNull('deleted_at')
            ->latest()
            ->limit(6)
            ->get();

        return [
            'activeUsers_last_30_days' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'totalViews' => $totalViews,
            'totalCompanies' => $totalCompanies,
            'applicationStatusBreakdown' => $applicationStatusBreakdown,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionData' => $conversionData,
            'recentApplications' => $recentApplications,
        ];
    }
}
