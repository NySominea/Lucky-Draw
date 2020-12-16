<?php

namespace App\Http\Requests\User;

use Hash;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = auth()->user();

        $rules = [
            'name' => 'required|unique:users,name,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'old_password' => [
                'nullable',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('The old password does not match.');
                    }
                }
            ],
            'password' => 'nullable|min:6|confirmed'
        ];

        return $rules;
    }
}
