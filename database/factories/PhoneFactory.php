<?php

namespace Database\Factories;

use App\Models\Phone;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Phone::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $value = $this->faker->tollFreePhoneNumber;
        return [
            'value' => $value,
            'value_unformatted' => preg_replace('/\D/', '', $value),
        ];
    }
}
