<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Repositories\Role\RoleRepository;
use App\Http\Requests\User\ProfileRequest;
use App\Repositories\User\UserRepository;

class ProfileController extends Controller
{
    public function __construct(UserRepository $repository){
        $this->repository = $repository;
    }

    public function index()
    {
        return view('user.profile', [
            'user' => auth()->user()
        ]);
    }

    public function update(ProfileRequest $request, User $user)
    {
        if ($this->repository->update($request->all(), auth()->id())) {
            return redirect()->route('my-profile.index')
                            ->withSuccess('You have just updated your profile successfully');
        }
        return $this->redirectBackWithErrors();
    }
}
