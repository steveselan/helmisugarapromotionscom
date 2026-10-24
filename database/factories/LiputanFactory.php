<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class LiputanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                'nama' => fake()->name(),
                'email' => fake()->email(),
                'phone' => fake()->phoneNumber(),
                'media' => fake()->domainName(),
                'jabatan' => fake()->randomElement(['JR', 'PGVG', 'JRPG']),
                'jenis_undangan' => fake()->randomElement(['PC', 'Konser']),
                'undangan_id' => 1,
                'created_at' => fake()->dateTimeBetween('-1 year', 'now')
        ];
    }
}
