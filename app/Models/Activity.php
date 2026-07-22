<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'start_date',
        'deadline',
        'status',
        'transaction_method',
        'current_step',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'deadline' => 'date',
            'transaction_method' => 'integer',
            'current_step' => 'integer',
        ];
    }

    public const STEPS = [
        0 => 'Belum dikerjakan',
        1 => 'Persiapan',
        2 => 'Pengajuan',
        3 => 'Pengerjaan',
        4 => 'Pembayaran',
        5 => 'Selesai',
    ];

    public const TRANSACTION_METHODS = [
        1 => 'Pengadaan Langsung',
        2 => 'e-Purchasing',
        3 => 'Lelang',
    ];

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function progressLogs(): HasMany
    {
        return $this->hasMany(ProgressLog::class)->orderBy('created_at', 'desc');
    }

    public function getStepNameAttribute(): string
    {
        return self::STEPS[$this->current_step] ?? 'Belum dikerjakan';
    }

    public function getTransactionMethodNameAttribute(): string
    {
        return self::TRANSACTION_METHODS[$this->transaction_method] ?? 'Pengadaan Langsung';
    }

    public function getRemainingDaysAttribute(): int
    {
        $today = Carbon::today();
        $deadline = Carbon::parse($this->deadline);
        return (int) $today->diffInDays($deadline, false);
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->current_step < 5 && $this->remaining_days < 0;
    }

    public function getIsNearDeadlineAttribute(): bool
    {
        return $this->current_step < 5 && $this->remaining_days >= 0 && $this->remaining_days <= 14;
    }

    public function getTriwulanAttribute(): int
    {
        $month = Carbon::parse($this->deadline)->month;
        return (int) ceil($month / 3);
    }

    public function getCalculatedStatusAttribute(): string
    {
        if ($this->current_step == 5) {
            return 'Selesai';
        }
        if ($this->is_overdue) {
            return 'Terlambat';
        }
        if ($this->current_step > 0) {
            return 'Dalam Proses';
        }
        return 'Belum Dimulai';
    }

    /**
     * Auto sync status based on step & deadline
     */
    public function syncStatus(): void
    {
        $newStatus = $this->calculated_status;
        if ($this->status !== $newStatus) {
            $this->status = $newStatus;
            $this->save();
        }
    }
}
