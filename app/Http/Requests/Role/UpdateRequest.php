<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $role = $this->route('role');

        return [
            'name' => 'required|max:255|unique:roles,name,' . $role->id
        ];
    }
}
