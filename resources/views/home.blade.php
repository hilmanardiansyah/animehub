<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">AnimeHub</h1>

        <section class="mb-10">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold text-lg">Trending</h2>
                <a href="{{ route('browse', ['sort' => 'popularity']) }}" class="text-blue-600">Lihat semua</a>
            </div>
            <x-anime.grid :items="$trending" />
        </section>

        <section class="mb-10">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold text-lg">Top Rated</h2>
                <a href="{{ route('browse', ['sort' => 'rating']) }}" class="text-blue-600">Lihat semua</a>
            </div>
            <x-anime.grid :items="$topRated" />
        </section>

        <section>
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold text-lg">Ongoing</h2>
                <a href="{{ route('browse', ['status' => 'ongoing']) }}" class="text-blue-600">Lihat semua</a>
            </div>
            <x-anime.grid :items="$ongoing" />
        </section>
    </div>
</x-app-layout>
