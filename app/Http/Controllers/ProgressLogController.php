<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ProgressLog;
use App\Http\Requests\StoreProgressLogRequest;
use Illuminate\Support\Facades\Auth;

class ProgressLogController extends Controller
{
    public function store(StoreProgressLogRequest $request, Activity $activity)
    {
        $user = Auth::user();
        if ($user->isStaff() && $activity->assigned_to !== $user->id) {
            abort(403, 'Anda hanya dapat memperbarui progres kegiatan milik Anda sendiri.');
        }

        $validated = $request->validated();

        // Create log record
        ProgressLog::create([
            'activity_id' => $activity->id,
            'step' => $validated['step'],
            'description' => $validated['description'],
            'notes' => $validated['notes'] ?? null,
            'created_by' => $user->id,
        ]);

        // Update current step of the activity
        $activity->current_step = $validated['step'];
        $activity->save();

        // Sync status (Belum Dimulai, Dalam Proses, Selesai, Terlambat)
        $activity->syncStatus();

        return redirect()->route('activities.show', $activity->id)
            ->with('success', 'Progres kegiatan berhasil diperbarui ke Tahapan: ' . Activity::STEPS[$validated['step']]);
    }
}
