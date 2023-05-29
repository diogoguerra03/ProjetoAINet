<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\TshirtImage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TshirtImageController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::all();
        $selectedCategoryId = $request->input('category');
        $query = TshirtImage::query();

        if ($selectedCategoryId) {
            $query->where('category_id', $selectedCategoryId);
        }

        $allTshirtImages = $query->paginate(20);

        return view('catalog.index', compact('allTshirtImages', 'categories', 'selectedCategoryId'));
    }
}
