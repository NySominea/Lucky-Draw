<?php

namespace App\Repositories\Phone;

use DB;
use Hash;
use App\Models\Phone;
use Illuminate\Support\Arr;
use App\Criteria\SearchCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PhoneRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PhoneRepositoryEloquent extends BaseRepository implements PhoneRepository
{
    protected $fieldSearchable = [
        'value' => 'like',
        'value_unformatted' => 'like',
        'status'
    ];

    public function model()
    {
        return Phone::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(SearchCriteria::class));
    }

    public function createOrUpdate(array $attributes, $id = null)
    {
        $attributes['value_unformatted'] = Phone::Unformatted($attributes['value']);

        DB::beginTransaction();
        try {

            $model = $id
                        ? parent::update($attributes, $id)
                        : parent::create($attributes);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }

        return true;
    }
}
