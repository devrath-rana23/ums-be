<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ContactInfo;
use App\Models\Employee;

class ContactInfoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContactInfo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'employee_id' => Employee::factory(),
            'created_at' => $this->faker->randomNumber(),
            'updated_at' => $this->faker->randomNumber(),
        ];
    }
}
