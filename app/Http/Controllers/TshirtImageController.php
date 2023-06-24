<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Price;
use App\Models\Category;
use App\Models\TshirtImage;

use Illuminate\Foundation\Auth\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TshirtImageRequest;

class TshirtImageController extends Controller
{
    // construct
    public function __construct()
    {
        $this->authorizeResource(TshirtImage::class, 'catalog');
    }

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

        $tshirts = $tshirtQuery->paginate(18); // Paginação

        $prices = Price::all(); // Busca todos os preços

        return view(
            'catalog.index',
            compact(
                'tshirts',
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

    public function myTshirts(Request $request, User $user): View
    {
        $currentUser = auth()->user();

        if ($currentUser->id !== $user->id) {
            $user = $currentUser;
        }

        if ($user->user_type !== 'C') {
            abort(403); // Retorna uma resposta de acesso negado
        }

        $tshirts = TshirtImage::where('customer_id', $user->id)->get();

        return view('profile.mytshirts', compact('user', 'tshirts'));
    }

    public function createMyTshirt(User $user): View
    {
        $currentUser = auth()->user();

        if ($currentUser->id !== $user->id) {
            $user = $currentUser;
        }

        if ($user->user_type !== 'C') {
            abort(403); // Retorna uma resposta de acesso negado
        }

        return view('tshirts.create', compact('user'));
    }

    public function storeMyTshirt(TshirtImageRequest $request, TshirtImage $catalog): RedirectResponse
    {
        $formData = $request->validated();
        $catalog = DB::transaction(function () use ($formData, $request) {
            $catalog = new TshirtImage();
            $catalog->name = $formData['name'];
            $catalog->description = $formData['description'];
            $catalog->category_id = $formData['category_id'];
            $catalog->customer_id = $formData['customer_id'];

            if ($request->hasFile('image_url')) {
                $path = Storage::putFile('tshirt_images_private', $request->file('image_url'));
                $filename = basename($path);
                $catalog->image_url = $filename;
            }

            $catalog->save();

            return $catalog;
        });

        $htmlMessage = "Product $catalog->name was successfully stored!";
        return redirect()->route('profile.mytshirts', auth()->user())
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function editMyTshirt(User $user, string $slug): View
    {
        $currentUser = auth()->user();

        if ($currentUser->id !== $user->id) {
            $user = $currentUser;
        }

        if ($user->user_type !== 'C') {
            abort(403); // Retorna uma resposta de acesso negado
        }

        $tshirtImage = TshirtImage::findOrFail(strtok($slug, '-'));

        return view('tshirts.edit', compact('user', 'tshirtImage'));
    }

    public function updateMyTshirt(TshirtImageRequest $request, User $user, string $slug): RedirectResponse
    {
        // Get the authenticated user
        $authenticatedUser = auth()->user();

        // Check if the authenticated user is the same as the user in the route parameter
        if ($authenticatedUser->id != $user->id) {
            // User is not authorized, redirect back or show an error message
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $formData = $request->validated();
        $tshirtImage = TshirtImage::findOrFail(strtok($slug, '-'));

        $tshirtImage = DB::transaction(function () use ($formData, $tshirtImage) {
            $tshirtImage->name = $formData['name'];
            $tshirtImage->description = $formData['description'];

            $tshirtImage->save();

            return $tshirtImage;
        });

        $htmlMessage = "Product $tshirtImage->name was successfully updated!";

        return redirect()->route('profile.mytshirts', auth()->user())
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function destroyMyTshirt(User $user, string $slug): RedirectResponse
    {
        $currentUser = auth()->user();

        if ($currentUser->id !== $user->id) {
            $user = $currentUser;
        }

        if ($user->user_type !== 'C') {
            abort(403); // Retorna uma resposta de acesso negado
        }

        $tshirtImage = TshirtImage::findOrFail(strtok($slug, '-'));

        if ($tshirtImage->orderItems()->exists()) {
            $tshirtImage->delete();
        } else {
            Storage::delete('tshirt_images_private/' . $tshirtImage->image_url);
            $tshirtImage->forceDelete();
        }

        return redirect()->route('profile.mytshirts', $user)
            ->with('alert-msg', 'Image deleted successfully.')
            ->with('alert-type', 'success');
    }

    public function getfile(string $slug)
    {
        $tshirtImage = TshirtImage::findOrFail(strtok($slug, '-'));
        $path = $tshirtImage->image_url;
        $customerID = $tshirtImage->customer_id;
        $user = auth()->user();
        if ($customerID !== null && $user !== null && $user->id === $customerID) {
            return response()->file(storage_path('app/tshirt_images_private/' . $path));
        }
        return response()->file(public_path('storage/tshirt_images/' . $path));
    }

    public function show(TshirtImage $catalog): View
    {
        $user = auth()->user();
        $colors = Color::whereNull('deleted_at')->orderBy('name')->pluck('name', 'code');

        $price = Price::all();

        return view('catalog.show', compact('catalog', 'colors', 'price', 'user'));

    }

    public function create(): View
    {
        $categories = Category::all()->whereNull('deleted_at')->sortBy('name');

        return view('catalog.create', compact('categories'));
    }

    public function store(TshirtImageRequest $request, TshirtImage $catalog): RedirectResponse
    {
        $formData = $request->validated();
        $catalog = DB::transaction(function () use ($formData, $request) {
            $catalog = new TshirtImage();
            $catalog->name = $formData['name'];
            $catalog->description = $formData['description'];
            $catalog->category_id = $formData['category_id'];

            if ($request->hasFile('image_url')) {
                $path = $request->file('image_url')->store('public/tshirt_images');
                $filename = basename($path);
                $catalog->image_url = $filename;
            }

            $catalog->save();

            return $catalog;
        });

        $htmlMessage = "Product $catalog->name was successfully stored!";
        return redirect()->route('catalog.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function edit(TshirtImage $catalog): View
    {
        $tshirtImage = $catalog;
        $categories = Category::all()->whereNull('deleted_at')->sortBy('name');

        return view('catalog.edit', compact('tshirtImage', 'categories'));
    }


    public function update(TshirtImageRequest $request, TshirtImage $catalog): RedirectResponse
    {

        $formData = $request->validated();
        $catalog = DB::transaction(function () use ($formData, $catalog, $request) {
            $catalog->name = $formData['name'];
            $catalog->description = $formData['description'];
            $catalog->category_id = $formData['category_id'];

            if ($request->hasFile('image')) {
                if ($catalog->image_url) {
                    Storage::delete('public/tshirt_images/' . $catalog->image_url);
                }

                $path = $request->file('image')->store('public/tshirt_images');
                $filename = basename($path);
                $catalog->image_url = $filename;
            }

            $catalog->save();

            return $catalog;
        });

        $htmlMessage = "Product $catalog->name was successfully updated!";

        return redirect()->route('catalog.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function destroy(TshirtImage $catalog): RedirectResponse
    {
        // $this->authorize('delete', TshirtImage::class);
        if ($catalog->orderItems()->exists()) {
            $catalog->delete();
        } else {
            Storage::delete('public/tshirt_images/' . $catalog->image_url); // Excluir a imagem privada
            $catalog->forceDelete();
        }

        return redirect()->route('catalog.index')
            ->with('alert-msg', 'Image deleted successfully.')
            ->with('alert-type', 'success');
    }

    public function getImage(string $tshirtUrl)
    {
        $tshirtImage = TshirtImage::where('image_url', $tshirtUrl)->first();
        $path = $tshirtImage->image_url;
        $customerID = $tshirtImage->customer_id;
        if ($customerID !== null) {
            return response()->file(storage_path('app/tshirt_images_private/' . $path));
        }
        return response()->file(public_path('storage/tshirt_images/' . $path));
    }
}