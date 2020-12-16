<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRequest;
use App\Http\Requests\Role\UpdateRequest;
use App\Repositories\Role\RoleRepository;

class RoleController extends Controller
{
    public function __construct(RoleRepository $repository){
        $this->middleware('permission:Administration Read');
        $this->middleware('permission:Administration Create', ['only' => ['create', 'store']]);
        $this->middleware('permission:Administration Edit', ['only' => ['update']]);
        $this->middleware('permission:Administration Delete', ['only' => ['destroy']]);

        $this->repository = $repository;
    }

    public function index()
    {
        return view('role.index', [
            'roles' => $this->repository->paginate(20)
        ]);
    }

    public function create()
    {
        return view('role.add-edit');
    }

    public function store(CreateRequest $request)
    {
        if ($this->repository->createOrUpdate($request->all())) {
            return redirect()->route('roles.index')
                            ->withSuccess('You have just added a role successfully');
        }

        $this->redirectBackWithErrors();
    }

    public function edit(Role $role)
    {
        return view('role.add-edit', [
            'role' => $role
        ]);
    }

    public function update(UpdateRequest $request, Role $role)
    {
        if ($this->repository->createOrUpdate($request->all(), $role->id)) {
            return redirect()->route('roles.index')
                            ->withSuccess('You have just updated a role successfully');
        }
        return $this->redirectBackWithErrors();
    }

    public function destroy($id)
    {
        if ($this->repository->delete($id)) {
            return redirect()->route('roles.index')
                            ->withSuccess('You have just deleted a role successfully');
        }

        return $this->redirectBackWithErrors();
    }
}
