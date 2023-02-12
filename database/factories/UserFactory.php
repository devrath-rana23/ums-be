<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'role_id' => Role::factory(),
            'google_id' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'avatar' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'status' => $this->faker->numberBetween(-10000, 10000),
            'created_at' => $this->faker->randomNumber(),
            'updated_at' => $this->faker->randomNumber(),
        ];
    }
}
