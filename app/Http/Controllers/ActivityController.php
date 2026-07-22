<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Activity::with('assignedUser');

        if ($user->isStaff()) {
            $query->where('assigned_to', $user->id);
        }

        // Filter by Triwulan
        if ($request->filled('triwulan') && $request->triwulan !== 'all') {
            $triwulan = (int) $request->triwulan;
            $triwulanMonths = [
                1 => [1, 2, 3],
                2 => [4, 5, 6],
                3 => [7, 8, 9],
                4 => [10, 11, 12],
            ];
            $months = $triwulanMonths[$triwulan] ?? [];
            $query->whereRaw('CAST(strftime("%m", deadline) AS INTEGER) IN (' . implode(',', $months) . ')');
        }

        // Search query
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $activities = $query->orderBy('deadline', 'asc')->paginate(10)->withQueryString();

        // Sync statuses
        foreach ($activities as $act) {
            $act->syncStatus();
        }

        return view('activities.index', compact('activities'));
    }

    public function create()
    {
        if (!Auth::user()->isAdminOrPptk()) {
            abort(403, 'Akses tidak diizinkan. Hanya Admin dan PPTK yang dapat menambah kegiatan baru.');
        }

        $staffUsers = User::orderBy('name', 'asc')->get();
        return view('activities.create', compact('staffUsers'));
    }

    public function store(StoreActivityRequest $request)
    {
        $data = $request->validated();
        
        $activity = Activity::create($data);
        $activity->syncStatus();

        return redirect()->route('activities.index')
            ->with('success', 'Kegiatan "' . $activity->title . '" berhasil ditambahkan.');
    }

    public function show(Activity $activity)
    {
        $user = Auth::user();
        if ($user->isStaff() && $activity->assigned_to !== $user->id) {
            abort(403, 'Akses terbatas pada kegiatan yang Anda kelola.');
        }

        $activity->load(['assignedUser', 'progressLogs.creator']);
        $activity->syncStatus();

        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity)
    {
        $user = Auth::user();
        if (!$user->isAdminOrPptk() && $activity->assigned_to !== $user->id) {
            abort(403, 'Akses tidak diizinkan untuk mengubah kegiatan ini.');
        }

        $staffUsers = User::orderBy('name', 'asc')->get();
        return view('activities.edit', compact('activity', 'staffUsers'));
    }

    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $user = Auth::user();
        if (!$user->isAdminOrPptk() && $activity->assigned_to !== $user->id) {
            abort(403, 'Akses tidak diizinkan untuk merubah kegiatan ini.');
        }

        $data = $request->validated();
        $activity->update($data);
        $activity->syncStatus();

        return redirect()->route('activities.show', $activity->id)
            ->with('success', 'Data kegiatan berhasil diperbarui.');
    }

    public function destroy(Activity $activity)
    {
        if (!Auth::user()->isAdminOrPptk()) {
            abort(403, 'Hanya Admin dan PPTK yang dapat menghapus kegiatan.');
        }

        $title = $activity->title;
        $activity->delete();

        return redirect()->route('activities.index')
            ->with('success', 'Kegiatan "' . $title . '" berhasil dihapus.');
    }
}
