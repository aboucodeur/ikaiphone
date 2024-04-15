<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
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
            'c_nom' => $this->faker->firstName, // 100
            'c_tel' => $this->faker->phoneNumber, // 25
            'c_adr' => $address, // 25
            'c_type' => $this->getRandomClientType(), // 50
        ];
    }

    /**
     * Méthode pour obtenir un type de client aléatoire
     *
     * @return string
     */
    private function getRandomClientType()
    {
        $types = ['SIMPLE', 'REVENDEUR'];
        return $types[array_rand($types)];
    }
}
