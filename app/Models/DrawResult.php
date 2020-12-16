<?php

namespace App\Models;

class DrawResult extends BaseModel
{
    protected $fillable = ['draw_id', 'prize_id', 'phone_id'];

    public function phone() {
        return $this->belongsTo(Phone::class);
    }
}
