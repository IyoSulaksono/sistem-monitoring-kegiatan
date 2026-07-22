<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $staffUsers = User::orderBy('name', 'asc')->get();

        $query = $this->buildReportQuery($request, $user);
        $activities = $query->orderBy('deadline', 'asc')->get();

        foreach ($activities as $act) {
            $act->syncStatus();
        }

        return view('reports.index', compact('activities', 'staffUsers'));
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        $query = $this->buildReportQuery($request, $user);
        $activities = $query->orderBy('deadline', 'asc')->get();

        foreach ($activities as $act) {
            $act->syncStatus();
        }

        $today = Carbon::now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('reports.pdf', compact('activities', 'today'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_Monitoring_Kegiatan_Diskominfo_' . date('Ymd_His') . '.pdf');
    }

    private function buildReportQuery(Request $request, User $user)
    {
        $query = Activity::with(['assignedUser', 'progressLogs']);

        if ($user->isStaff()) {
            $query->where('assigned_to', $user->id);
        } elseif ($request->filled('assigned_to') && $request->assigned_to !== 'all') {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Triwulan filter
        if ($request->filled('triwulan') && $request->triwulan !== 'all') {
            $triwulan = (int) $request->triwulan;
            $triwulanMonthsMap = [
                1 => [1, 2, 3],
                2 => [4, 5, 6],
                3 => [7, 8, 9],
                4 => [10, 11, 12],
            ];
            $months = $triwulanMonthsMap[$triwulan] ?? [];
            $query->whereRaw('CAST(strftime("%m", deadline) AS INTEGER) IN (' . implode(',', $months) . ')');
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Transaction Method filter
        if ($request->filled('transaction_method') && $request->transaction_method !== 'all') {
            $query->where('transaction_method', $request->transaction_method);
        }

        // Date range filter
        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('deadline', '<=', $request->end_date);
        }

        return $query;
    }
}
