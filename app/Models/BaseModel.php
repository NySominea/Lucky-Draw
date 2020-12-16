<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class BaseModel.
 *
 * @package namespace App\Models;
 */
class BaseModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function saveSingleMedia($media, $collection, $mediaName) {
        if (!empty($media)) {
            $mediaName = strtolower(str_replace(' ', '-', $mediaName));
            $this->clearMediaCollection($collection);
            $this->addMedia(public_path($media))
                ->usingName($mediaName)
                ->usingFileName($mediaName.'.'.pathinfo($media, PATHINFO_EXTENSION))
                ->toMediaCollection($collection);
        }
    }

    public function getStatusBadgeAttribute()
    {
        if ($this->status) {
            return '<span class="badge badge-success" style="font-size:12px;">Active</span>';
        } else {
            return '<span class="badge badge-danger" style="font-size:12px;">Inactive</span>';
        }
    }
}
