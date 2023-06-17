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
        $user = auth()->user();
        $categories = Category::all()->whereNull('deleted_at')->sortBy('name');
        $filterByCategory = $request->category ?? '';
        $filterByName = $request->name ?? '';
        $filterByDescription = $request->description ?? '';

        // Construir a query base para as imagens de camiseta
        $tshirtQuery = TshirtImage::whereNull('deleted_at');

        // Verificar se o usuário é do tipo "C" e filtrar as imagens de camiseta correspondentes
        if ($user !== null) {
            if ($user->user_type === 'C') {
                $tshirtQuery->where(function ($query) use ($user) {
                    $query->whereNull('customer_id')
                        ->orWhere('customer_id', $user->id);
                });
            }
        } else {
            $tshirtQuery->whereNull('customer_id');
        }


        if ($filterByCategory !== '' && $filterByCategory !== 'my_products') {
            $tshirtQuery = $tshirtQuery->where('category_id', $filterByCategory);
        }
        if ($filterByName !== '') {
            $imagesId = TshirtImage::where('name', 'like', "%$filterByName%")->pluck('tshirt_images.id'); // pluck retorna um array com os ids
            $tshirtQuery->whereIn('tshirt_images.id', $imagesId);
        }
        if ($filterByDescription !== '') {
            $imagesId = TshirtImage::where('description', 'like', "%$filterByDescription%")->pluck('tshirt_images.id'); // pluck retorna um array com os ids
            $tshirtQuery->whereIn('tshirt_images.id', $imagesId);
        }
        if ($filterByCategory === 'my_products') {
            $imagesId = TshirtImage::where('customer_id', $user->id)->pluck('tshirt_images.id'); // pluck retorna um array com os ids
            $tshirtQuery->whereIn('tshirt_images.id', $imagesId);
        }

        $orderBy = $request->orderBy ?? 'popular_products'; // Ordenação padrão

        if ($orderBy === 'name_asc') {
            $tshirtQuery->orderBy('name', 'asc');
        } elseif ($orderBy === 'name_desc') {
            $tshirtQuery->orderBy('name', 'desc');
        } elseif ($orderBy === 'older_arrivals') {
            $tshirtQuery->orderBy('created_at', 'asc');
        } elseif ($orderBy === 'new_arrivals') {
            $tshirtQuery->orderBy('created_at', 'desc');
        } elseif ($orderBy === 'popular_products') {
            $tshirtQuery->leftJoin('order_items', 'tshirt_images.id', '=', 'order_items.tshirt_image_id')
                ->select('tshirt_images.*', DB::raw('SUM(order_items.qty) as total_quantity'))
                ->groupBy('tshirt_images.id')
                ->orderBy('total_quantity', 'desc');
        }

        $tshirtImages = $tshirtQuery->paginate(18); // Paginação

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
                'prices',
                'user'
            )
        );

    }

    public function getfile($path)
    {
        return response()->file(storage_path('app/tshirt_images_private/' . $path));
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

        $htmlMessage = "Product $tshirtImage->name was successfully updated!";

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