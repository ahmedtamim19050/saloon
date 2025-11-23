@extends('layouts.dashboard')

@section('title', 'Salon Dashboard')
@section('user-role', 'Salon Owner')
@section('header', 'Dashboard')

@section('sidebar')
<a href="{{ route('salon.dashboard') }}" class="block px-4 py-3 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg mb-2">
    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
    </svg>
    Dashboard
</a>
<a href="{{ route('salon.providers') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg mb-2">
    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
    </svg>
    Providers
</a>
<a href="{{ route('salon.bookings') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg mb-2">
    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
    </svg>
    Bookings
</a>
<a href="{{ route('salon.earnings') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg mb-2">
    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    Earnings
</a>
<a href="{{ route('salon.profile') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg mb-2">
    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
    </svg>
    Salon Profile
</a>
<a href="{{ route('salon.settings') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg mb-2">
    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
    </svg>
    Settings
</a>
@endsection

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Providers Card -->
    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow p-6">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600">Total Providers</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_providers'] }}</p>
                <div class="flex items-center mt-2 space-x-2">
                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">{{ $stats['active_providers'] }} Active</span>
                    @if($stats['total_providers'] > 0)
                    <span class="text-xs text-gray-500">{{ round(($stats['active_providers']/$stats['total_providers'])*100) }}%</span>
                    @endif
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Today's Appointments Card -->
    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow p-6">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600">Today's Appointments</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['today_appointments'] }}</p>
                <div class="mt-3">
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="text-gray-600">Completed</span>
                        <span class="font-semibold text-green-600">{{ $stats['completed_today'] }}/{{ $stats['today_appointments'] }}</span>
                    </div>
                    @if($stats['today_appointments'] > 0)
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full" style="width: {{ round(($stats['completed_today']/$stats['today_appointments'])*100) }}%"></div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Due Appointments Card -->
    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow p-6">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600">Due Appointments</p>
                <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['pending_appointments'] }}</p>
                <div class="flex items-center mt-2 space-x-2">
                    <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-medium">Awaiting Action</span>
                    @if($stats['confirmed_appointments'] > 0)
                    <span class="text-xs text-green-600">+{{ $stats['confirmed_appointments'] }} confirmed</span>
                    @endif
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue Card -->
    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow p-6">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600">Total Earnings (Month)</p>
                <p class="text-3xl font-bold text-indigo-600 mt-2">৳{{ number_format($monthlyRevenue['salon_earnings'], 0) }}</p>
                <div class="mt-2 space-y-1">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-600">Total Revenue</span>
                        <span class="font-semibold text-gray-700">৳{{ number_format($monthlyRevenue['total_revenue'], 0) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 h-1.5 rounded-full" style="width: {{ $monthlyRevenue['total_revenue'] > 0 ? round(($monthlyRevenue['salon_earnings']/$monthlyRevenue['total_revenue'])*100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Progress Section -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-lg p-6 mb-6 text-white">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-xl font-bold">Monthly Progress</h3>
            <p class="text-indigo-100 text-sm">{{ now()->format('F Y') }}</p>
        </div>
        <div class="text-right">
            <p class="text-3xl font-bold">{{ $stats['month_completed'] ?? 0 }}</p>
            <p class="text-indigo-100 text-sm">Completed Bookings</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
        <div class="bg-white/10 backdrop-blur rounded-lg p-4">
            <p class="text-indigo-100 text-xs mb-1">Revenue Target</p>
            <p class="text-2xl font-bold">৳{{ number_format($stats['revenue_target'] ?? 100000, 0) }}</p>
            <div class="mt-2 bg-white/20 rounded-full h-2">
                <div class="bg-white h-2 rounded-full" style="width: {{ min(100, ($monthlyRevenue['total_revenue'] / ($stats['revenue_target'] ?? 100000)) * 100) }}%"></div>
            </div>
        </div>
        <div class="bg-white/10 backdrop-blur rounded-lg p-4">
            <p class="text-indigo-100 text-xs mb-1">Booking Target</p>
            <p class="text-2xl font-bold">{{ $stats['month_completed'] ?? 0 }}/{{ $stats['booking_target'] ?? 200 }}</p>
            <div class="mt-2 bg-white/20 rounded-full h-2">
                <div class="bg-white h-2 rounded-full" style="width: {{ min(100, (($stats['month_completed'] ?? 0) / ($stats['booking_target'] ?? 200)) * 100) }}%"></div>
            </div>
        </div>
        <div class="bg-white/10 backdrop-blur rounded-lg p-4">
            <p class="text-indigo-100 text-xs mb-1">Customer Satisfaction</p>
            <p class="text-2xl font-bold">{{ number_format($stats['avg_rating'] ?? 0, 1) }} ⭐</p>
            <p class="text-xs text-indigo-100 mt-1">Based on {{ $stats['total_reviews'] ?? 0 }} reviews</p>
        </div>
        <div class="bg-white/10 backdrop-blur rounded-lg p-4">
            <p class="text-indigo-100 text-xs mb-1">Growth Rate</p>
            <p class="text-2xl font-bold">+{{ number_format($stats['growth_rate'] ?? 0, 1) }}%</p>
            <p class="text-xs text-indigo-100 mt-1">vs last month</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Weekly Earnings Chart -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Weekly Earnings</h3>
        <canvas id="weeklyEarningsChart" height="200"></canvas>
    </div>

    <!-- Top Providers -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Providers This Month</h3>
        <div class="space-y-4">
            @forelse($topProviders as $provider)
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-semibold">
                            {{ strtoupper(substr($provider->user->name, 0, 2)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $provider->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $provider->completed_count }} appointments</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">⭐ {{ number_format($provider->average_rating, 1) }}</p>
                        <p class="text-xs text-gray-500">{{ $provider->total_reviews }} reviews</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">No providers found</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Recent Appointments -->
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Recent Appointments</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Provider</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Time</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($recentAppointments as $appointment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $appointment->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $appointment->provider->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $appointment->service->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $appointment->appointment_date->format('M d, Y') }}<br>
                            <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($appointment->start_time)->format('g:i A') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($appointment->status === 'completed') bg-green-100 text-green-800
                                @elseif($appointment->status === 'confirmed') bg-blue-100 text-blue-800
                                @elseif($appointment->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ৳{{ number_format($appointment->total_price, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            No appointments found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('weeklyEarningsChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($weeklyEarnings['labels']),
            datasets: [{
                label: 'Earnings (৳)',
                data: @json($weeklyEarnings['data']),
                borderColor: 'rgb(79, 70, 229)',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
