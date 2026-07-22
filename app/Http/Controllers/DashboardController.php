<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Determine current quarter (Triwulan) based on today's date
        $currentMonth = Carbon::now()->month;
        $defaultTriwulan = (int) ceil($currentMonth / 3);
        $selectedTriwulan = $request->input('triwulan', $defaultTriwulan);

        // Query base
        $query = Activity::with('assignedUser');
        if ($user->isStaff()) {
            $query->where('assigned_to', $user->id);
        }

        $allActivities = (clone $query)->get();
        
        // Sync statuses automatically based on deadline & current_step
        foreach ($allActivities as $act) {
            $act->syncStatus();
        }

        // Triwulan filter for ongoing activities
        $triwulanMonths = [
            1 => [1, 2, 3],
            2 => [4, 5, 6],
            3 => [7, 8, 9],
            4 => [10, 11, 12],
        ];

        $targetMonths = $triwulanMonths[$selectedTriwulan] ?? [7, 8, 9];

        // KPI Counts
        $totalCount = $allActivities->count();

        $ongoingTriwulanCount = $allActivities->filter(function ($act) use ($targetMonths) {
            $deadlineMonth = Carbon::parse($act->deadline)->month;
            return in_array($deadlineMonth, $targetMonths) && $act->current_step >= 0 && $act->current_step < 5;
        })->count();

        $nearDeadlineCount = $allActivities->filter(function ($act) {
            return $act->is_near_deadline;
        })->count();

        $overdueCount = $allActivities->filter(function ($act) {
            return $act->is_overdue;
        })->count();

        $completedCount = $allActivities->where('current_step', 5)->count();

        // Chart 1: Status Distribution
        $statusCounts = [
            'Belum Dimulai' => $allActivities->where('current_step', 0)->where('is_overdue', false)->count(),
            'Dalam Proses' => $allActivities->where('current_step', '>', 0)->where('current_step', '<', 5)->where('is_near_deadline', false)->where('is_overdue', false)->count(),
            'Mendekati Tenggat' => $nearDeadlineCount,
            'Terlambat' => $overdueCount,
            'Selesai' => $completedCount,
        ];

        // Chart 2: Step Distribution (Step 0 to 5)
        $stepCounts = [];
        foreach (Activity::STEPS as $stepCode => $stepName) {
            $stepCounts[$stepName] = $allActivities->where('current_step', $stepCode)->count();
        }

        // Recent Activities for current triwulan or overall
        $recentActivities = $allActivities->sortByDesc('updated_at')->take(6);

        return view('dashboard', compact(
            'totalCount',
            'ongoingTriwulanCount',
            'nearDeadlineCount',
            'overdueCount',
            'completedCount',
            'selectedTriwulan',
            'statusCounts',
            'stepCounts',
            'recentActivities'
        ));
    }
}
