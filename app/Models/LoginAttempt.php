<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    protected $fillable = ['ip', 'attempts', 'locked_until', 'last_attempt_at'];

    protected $casts = [
        'locked_until'    => 'datetime',
        'last_attempt_at' => 'datetime',
    ];

    // Segundos de bloqueo según umbrales acumulados
    // ≥15 intentos → 30 min | ≥10 → 10 min | ≥5 → 2 min
    public function getLockDurationSeconds(): int
    {
        if ($this->attempts >= 15) return 1800; // 30 min
        if ($this->attempts >= 10) return 600;  // 10 min
        return 120;                              // 2 min
    }

    public function isLocked(): bool
    {
        return $this->locked_until && now()->lt($this->locked_until);
    }

    public function secondsRemaining(): int
    {
        if (! $this->isLocked()) return 0;
        return (int) now()->diffInSeconds($this->locked_until);
    }
}
