<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\User;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'birth' => $this->faker->dateTime(),
            'user_id' => User::factory(),
            'created_at' => $this->faker->randomNumber(),
            'updated_at' => $this->faker->randomNumber(),
            'salary' => $this->faker->randomNumber(),
            'martial_status' => $this->faker->randomElement(["single","married","divorced"]),
            'bonus' => $this->faker->randomFloat(2, 0, 999999.99),
        ];
    }
}
