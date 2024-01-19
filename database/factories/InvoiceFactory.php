<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => function () {
                return Client::factory()->create()->id;
            },
            'employee_id' => function () {
                return Employee::factory()->create()->id;
            },
            'invoice_number' => $this->faker->unique()->numberBetween(001, 999),
            'total_amount' => $this->faker->randomFloat(2, 100, 1000),
            'due_date' => $this->faker->date,
            'status' => $this->faker->randomElement(['draft', 'sent', 'paid']),
        ];
    }
}
