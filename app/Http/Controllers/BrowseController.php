<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;

class BrowseController extends Controller
{
    public function index(Request $r)
    {
        $q = Anime::query()->with('genres');

        $q->search($r->term);
        $q->type($r->type);
        $q->status($r->status);
        if ($r->year) $q->year((int) $r->year);

        $sort = $r->get('sort','popularity');
        if ($sort === 'rating') $q->orderByDesc('rating_avg')->orderByDesc('popularity');
        else $q->orderByDesc('popularity');

        $animes = $q->paginate(18)->withQueryString();
        return view('browse', compact('animes'));
    }
}
