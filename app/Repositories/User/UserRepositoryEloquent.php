<?php

namespace App\Repositories\User;

use DB;
use Hash;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Criteria\SearchCriteria;
use Spatie\Permission\Models\Role;
use App\Repositories\User\UserRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories\User;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    protected $fieldSearchable = [
        'name' => 'like',
        'email' => 'like',
        'status',
        'roles.id',
    ];

    public function model()
    {
        return User::class;
    }

    public function validator()
    {
    }

    public function boot()
    {
        $this->pushCriteria(app(SearchCriteria::class));
    }

    public function create(array $attributes)
    {
        $avatar = Arr::get($attributes, 'avatar', null);
        $roleId = Arr::get($attributes, 'role_id', null);
        $password = Arr::get($attributes, 'password', null);

        DB::beginTransaction();
        try {
            $attributes['password'] = Hash::make($password);
            $model = parent::create($attributes);

            if ($model) {
                $model->saveSingleMedia($avatar, 'avatar', $model->name);

                $role = Role::find($roleId);
                if ($role) $model->syncRoles([$role->name]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }

        return true;
    }

    public function update(array $attributes, $id)
    {
        $avatar = Arr::get($attributes, 'avatar', null);
        $roleId = Arr::get($attributes, 'role_id', null);
        $password = Arr::get($attributes, 'password', null);

        DB::beginTransaction();
        try {
            if ($password) {
                $attributes['password'] = Hash::make($password);
            } else {
                unset($attributes['password']);
            }

            $model = parent::update($attributes, $id);

            if ($model) {
                $model->saveSingleMedia($avatar, 'avatar', $model->name);

                $role = Role::find($roleId);
                if ($role) $model->syncRoles([$role->name]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return false;
        }

        return true;
    }

}
