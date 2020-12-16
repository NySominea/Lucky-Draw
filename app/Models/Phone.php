<?php

namespace App\Models;

use Database\Factories\PhoneFactory;

class Phone extends BaseModel
{
    protected $fillable = [
        'value', 'value_unformatted', 'status',
    ];

    public static function Unformatted($value) {
        return preg_replace('/\D/', '', $value);
    }

    public function scopeActive($query)
    {
        return $query->where('status', TRUE);
    }

    protected static function newFactory()
    {
        return PhoneFactory::new();
    }
}
