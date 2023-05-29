<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::all();
        $selectedCategoryId = $request->input('category');
        $query = Category::query();

        if ($selectedCategoryId) {
            $query->where('category_id', $selectedCategoryId);
        }

        $selectedCategory = $query->first();
        $allTshirtImages = $selectedCategory ? $selectedCategory->tshirtImages()->paginate(20) : [];

        return view('catalog.index', compact('allTshirtImages', 'categories'));
    }
}
