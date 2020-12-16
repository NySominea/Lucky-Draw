<?php

namespace App\Http\Requests\Phone;

use DB;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'value' => [
                'required',
                'min:9',
                'max:20',
                function ($attribute, $value, $fail) {
                    $existed = DB::table('phones')
                                    ->where('value_unformatted', preg_replace('/\D/', '', $value))
                                    ->exists();
                    if ($existed) {
                        $fail(__('validation.unique', ['attribute' => __('phone')]));
                    }
                },
            ]
        ];
    }

    public function attributes() {
        return [
            'value' => 'phone'
        ];
    }
}
