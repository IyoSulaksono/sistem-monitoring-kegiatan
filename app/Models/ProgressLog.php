<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgressLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'step',
        'description',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'step' => 'integer',
        ];
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStepNameAttribute(): string
    {
        return Activity::STEPS[$this->step] ?? 'Belum dikerjakan';
    }
}
