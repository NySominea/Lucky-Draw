<?php

namespace App\Models;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Prize extends BaseModel implements Sortable
{
    use SortableTrait;

    protected $fillable = [
        'name', 'status', 'order_column',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', TRUE);
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

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->format(Manipulations::FORMAT_JPG)
            ->crop(Manipulations::CROP_CENTER, 300, 200)
            ->quality(80)
            ->optimize();
    }
}
