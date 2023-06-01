<?php

namespace App\Http\Controllers;

use App\Models\TshirtImage;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $popularProducts = TshirtImage::inRandomOrder()->whereNull('customer_id')->whereNull('deleted_at')->take(4)->get();
        $newArrivals = TshirtImage::orderBy('created_at', 'desc')->whereNull('customer_id')->whereNull('deleted_at')->take(4)->get();

        return view('welcome', compact('popularProducts', 'newArrivals'));
    }
}