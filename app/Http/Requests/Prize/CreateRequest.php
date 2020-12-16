<?php

namespace App\Http\Requests\Prize;

use DB;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:100|unique:prizes,name',
        ];
    }
}
