<?php

namespace Database\Factories;

use App\Models\Clients;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Clients::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'second_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender' => ($this->faker->boolean) ? 'male' : 'female',
            'status' => ($this->faker->boolean) ? 'normal' : 'VIP',
            'birth_date' => $this->faker->date,
            'city' => 'cdnnd',
            'phone' => $this->faker->phoneNumber()
        ];
    }
}
