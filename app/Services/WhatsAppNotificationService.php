<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Support\Facades\Log;

class WhatsAppNotificationService
{
    /**
     * Generate WhatsApp web link with encoded pre-filled text message.
     */
    public function generateWaLink(Activity $activity): string
    {
        $phone = optional($activity->assignedUser)->phone ?? '6281234567890';
        
        // Format phone number to international format (starting with 62)
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $remainingText = $activity->remaining_days < 0 
            ? "⚠️ *TERLAMBAT* " . abs($activity->remaining_days) . " hari"
            : "⏳ Sisa " . $activity->remaining_days . " hari lagi";

        $message = "🏛️ *PENGINGAT KEGIATAN DISKOMINFO KOTA MEDAN*\n\n"
            . "Halo *{$activity->assignedUser->name}*,\n"
            . "Berikut adalah pengingat progres kegiatan Anda:\n\n"
            . "📌 *Nama Kegiatan*: {$activity->title}\n"
            . "📊 *Tahapan Saat Ini*: {$activity->step_name} (Step {$activity->current_step}/5)\n"
            . "🛒 *Metode Transaksi*: {$activity->transaction_method_name}\n"
            . "📅 *Tenggat*: " . $activity->deadline->format('d M Y') . " ({$remainingText})\n\n"
            . "Mohon segera melakukan pembaruan progres di aplikasi Sistem Monitoring Kegiatan.\n"
            . "Terima kasih.";

        return "https://api.whatsapp.com/send?phone={$phone}&text=" . urlencode($message);
    }

    /**
     * Simulate automated sending / log sending for weekly Monday cron job.
     */
    public function sendWeeklyReminders(): int
    {
        $ongoingActivities = Activity::where('current_step', '<', 5)->with('assignedUser')->get();
        $count = 0;

        foreach ($ongoingActivities as $activity) {
            if ($activity->assignedUser && $activity->assignedUser->phone) {
                Log::info("WhatsApp Weekly Reminder queued for Activity #{$activity->id} to {$activity->assignedUser->name} ({$activity->assignedUser->phone})");
                $count++;
            }
        }

        return $count;
    }
}
