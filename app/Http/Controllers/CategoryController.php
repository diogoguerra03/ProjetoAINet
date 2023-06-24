<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
    }

    //categories
    public function index(): View
    {
        $categories = Category::all();
        return view('dashboard.categories', compact('categories'));
    }


    public function create(): View
    {
        return view('dashboard.addCategory');
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $category = DB::transaction(function () use ($data, $request) {
            $category = new Category();
            $category->name = $data['name'];
            $category->save();
        });

        $htmlMessage = "Category was successfully created!";

        return redirect()->route('dashboard.showCategories')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function delete(Category $category): RedirectResponse
    {
        if (count($category->tshirtImages) != 0) {
            $category->delete();
        } else {
            $category->forceDelete();
        }

        return redirect()->back()
            ->with('alert-msg', "Category $category->name deleted successfully.")
            ->with('alert-type', 'success');
    }

    public function edit(Category $category): View
    {
        return view('dashboard.editCategory', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        if (count($category->tshirtImages) != 0) {
            return redirect()->route('dashboard.showCategories')
                ->with('alert-msg', "Category $category->name cannot be updated because it is in use.")
                ->with('alert-type', 'error');
        }

        $formData = $request->validated();
        $category = DB::transaction(function () use ($formData, $category) {
            $category->name = $formData['name'];

            $category->save();
            return $category;
        });

        $htmlMessage = "Category $category->name was successfully updated!";

        return redirect()->route('dashboard.showCategories')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }


}