<?php

namespace App\Repositories\Setting;

use DB;
use App\Enums\SettingKey;
use App\Models\Setting;
use App\Criteria\SearchCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\Setting\SettingRepository;

/**
 * Class SettingRepositoryEloquent.
 *
 * @package namespace App\Repositories\Setting;
 */
class SettingRepositoryEloquent extends BaseRepository implements SettingRepository
{
    protected $fieldSearchable = [
        'key',
        'value'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Setting::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(SearchCriteria::class));
    }

    public function createOrUpdate(array $attributes)
    {
        DB::beginTransaction();
        try {
            foreach ($attributes as $key => $value) {
                $model = parent::updateOrCreate(['key' => $key], ['key' => $key, 'value' => $value]);

                if ($model && in_array($key, SettingKey::imageKeys())) {
                    $model->saveSingleMedia($value, $key, $key);

                    $media = $model->getFirstMedia($key);

                    if ($media) {
                        $parseUrl = parse_url($media->getUrl());
                        if ($media->hasGeneratedConversion('thumb')) {
                            $parseUrl = parse_url($media->getUrl('thumb'));
                        }

                        if (isset($parseUrl['path'])) {
                            $model->update(['value' => $parseUrl['path']]);
                        }
                    }
                }
            }

            DB::commit();
        } catch (\Throwable $th) { dd($th->getMessage());
            DB::rollback();
            return false;
        }

        return true;
    }
}
