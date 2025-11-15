<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Salon>
 */
class SalonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $salonNames = [
            'Luxe Hair Studio',
            'Glamour Beauty Salon',
            'Style & Grace Salon',
            'The Beauty Lounge',
            'Elite Hair & Spa',
            'Radiance Salon',
            'Chic Cuts & Color',
            'Serenity Spa & Salon',
            'Urban Beauty Bar',
            'Classic Cuts Salon'
        ];

        $cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix', 'Philadelphia', 'San Antonio', 'San Diego'];

        return [
            'name' => fake()->randomElement($salonNames) . ' - ' . fake()->city(),
            'address' => fake()->streetAddress(),
            'city' => fake()->randomElement($cities),
            'state' => fake()->stateAbbr(),
            'zip_code' => fake()->postcode(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'opening_time' => '09:00:00',
            'closing_time' => '18:00:00',
            'working_days' => ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'],
            'description' => fake()->paragraph(3),
            'image' => null,
            'is_active' => true,
        ];
    }
}
