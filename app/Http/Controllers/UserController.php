<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Criteria\SearchCriteria;
use App\Http\Controllers\Controller;
use App\Repositories\Role\RoleRepository;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Repositories\User\UserRepository;

class UserController extends Controller
{
    public function __construct(UserRepository $repository, RoleRepository $roleRepository){
        $this->middleware('permission:Administration Read');
        $this->middleware('permission:Administration Create', ['only' => ['create', 'store']]);
        $this->middleware('permission:Administration Edit', ['only' => ['update']]);
        $this->middleware('permission:Administration Delete', ['only' => ['destroy']]);

        $this->repository = $repository;
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        return view('user.index', [
            'users' => $this->repository->paginate(20),
            'roles' => $this->roleRepository->popCriteria(SearchCriteria::class)->pluck('name', 'id')->all()
        ]);
    }

    public function create()
    {
        return view('user.add-edit', [
            'roles' => $this->roleRepository->popCriteria(SearchCriteria::class)->pluck('name', 'id')->all()
        ]);
    }

    public function store(CreateRequest $request)
    {

        if ($this->repository->create($request->all())) {
            return redirect()->route('users.index')
                            ->withSuccess('You have just added a user successfully');
        }

        $this->redirectBackWithErrors();
    }

    public function edit(User $user)
    {
        return view('user.add-edit', [
            'user' => $user,
            'roles' => $this->roleRepository->popCriteria(SearchCriteria::class)->pluck('name', 'id')->all()
        ]);
    }

    public function update(UpdateRequest $request, User $user)
    {
        if ($this->repository->update($request->all(), $user->id)) {
            return redirect()->route('users.index')
                            ->withSuccess('You have just updated a user successfully');
        }
        return $this->redirectBackWithErrors();
    }

    public function destroy($id)
    {
        if ($this->repository->delete($id)) {
            return redirect()->route('users.index')
                            ->withSuccess('You have just deleted a user successfully');
        }

        return $this->redirectBackWithErrors();
    }
}
