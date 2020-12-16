<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Enums\SettingKey;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class Setting.
 *
 * @package namespace App\Models\Setting;
 */
class Setting extends BaseModel
{
    protected $fillable = ['key', 'value'];

    public $translatable = ['value'];

}
