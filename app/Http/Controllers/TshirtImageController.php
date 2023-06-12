<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Price;
use App\Models\Category;
use Illuminate\View\View;
use App\Models\TshirtImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TshirtImageRequest;

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

        $orderBy = $request->orderBy ?? 'popular_products'; // Ordenação padrão
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
        } elseif ($orderBy === 'popular_products') {
            $tshirtQuery->leftJoin('order_items', 'tshirt_images.id', '=', 'order_items.tshirt_image_id')
                ->select('tshirt_images.*', DB::raw('SUM(order_items.qty) as total_quantity'))
                ->groupBy('tshirt_images.id')
                ->orderBy('total_quantity', 'desc');
        }

        $tshirtImages = $tshirtQuery->orderBy($orderByColumn, $orderByDirection)->paginate(18); // Paginação

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

    public function show(string $slug): View
    {
        $tshirtImage = TshirtImage::findOrFail(strtok($slug, '-'));
        $colors = Color::whereNull('deleted_at')->orderBy('name')->pluck('name', 'code');

        $price = Price::all()->first()->unit_price_catalog;

        return view('catalog.show', compact('tshirtImage', 'colors', 'price'));

    }

    public function edit(string $slug): View
    {
        $tshirtImage = TshirtImage::findOrFail(strtok($slug, '-'));
        $this->authorize('update', $tshirtImage);
        $categories = Category::all()->whereNull('deleted_at')->sortBy('name');

        return view('catalog.edit', compact('tshirtImage', 'categories'));
    }


    public function update(TshirtImageRequest $request, string $slug): RedirectResponse
    {
        $tshirtImage = TshirtImage::findOrFail(strtok($slug, '-'));

        $formData = $request->validated();
        $tshirtImage = DB::transaction(function () use ($formData, $tshirtImage, $request) {
            $tshirtImage->name = $formData['name'];
            $tshirtImage->description = $formData['description'];
            $tshirtImage->category_id = $formData['category_id'];

            if ($request->hasFile('image')) {
                if ($tshirtImage->image_url) {
                    Storage::delete('public/tshirt_images/' . $tshirtImage->image_url);
                }

                $path = $request->file('image')->store('public/tshirt_images');
                $filename = basename($path);
                $tshirtImage->image_url = $filename;
            }

            $tshirtImage->save();

            return $tshirtImage;
        });

        $url = route('catalog.show', $tshirtImage->slug);
        $htmlMessage = "Product <a href='$url'>#{$tshirtImage->id}</a>
                    <strong>\"{$tshirtImage->name}\"</strong> was successfully updated!";

        return redirect()->route('catalog.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function destroy(string $slug): RedirectResponse
    {
        $tshirtImage = TshirtImage::findOrFail(strtok($slug, '-'));

        if ($tshirtImage->orderItems()->exists()) {
            $tshirtImage->delete();
        } else {
            Storage::delete('public/tshirt_images/' . $tshirtImage->image_url);
            $tshirtImage->forceDelete();
        }

        return redirect()->route('catalog.index')
            ->with('alert-msg', 'Image deleted successfully.')
            ->with('alert-type', 'success');
    }




}