<?php

namespace App\Repositories\Phone;

use DB;
use Hash;
use App\Models\Phone;
use Illuminate\Support\Arr;
use App\Imports\PhonesImport;
use App\Criteria\SearchCriteria;
use Maatwebsite\Excel\Facades\Excel;
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

    function import($files) {
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);
        DB::beginTransaction();
        try {
            foreach ($files as $file) {
                Excel::import(new PhonesImport, $file);
            }
            DB::commit();
            return [
                'success' => true,
                'message' => 'Completed!!!'
            ];
        } catch (ValidationException $ex) {
            DB::rollback();
            return [
                'success' => false,
                'message' => $ex->getMessage()
            ];
        }
    }
}
