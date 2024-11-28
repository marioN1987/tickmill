<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // each time create a dummy transaction entry creates also a client and assigns the id to transaction table as foreign key
            'client_id' => Client::factory()->create()->id,
            'amount' => fake()->randomFloat(2, 10, 200)
        ];
    }
}
