<?php

namespace App\Http\Requests\Prize;

use DB;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        $prize = $this->route('prize');

        return [
            'name' => 'required|max:100|unique:prizes,name,' . $prize->id,
        ];
    }
}
