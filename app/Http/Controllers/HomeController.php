<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anime;


class HomeController extends Controller
{
    public function index()
    {
        $trending = Anime::with('genres')->trending()->take(3)->get();
        $topRated = Anime::with('genres')->topRated()->take(8)->get();
        $ongoing  = Anime::with('genres')->where('status','ongoing')->latest('aired_at')->take(8)->get();

        return view('home', compact('trending','topRated','ongoing'));
    }
   
}
