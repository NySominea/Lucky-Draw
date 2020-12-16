<?php

namespace App\Http\Requests\Phone;

use DB;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        $phone = $this->route('phone');

        return [
            'value' => [
                'required',
                'min:9',
                'max:20',
                function ($attribute, $value, $fail) use ($phone) {
                    $existed = DB::table('phones')
                                    ->where('value_unformatted', preg_replace('/\D/', '', $value))
                                    ->where('id', '!=', $phone->id)
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
