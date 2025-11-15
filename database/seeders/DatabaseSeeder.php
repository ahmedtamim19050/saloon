<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Provider;
use App\Models\Review;
use App\Models\Salon;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Seeding database...');

        // Create admin user
        $admin = User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@saloon.com',
            'password' => bcrypt('password'),
        ]);

        // Create regular users
        $users = User::factory(20)->create();
        $this->command->info('Created ' . ($users->count() + 1) . ' users');

        // Create services (unique services)
        $serviceData = [
            ['name' => 'Haircut', 'category' => 'Hair', 'duration' => 30, 'price' => 35.00],
            ['name' => 'Hair Coloring', 'category' => 'Hair', 'duration' => 90, 'price' => 85.00],
            ['name' => 'Balayage', 'category' => 'Hair', 'duration' => 120, 'price' => 150.00],
            ['name' => 'Hair Styling', 'category' => 'Hair', 'duration' => 45, 'price' => 45.00],
            ['name' => 'Keratin Treatment', 'category' => 'Hair', 'duration' => 150, 'price' => 200.00],
            ['name' => 'Manicure', 'category' => 'Nails', 'duration' => 45, 'price' => 30.00],
            ['name' => 'Pedicure', 'category' => 'Nails', 'duration' => 60, 'price' => 45.00],
            ['name' => 'Gel Nails', 'category' => 'Nails', 'duration' => 75, 'price' => 55.00],
            ['name' => 'Facial', 'category' => 'Spa', 'duration' => 60, 'price' => 75.00],
            ['name' => 'Swedish Massage', 'category' => 'Spa', 'duration' => 60, 'price' => 80.00],
            ['name' => 'Deep Tissue Massage', 'category' => 'Spa', 'duration' => 90, 'price' => 110.00],
            ['name' => 'Makeup Application', 'category' => 'Makeup', 'duration' => 60, 'price' => 65.00],
            ['name' => 'Bridal Makeup', 'category' => 'Makeup', 'duration' => 120, 'price' => 150.00],
            ['name' => 'Beard Trim', 'category' => 'Barber', 'duration' => 20, 'price' => 20.00],
            ['name' => 'Hot Towel Shave', 'category' => 'Barber', 'duration' => 30, 'price' => 35.00],
        ];

        $services = collect($serviceData)->map(function ($data) {
            return Service::create([
                'name' => $data['name'],
                'description' => 'Professional ' . strtolower($data['name']) . ' service.',
                'duration' => $data['duration'],
                'price' => $data['price'],
                'category' => $data['category'],
                'is_active' => true,
            ]);
        });
        $this->command->info('Created ' . $services->count() . ' services');

        // Create salons with providers
        $salons = Salon::factory(5)->create();
        $this->command->info('Created ' . $salons->count() . ' salons');

        $allProviders = collect();
        foreach ($salons as $salon) {
            // Create 3-6 providers per salon
            $providers = Provider::factory(rand(3, 6))->create([
                'salon_id' => $salon->id,
            ]);

            // Attach random services to each provider
            foreach ($providers as $provider) {
                $provider->services()->attach(
                    $services->random(rand(3, 7))->pluck('id')
                );
            }

            $allProviders = $allProviders->merge($providers);
        }
        $this->command->info('Created ' . $allProviders->count() . ' providers');

        // Create appointments
        $appointments = collect();
        foreach ($users as $user) {
            // Each user has 1-4 appointments
            $userAppointments = Appointment::factory(rand(1, 4))->make([
                'user_id' => $user->id,
            ]);

            foreach ($userAppointments as $appointment) {
                $provider = $allProviders->random();
                $service = $provider->services->random();

                $appointment->salon_id = $provider->salon_id;
                $appointment->provider_id = $provider->id;
                $appointment->service_id = $service->id;
                $appointment->save();

                $appointments->push($appointment);

                // Create payment for completed appointments
                if ($appointment->status === 'completed' && $appointment->payment_status === 'paid') {
                    Payment::factory()->create([
                        'appointment_id' => $appointment->id,
                        'user_id' => $user->id,
                        'service_amount' => $service->price,
                        'status' => 'completed',
                    ]);

                    // Create review for some completed appointments
                    if (rand(1, 100) > 30) {
                        Review::factory()->create([
                            'user_id' => $user->id,
                            'provider_id' => $provider->id,
                            'appointment_id' => $appointment->id,
                        ]);
                    }
                }
            }
        }
        $this->command->info('Created ' . $appointments->count() . ' appointments');

        // Update provider ratings based on reviews
        foreach ($allProviders as $provider) {
            $reviews = Review::where('provider_id', $provider->id)->get();
            if ($reviews->count() > 0) {
                $provider->average_rating = $reviews->avg('rating');
                $provider->total_reviews = $reviews->count();
                $provider->save();
            }
        }

        $this->command->info('Updated provider ratings');
        $this->command->info('Database seeding completed successfully!');
    }
}
