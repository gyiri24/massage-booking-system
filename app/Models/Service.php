<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Service extends Model
{
    use HasFactory;

    public const GENERAL_MULTIPLIER = 1.27;
    public const VIP_DISCOUNT = 0.80;

    protected $table = 'services';

    protected $fillable = [
        'title',
        'price'
    ];

    protected function currentPrice(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $this->getModifiedPrice()
        );
    }

    public function getModifiedPrice()
    {
        return auth()->user()->role->name === Role::GENERAL_ROLE
            ? $this->price * self::GENERAL_MULTIPLIER
            : $this->price * self::VIP_DISCOUNT;

    }
}
