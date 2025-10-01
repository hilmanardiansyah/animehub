<?php

namespace App\Http\Controllers;

use App\Models\{Anime, Watchlist};
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    public function toggle(Request $r, Anime $anime)
    {
        $data = $r->validate([
            'status' => 'required|in:planning,watching,completed,dropped'
        ]);

        Watchlist::updateOrCreate(
            ['user_id' => $r->user()->id, 'anime_id' => $anime->id],
            ['status' => $data['status']]
        );

        return back()->with('status','Watchlist updated!');
    }
}
