<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\TshirtImage;
use App\Models\Price;
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
        $tshirtQuery = TshirtImage::whereNull('customer_id')->whereNull('deleted_at');
        $orderBy = $request->orderBy ?? 'created_at'; // Ordenação padrão

        if ($filterByCategory !== '') {
            $tshirtQuery = $tshirtQuery->where('category_id', $filterByCategory);
        }
        if ($filterByName !== '') {
            $imagesId = TshirtImage::where('name', 'like', "%$filterByName%")->pluck('id');
            $tshirtQuery->whereIn('id', $imagesId);
        }
        if ($filterByDescription !== '') {
            $imagesId = TshirtImage::where('description', 'like', "%$filterByDescription%")->pluck('id');
            $tshirtQuery->whereIn('id', $imagesId);
        }

        $orderByColumn = 'created_at'; // Coluna padrão para ordenação
        $orderByDirection = 'asc'; // Direção padrão para ordenação

        if ($orderBy === 'name_asc') {
            $orderByColumn = 'name';
        } elseif ($orderBy === 'name_desc') {
            $orderByColumn = 'name';
            $orderByDirection = 'desc';
        } elseif ($orderBy === 'price_asc') {
            $orderByColumn = DB::raw('(SELECT unit_price_catalog FROM prices LIMIT 1)');
        } elseif ($orderBy === 'price_desc') {
            $orderByColumn = DB::raw('(SELECT unit_price_catalog FROM prices LIMIT 1)');
            $orderByDirection = 'desc';
        }

        $tshirtImages = $tshirtQuery->with('category')
            ->orderBy($orderByColumn, $orderByDirection)
            ->paginate(18);

        $prices = Price::all();

        return view(
            'catalog.index',
            compact(
                'tshirtImages',
                'categories',
                'filterByCategory',
                'filterByName',
                'filterByDescription',
                'orderBy',
                'prices'
            )
        );
    }


}