<?php

namespace Database\Factories\Crm;

use Illuminate\Database\Eloquent\Factories\Factory;


class ClientFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->optional()->email(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'company' => $this->faker->optional()->company(),
        ];
    }
}
