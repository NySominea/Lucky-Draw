<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class User extends BaseAuthModel
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute()
    {
        $media = $this->getFirstMedia('avatar');
        return $media ? $media->getUrl('thumb') : url('images/avatar.png') ;
    }

    public function getRoleNameAttribute()
    {
        return $this->roles->count() ? $this->roles->first()->name : '';
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->format(Manipulations::FORMAT_JPG)
            ->crop(Manipulations::CROP_CENTER, 500, 500)
            ->quality(100)
            ->optimize();
    }
}
