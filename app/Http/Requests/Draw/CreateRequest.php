<?php

namespace App\Http\Requests\Draw;

use DB;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'round_number' => 'required|min:8|max:8|unique:draws,round_number'
        ];
    }
}
