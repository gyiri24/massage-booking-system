<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public const GENERAL_ROLE = "general";
    public const VIP_ROLE = "vip";

    protected $fillable = [
        'name'
    ];
}
