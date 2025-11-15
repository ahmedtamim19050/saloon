@props(['provider'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <div class="p-6">
        <div class="flex items-start space-x-4">
            @if($provider->photo)
                <img src="{{ asset('storage/' . $provider->photo) }}" alt="{{ $provider->name }}" class="w-20 h-20 rounded-full object-cover">
            @else
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-2xl font-bold">
                    {{ substr($provider->name, 0, 1) }}
                </div>
            @endif
            
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">{{ $provider->name }}</h3>
                
                <div class="flex items-center mt-1">
                    @include('components.rating-stars', ['rating' => $provider->average_rating, 'readonly' => true])
                    <span class="ml-2 text-sm text-gray-600">
                        ({{ $provider->total_reviews }} {{ Str::plural('review', $provider->total_reviews) }})
                    </span>
                </div>
                
                @if($provider->expertise)
                    <p class="text-sm text-gray-600 mt-2">
                        <span class="font-medium">Expertise:</span> {{ $provider->expertise }}
                    </p>
                @endif
                
                @if($provider->bio)
                    <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $provider->bio }}</p>
                @endif
                
                <div class="mt-4">
                    <a href="{{ route('providers.show', $provider) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        View Profile & Book
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
