<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Provider;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AppointmentSlotService
{
    /**
     * Generate available time slots for a provider on a given date
     *
     * @param Provider $provider
     * @param Service $service
     * @param string $date
     * @return Collection
     */
    public function getAvailableSlots(Provider $provider, Service $service, string $date): Collection
    {
        $salon = $provider->salon;
        $requestedDate = Carbon::parse($date);
        
        // Check if salon is open on this day
        $dayOfWeek = strtolower($requestedDate->format('l'));
        if (!in_array($dayOfWeek, $salon->working_days ?? [])) {
            return collect([]);
        }
        
        // Get salon working hours
        $openingTime = Carbon::parse($date . ' ' . $salon->opening_time);
        $closingTime = Carbon::parse($date . ' ' . $salon->closing_time);
        
        // Generate all possible slots
        $slots = collect();
        $currentSlot = $openingTime->copy();
        
        while ($currentSlot->copy()->addMinutes($service->duration)->lte($closingTime)) {
            $slotEnd = $currentSlot->copy()->addMinutes($service->duration);
            
            // Check if slot overlaps with provider's break time
            if ($provider->break_start && $provider->break_end) {
                $breakStart = Carbon::parse($date . ' ' . $provider->break_start);
                $breakEnd = Carbon::parse($date . ' ' . $provider->break_end);
                
                // Skip if slot overlaps with break
                if ($currentSlot->lt($breakEnd) && $slotEnd->gt($breakStart)) {
                    $currentSlot->addMinutes(30);
                    continue;
                }
            }
            
            // Check if slot is available (not booked)
            $isBooked = Appointment::where('provider_id', $provider->id)
                ->whereDate('appointment_date', $date)
                ->where('status', '!=', 'cancelled')
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
     *
     * @param \App\Models\User $user
     * @param int $providerId
     * @param int $salonId
     * @param int $serviceId
     * @param string $date
     * @param string $startTime
     * @param string|null $notes
     * @return Appointment
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
