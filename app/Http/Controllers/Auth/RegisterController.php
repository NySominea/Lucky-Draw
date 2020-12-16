<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\SignupRequest;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
   public function __construct()
    {
        $this->middleware('guest')->except('auth.logout');
    }

    public function showSignupForm()
    {
        return view('auth.signup');
    }

    public function signup(SignupRequest $request){
        $password = $request->password;
        $request->merge([
            'password' => Hash::make($password)
        ]);

        $user = User::create($request->all());

        if ($user) {
            if ($this->guard()->attempt(['name' => $request->name, 'password' => $password], false)) {
                return redirect()->intended(route('dashboard'));
            }
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'failed' => [trans('auth.signup_failed')],
        ]);
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
