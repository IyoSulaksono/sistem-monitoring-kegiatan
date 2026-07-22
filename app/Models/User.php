<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'role',
        'position',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function activities(): HasMany
    {
        return $table = $this->hasMany(Activity::class, 'assigned_to');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPptk(): bool
    {
        return $this->role === 'pptk';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function isAdminOrPptk(): bool
    {
        return in_array($this->role, ['admin', 'pptk']);
    }
}
