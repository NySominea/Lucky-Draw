<?php

namespace App\Repositories\Prize;

use DB;
use Hash;
use App\Models\Prize;
use Illuminate\Support\Arr;
use App\Criteria\SearchCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PrizeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PrizeRepositoryEloquent extends BaseRepository implements PrizeRepository
{
    protected $fieldSearchable = [
        'name' => 'like',
        'status'
    ];

    public function model()
    {
        return Prize::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(SearchCriteria::class));
    }

    public function createOrUpdate(array $attributes, $id = null)
    {
        $thumbnail = Arr::get($attributes, 'thumbnail', null);

        DB::beginTransaction();
        try {

            $model = $id
                        ? parent::update($attributes, $id)
                        : parent::create($attributes);

            if ($model) {
                $model->saveSingleMedia($thumbnail, 'prize', $model->name);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }

        return true;
    }
}
