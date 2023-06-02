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
        $categories = Category::all()->whereNull('deleted_at')->sortBy('name');
        $filterByCategory = $request->category ?? '';
        $filterByName = $request->name ?? '';
        $filterByDescription = $request->description ?? '';
        $tshirtQuery = TshirtImage::whereNull('customer_id')->whereNull('deleted_at');

        if ($filterByCategory !== '') {
            $tshirtQuery = $tshirtQuery->where('category_id', $filterByCategory);
        }
        if ($filterByName !== '') {
            $imagesId = TshirtImage::where('name', 'like', "%$filterByName%")->pluck('id'); // pluck retorna um array com os ids
            $tshirtQuery->whereIn('id', $imagesId);
        }
        if ($filterByDescription !== '') {
            $imagesId = TshirtImage::where('description', 'like', "%$filterByDescription%")->pluck('id'); // pluck retorna um array com os ids
            $tshirtQuery->whereIn('id', $imagesId);
        }

        $orderBy = $request->orderBy ?? 'created_at'; // Ordenação padrão
        $orderByColumn = 'created_at'; // Coluna padrão para ordenação
        $orderByDirection = 'desc'; // Direção padrão para ordenação

        if ($orderBy === 'name_asc') {
            $orderByColumn = 'name';
            $orderByDirection = 'asc';
        } elseif ($orderBy === 'name_desc') {
            $orderByColumn = 'name';
        } elseif ($orderBy === 'older_arrivals') {
            $orderByColumn = 'created_at';
            $orderByDirection = 'asc';
        } elseif ($orderBy === 'new_arrivals') {
            $orderByColumn = 'created_at';
        }

        $tshirtImages = $tshirtQuery->with('category')
            ->orderBy($orderByColumn, $orderByDirection)
            ->paginate(18);

        $prices = Price::all(); // Busca todos os preços

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