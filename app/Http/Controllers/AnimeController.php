<?php

namespace App\Http\Controllers;

use App\Models\Anime;

class AnimeController extends Controller
{
    public function show(string $slug)
    {
        $anime = Anime::with([
            'genres',
            'seasons.episodes',
            'reviews.user',
        ])->where('slug',$slug)->firstOrFail();

        return view('anime.show', compact('anime'));
    }
}
