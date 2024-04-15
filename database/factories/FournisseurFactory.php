<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fournisseur>
 */
class FournisseurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // pre-process and seed
        $address = Str::substr($this->faker->address, 0, 25);

        return [
            'f_nom' => $this->faker->firstName, // 100
            'f_tel' => $this->faker->phoneNumber, // 25
            'f_adr' => $address, // 25
        ];
    }
}
