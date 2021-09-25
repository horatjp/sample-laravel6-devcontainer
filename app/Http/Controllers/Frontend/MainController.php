<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class MainController extends Controller
{

    public function index()
    {

        $articles = \App\Models\Article::where('active', true)->orderBy('published_at')->take(15)->get();

        return view('frontend.index', ['articles' => $articles]);
    }
}
