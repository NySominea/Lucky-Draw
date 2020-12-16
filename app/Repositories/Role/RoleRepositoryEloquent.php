<?php

namespace App\Repositories\Role;

use DB;
use Hash;
use Illuminate\Support\Arr;
use App\Criteria\SearchCriteria;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Repositories\Role\RoleRepository;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class RoleRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
{
    protected $fieldSearchable = [
        'name',
    ];

    public function model()
    {
        return Role::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(SearchCriteria::class));
    }

    public function createOrUpdate(array $attributes, $id = null)
    {
        $name = Arr::get($attributes, 'name');
        $permissions = Arr::get($attributes, 'permissions', []);

        DB::beginTransaction();
        try {

            $model = $id
                        ? parent::update(['name' => $name], $id)
                        : parent::create(['name' => $name]);
            if ($model) {
                foreach($permissions as $value){
                    Permission::firstOrCreate(
                        ['name' => $value],
                        ['name' => $value]
                    );
                }
                $model->syncPermissions($permissions);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }

        return true;
    }
}
