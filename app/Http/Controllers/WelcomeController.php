<?php

namespace App\Http\Controllers;

use App\Models\TshirtImage;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $tshirtImage1 = TshirtImage::inRandomOrder()->limit(1)->get();
        $tshirtImage2 = TshirtImage::inRandomOrder()->limit(1)->get();
        $tshirtImage3 = TshirtImage::inRandomOrder()->limit(1)->get();
        $tshirtImage4 = TshirtImage::inRandomOrder()->limit(1)->get();
        $tshirtImage5 = TshirtImage::inRandomOrder()->limit(1)->get();
        $tshirtImage6 = TshirtImage::inRandomOrder()->limit(1)->get();
        $tshirtImage7 = TshirtImage::inRandomOrder()->limit(1)->get();
        $tshirtImage8 = TshirtImage::inRandomOrder()->limit(1)->get();

        return view('welcome', compact('tshirtImage1', 'tshirtImage2', 'tshirtImage3', 'tshirtImage4', 'tshirtImage5', 'tshirtImage6', 'tshirtImage7', 'tshirtImage8'));
    }
}
