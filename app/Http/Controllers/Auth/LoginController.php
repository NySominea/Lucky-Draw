<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request){

        if ($this->attemptLogin($request)) {
            return redirect()->intended(route('dashboard'));
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), false
        );
    }

    public function credentials(Request $request)
    {
        return $request->only('name', 'password');
    }

    public function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'failed' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('auth.login');
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
