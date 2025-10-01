@props(['items'])

<div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @foreach ($items as $a)
        <a href="{{ route('anime.show', $a->slug) }}" class="block group">
            <div class="aspect-[2/3] bg-gray-100 rounded-lg overflow-hidden">
                <img src="{{ $a->poster_path ? asset('storage/' . $a->poster_path) : 'https://placehold.co/400x560?text=Poster' }}"
                    class="h-full w-full object-cover group-hover:scale-[1.03] transition" alt="{{ $a->title }}">
            </div>
            <div class="mt-2">
                <div class="font-semibold line-clamp-1">{{ $a->title }}</div>
                <div class="text-xs text-gray-500">
                    {{ strtoupper($a->type) }} • {{ $a->year }} • ⭐ {{ number_format($a->rating_avg ?? 0, 2) }}
                </div>
            </div>
        </a>
    @endforeach
</div>
