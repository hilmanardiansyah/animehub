<?php

namespace App\Http\Controllers;

use App\Models\{Anime, Review};
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $r, Anime $anime)
    {
        $data = $r->validate([
            'rating' => 'required|integer|min:1|max:10',
            'body'   => 'nullable|string|max:2000'
        ]);

        Review::updateOrCreate(
            ['user_id' => $r->user()->id, 'anime_id' => $anime->id],
            $data
        );

        // Recalculate rating_avg cepat
        $avg = $anime->reviews()->avg('rating');
        $anime->update(['rating_avg' => $avg ? round($avg, 2) : null]);

        return back()->with('status','Review tersimpan!');
    }
}
