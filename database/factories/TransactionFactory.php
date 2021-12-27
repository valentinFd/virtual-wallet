<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'from' => null,
            'to' => null,
            'amount' => $this->faker->numberBetween(0.1, 10000)
        ];
    }
}
