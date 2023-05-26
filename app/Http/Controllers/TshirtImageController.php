<?php

namespace App\Http\Controllers;

use App\Models\TshirtImage;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TshirtImageController extends Controller
{
    public function index(): View
    {
        $allTshirtImages = TshirtImage::paginate(20);
        return view('catalog.index', compact('allTshirtImages'));
    }
}