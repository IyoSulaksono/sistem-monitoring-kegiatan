<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Services\WhatsAppNotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    public function index(Request $request, WhatsAppNotificationService $waService)
    {
        $user = Auth::user();
        
        $currentMonth = Carbon::now()->month;
        $defaultTriwulan = (int) ceil($currentMonth / 3);
        $selectedTriwulan = (int) $request->input('triwulan', $defaultTriwulan);
        $year = (int) $request->input('year', Carbon::now()->year);

        // Triwulan Months mapping
        $triwulanMonthsMap = [
            1 => [1, 2, 3],
            2 => [4, 5, 6],
            3 => [7, 8, 9],
            4 => [10, 11, 12],
        ];

        $months = $triwulanMonthsMap[$selectedTriwulan] ?? [7, 8, 9];

        $query = Activity::with(['assignedUser', 'progressLogs']);
        if ($user->isStaff()) {
            $query->where('assigned_to', $user->id);
        }

        $activities = $query->orderBy('deadline', 'asc')->get();

        foreach ($activities as $act) {
            $act->syncStatus();
            $act->wa_link = $waService->generateWaLink($act);
        }

        // Build Calendar Data for 3 months in selected Triwulan
        $calendarMonths = [];
        foreach ($months as $m) {
            $date = Carbon::createFromDate($year, $m, 1);
            $monthName = $date->translatedFormat('F Y');
            $daysInMonth = $date->daysInMonth;
            $firstDayOfWeek = $date->dayOfWeek; // 0 = Sunday, 1 = Monday, etc.

            // Map activities to days in this month
            $daysMap = [];
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $currentDayDate = Carbon::createFromDate($year, $m, $d)->format('Y-m-d');
                
                $matchingActivities = $activities->filter(function ($act) use ($currentDayDate) {
                    $start = $act->start_date ? $act->start_date->format('Y-m-d') : null;
                    $deadline = $act->deadline ? $act->deadline->format('Y-m-d') : null;
                    return $currentDayDate === $start || $currentDayDate === $deadline;
                });

                $daysMap[$d] = $matchingActivities;
            }

            $calendarMonths[] = [
                'month_number' => $m,
                'name' => $monthName,
                'days_in_month' => $daysInMonth,
                'first_day_of_week' => $firstDayOfWeek,
                'days_map' => $daysMap,
            ];
        }

        return view('monitoring.index', compact(
            'activities',
            'selectedTriwulan',
            'year',
            'calendarMonths'
        ));
    }
}
