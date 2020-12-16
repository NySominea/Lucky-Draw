<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Draw extends BaseModel
{
    protected $fillable = [
        'round_number', 'start_at', 'end_at', 'completed',
    ];

    public function scopeActive($query)
    {
        return $query->where('completed', FALSE);
    }

    public function scopeCompleted($query)
    {
        return $query->where('completed', TRUE);
    }

    public function prizes() {
        return $this->belongsToMany(Prize::class, 'draw_prize', 'draw_id', 'prize_id')
                    ->withPivot('qty', 'available_qty', 'order_column')
                    ->orderBy('draw_prize.order_column');
    }

    public static function nextDrawingNumber() {
        $now = Carbon::now();
        $lastSegment = '0001';

        $latestDraw = Draw::withTrashed()->orderBy('round_number', 'desc')->first();
        if ($latestDraw) {
            $lastDrawYear = substr($latestDraw->round_number, 0, 4);
            if ($now->year == $lastDrawYear) {
                $lastSegment = (int) substr($latestDraw->round_number, -4);
                $lastSegment = str_pad($lastSegment + 1, 4, "0", STR_PAD_LEFT);
            }
        }

        return $now->year . $lastSegment;
    }

    public static function currentDrawingRound() {
        return Draw::with('prizes')->active()->orderBy('round_number')->first();
    }

    public function mediaUrl($conversion = null)
    {
        $media = $this->getFirstMedia('prize');
        if ($media) {
            if ($conversion && $media->hasGeneratedConversion($conversion)) {
                return $media->getUrl($conversion);
            }
            return $media->getUrl();
        }
        return url('/images/default/600x400.png');
    }
}
