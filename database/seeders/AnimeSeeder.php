<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Models\{Anime, Season, Episode, Genre, Review, Watchlist, User};

class AnimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $animeCount = rand(8,12);

        $users = User::all();
        $genres = Genre::all();

        Anime::factory()
        ->count($animeCount)
        ->create()
        ->each(function (Anime $anime) use ($genres, $users) {
            $anime->genres()->sync(
                $genres->random(rand(2,5))->pluck('id')->toArray()
            );

            $seasonCount = rand(1,3);
            for ($s=1; $s <= $seasonCount; $s++){
                $season = Season::factory()->create([
                    'anime_id' => $anime->id,
                    'number' => $s,
                ]);
            }

            $episodeTotal = rand(12, 24);
            for ($e=1; $e <= $episodeTotal; $e++){
                Episode::factory()->create([
                    'season_id' => $season->id,
                    'number' => $e,
                ]);
            }

            $reviewers = $users->random(min($users->count(), rand(3,12)));
            foreach ($reviewers as $u) {
                Review::factory()->create([
                    'user_id' => $u->id,
                    'anime_id' => $anime->id,
                ]);
            }
            $avg = $anime->reviews()->avg('rating');
                $anime->update(['rating_avg' => $avg ? round($avg, 2) : null]);

                // Watchlist: 5–10 user acak
                $watchers = $users->random(min($users->count(), rand(5,10)));
                foreach ($watchers as $u) {
                    // unique via unique(['user_id','anime_id'])
                    Watchlist::factory()->create([
                        'user_id' => $u->id,
                        'anime_id' => $anime->id,
                        'status' => Arr::random(['planning','watching','completed','dropped']),
                    ]);
                }
            });
             Anime::factory()->count(3)->create(['type' => 'movie'])->each(function(Anime $anime) use ($genres, $users) {
            $anime->genres()->sync($genres->random(rand(1,3))->pluck('id')->toArray());
            $season = Season::factory()->create(['anime_id' => $anime->id, 'number' => 1, 'title' => 'Movie']);
            Episode::factory()->create(['season_id' => $season->id, 'number' => 1, 'title' => 'Main Feature']);
            $avg = $anime->reviews()->avg('rating');
            $anime->update(['rating_avg' => $avg ? round($avg, 2) : null]);
        });

        // Recompute popularity sederhana (berdasar jumlah watchlist + review)
        $popularity = DB::table('animes')
            ->leftJoin('watchlists','watchlists.anime_id','=','animes.id')
            ->leftJoin('reviews','reviews.anime_id','=','animes.id')
            ->select('animes.id', DB::raw('COUNT(DISTINCT watchlists.id) + COUNT(DISTINCT reviews.id) as score'))
            ->groupBy('animes.id')
            ->pluck('score','id');

        foreach ($popularity as $animeId => $score) {
            Anime::where('id',$animeId)->update(['popularity' => $score * 10]);
        }
    }
}
