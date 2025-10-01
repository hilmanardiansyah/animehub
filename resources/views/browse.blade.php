<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <form method="get" class="grid md:grid-cols-5 gap-3 mb-6">
            <input name="term" value="{{ request('term') }}" placeholder="Cari judul…"
                class="border rounded p-2 md:col-span-2">
            <select name="type" class="border rounded p-2">
                <option value="">Semua Type</option>
                @foreach (['tv', 'movie', 'ova', 'ona', 'special'] as $t)
                    <option value="{{ $t }}" @selected(request('type') === $t)>{{ strtoupper($t) }}</option>
                @endforeach
            </select>
            <select name="status" class="border rounded p-2">
                <option value="">Semua Status</option>
                @foreach (['ongoing', 'completed', 'hiatus'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <input type="number" name="year" value="{{ request('year') }}" placeholder="Tahun"
                class="border rounded p-2">
            <select name="sort" class="border rounded p-2">
                <option value="popularity" @selected(request('sort', 'popularity') === 'popularity')>Terpopuler</option>
                <option value="rating" @selected(request('sort') === 'rating')>Rating Tertinggi</option>
            </select>
            <button class="md:col-span-5 bg-black text-white rounded p-2">Filter</button>
        </form>

        <x-anime.grid :items="$animes" />
        <div class="mt-6">{{ $animes->links() }}</div>
    </div>
</x-app-layout>
