<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\TshirtImage;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TshirtImageController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::all();
        $filterByCategory = $request->category ?? '';
        $filterByName = $request->name ?? '';
        $filterByDescription = $request->description ?? '';
        $tshirtQuery = TshirtImage::query();

        if ($filterByCategory !== '') {
            $tshirtQuery = $tshirtQuery->where('category_id', $filterByCategory);
        }
        if ($filterByName !== '') {
            $imagesId = TshirtImage::where('name', 'like', "%$filterByName%")->pluck('id'); // pluck retorna um array com os ids
            $tshirtQuery->whereIntegerInRaw('id', $imagesId);
        }
        if ($filterByDescription !== '') {
            $imagesId = TshirtImage::where('description', 'like', "%$filterByDescription%")->pluck('id'); // pluck retorna um array com os ids
            $tshirtQuery->whereIntegerInRaw('id', $imagesId);
        }

        $tshirtImages = $tshirtQuery->with('category')->paginate(20);
        return view('catalog.index', compact('tshirtImages', 'categories', 'filterByCategory', 'filterByName', 'filterByDescription'));
    }
}