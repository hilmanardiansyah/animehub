<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid md:grid-cols-3 gap-6">
            <div>
                <img src="{{ $anime->poster_path ? asset('storage/' . $anime->poster_path) : 'https://placehold.co/400x560?text=Poster' }}"
                    class="rounded-lg shadow w-full" alt="{{ $anime->title }}">
            </div>
            <div class="md:col-span-2">
                <h1 class="text-2xl font-bold">{{ $anime->title }}</h1>
                <p class="text-sm text-gray-500">
                    {{ strtoupper($anime->type) }} • {{ ucfirst($anime->status) }} • {{ $anime->year }}
                    • ⭐ {{ number_format($anime->rating_avg ?? 0, 2) }}
                </p>

                <p class="mt-4">{{ $anime->synopsis }}</p>

                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($anime->genres as $g)
                        <span class="px-2 py-1 text-xs bg-gray-100 rounded">{{ $g->name }}</span>
                    @endforeach
                </div>

                <div class="mt-6">
                    <h3 class="font-semibold mb-2">Seasons & Episodes</h3>
                    @foreach ($anime->seasons as $s)
                        <details class="mb-2">
                            <summary class="cursor-pointer font-medium">Season {{ $s->number }}
                                {{ $s->title ? '— ' . $s->title : '' }}</summary>
                            <ul class="ml-5 list-disc mt-2">
                                @foreach ($s->episodes as $e)
                                    <li class="mb-1">
                                        Ep {{ $e->number }}: {{ $e->title }}
                                        @if ($e->external_official_url)
                                            <a class="text-blue-600 underline ml-2"
                                                href="{{ $e->external_official_url }}" target="_blank">Tonton resmi</a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </details>
                    @endforeach
                </div>

                @auth
                    <form method="post" action="{{ route('watchlist.toggle', $anime) }}"
                        class="mt-4 flex items-center gap-2">
                        @csrf
                        <select name="status" class="border rounded p-2">
                            @foreach (['planning', 'watching', 'completed', 'dropped'] as $st)
                                <option value="{{ $st }}">{{ ucfirst($st) }}</option>
                            @endforeach
                        </select>
                        <button class="bg-black text-white rounded px-4 py-2">Simpan ke Watchlist</button>
                    </form>
                @endauth
            </div>
        </div>

        <div class="mt-10">
            <h3 class="font-semibold mb-2">Ulasan</h3>
            @auth
                <form method="post" action="{{ route('review.store', $anime) }}" class="mb-4">
                    @csrf
                    <div class="flex items-center gap-2">
                        <label class="text-sm">Rating</label>
                        <input name="rating" type="number" min="1" max="10" class="border p-2 w-20 rounded">
                    </div>
                    <textarea name="body" class="border p-2 rounded w-full mt-2" rows="3" placeholder="Tulis pendapatmu..."></textarea>
                    <button class="mt-2 bg-black text-white rounded px-4 py-2">Kirim Review</button>
                </form>
            @else
                <p class="text-sm text-gray-600">Login untuk menulis review.</p>
            @endauth

            <div class="space-y-4">
                @forelse($anime->reviews as $r)
                    <div class="border rounded p-3">
                        <div class="text-sm text-gray-500">{{ $r->user->name }} • ⭐ {{ $r->rating }} •
                            {{ $r->created_at->diffForHumans() }}</div>
                        @if ($r->body)
                            <p class="mt-1">{{ $r->body }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada review.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
