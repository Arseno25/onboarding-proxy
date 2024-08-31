<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RequestLog>
 */
class RequestLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'endpoint' => $this->faker->url,
            'data' => [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
            ],
            'meta' => [
                'user_agent' => $this->faker->userAgent,
                'ip_address' => $this->faker->ipv4,
                'method' => $this->faker->randomElement(['GET', 'POST', 'PUT', 'DELETE']),
            ],
        ];
    }
}
