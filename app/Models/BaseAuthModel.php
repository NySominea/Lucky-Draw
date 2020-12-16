<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class BaseAuthModel.
 *
 * @package namespace App\Models\BaseAuthModel;
 */
class BaseAuthModel extends Authenticatable implements Transformable, HasMedia
{
    use Notifiable, TransformableTrait, InteractsWithMedia, SoftDeletes, HasRoles;

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
}
