<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'user_id',
        'from',
        'to'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function scopeAvailableForUser($query, $userRole)
    {
        if ($userRole === Role::VIP_ROLE) {
            return $query->whereBetween('from', ['08:00:00', '17:00:00']);
        }

        return $query->whereBetween('from', ['08:00:00', '11:00:00']);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
