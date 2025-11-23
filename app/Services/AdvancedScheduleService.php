<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Provider;
use App\Models\ProviderException;
use App\Models\SalonException;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AdvancedScheduleService
{
    /**
     * Generate available time slots for a provider on a given date
     */
    public function getAvailableSlots(Provider $provider, Service $service, string $date): Collection
    {
        $provider->load(['salon', 'schedules', 'exceptions']);
        $salon = $provider->salon;
        $requestedDate = Carbon::parse($date);
        $weekday = $requestedDate->dayOfWeek; // 0 = Sunday, 6 = Saturday

        // Check if salon has an exception on this date
        $salonException = $salon->exceptions()->whereDate('date', $date)->first();
        if ($salonException && $salonException->is_off) {
            return collect([]);
        }

        // Check if salon is off on this day
        $salonOffDays = $salon->off_days ?? [];
        if (in_array($weekday, $salonOffDays)) {
            return collect([]);
        }

        // Check provider's schedule for this weekday
        $providerSchedule = $provider->schedules()->where('weekday', $weekday)->first();
        
        if (!$providerSchedule || $providerSchedule->is_off) {
            return collect([]);
        }

        // Check provider exceptions
        $providerException = $provider->exceptions()->whereDate('date', $date)->first();
        if ($providerException && $providerException->is_off) {
            return collect([]);
        }

        // Determine working hours
        $openTime = $providerSchedule->start_time ?? $salon->opening_time ?? '09:00:00';
        $closeTime = $providerSchedule->end_time ?? $salon->closing_time ?? '18:00:00';

        // If provider has custom hours for this exception date
        if ($providerException && !$providerException->is_off) {
            $openTime = $providerException->start_time;
            $closeTime = $providerException->end_time;
        }

        $openingTime = Carbon::parse($date . ' ' . $openTime);
        $closingTime = Carbon::parse($date . ' ' . $closeTime);

        // Generate all possible slots
        $slots = collect();
        $currentSlot = $openingTime->copy();
        $serviceDuration = $service->duration;

        while ($currentSlot->copy()->addMinutes($serviceDuration)->lte($closingTime)) {
            $slotEnd = $currentSlot->copy()->addMinutes($serviceDuration);

            // Skip if slot overlaps with provider's break time
            if ($provider->break_start && $provider->break_end) {
                $breakStart = Carbon::parse($date . ' ' . $provider->break_start);
                $breakEnd = Carbon::parse($date . ' ' . $provider->break_end);

                if ($currentSlot->lt($breakEnd) && $slotEnd->gt($breakStart)) {
                    $currentSlot->addMinutes(30);
                    continue;
                }
            }

            // Check if slot is available (not booked)
            $isBooked = Appointment::where('provider_id', $provider->id)
                ->whereDate('appointment_date', $date)
                ->whereIn('status', ['pending', 'confirmed', 'in_progress'])
                ->where(function ($query) use ($currentSlot, $slotEnd) {
                    $query->whereBetween('start_time', [$currentSlot->format('H:i:s'), $slotEnd->format('H:i:s')])
                        ->orWhereBetween('end_time', [$currentSlot->format('H:i:s'), $slotEnd->format('H:i:s')])
                        ->orWhere(function ($q) use ($currentSlot, $slotEnd) {
                            $q->where('start_time', '<=', $currentSlot->format('H:i:s'))
                              ->where('end_time', '>=', $slotEnd->format('H:i:s'));
                        });
                })
                ->exists();

            if (!$isBooked) {
                $slots->push($currentSlot->format('H:i:s'));
            }

            // Move to next slot (30-minute intervals)
            $currentSlot->addMinutes(30);
        }

        return $slots;
    }

    /**
     * Book an appointment slot
     */
    public function bookAppointment($user, int $providerId, int $salonId, int $serviceId, string $date, string $startTime, ?string $notes = null): Appointment
    {
        $service = Service::findOrFail($serviceId);
        $startTimeCarbon = Carbon::parse($date . ' ' . $startTime);
        $endTime = $startTimeCarbon->copy()->addMinutes($service->duration);

        return Appointment::create([
            'user_id' => $user->id,
            'salon_id' => $salonId,
            'provider_id' => $providerId,
            'service_id' => $serviceId,
            'appointment_date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime->format('H:i:s'),
            'status' => 'pending',
            'payment_status' => 'pending',
            'notes' => $notes,
        ]);
    }
}
