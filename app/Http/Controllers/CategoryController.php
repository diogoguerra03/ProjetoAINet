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
    public function showCategories(): View
    {
        $categories = Category::all();
        return view('dashboard.categories', compact('categories'));
    }


    public function addCategory(): View
    {
        return view('dashboard.addCategory');
    }

    public function storeCategory(CategoryRequest $request): RedirectResponse
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

    public function deleteCategory(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->back()
            ->with('alert-msg', "Category $category->name deleted successfully.")
            ->with('alert-type', 'success');
    }

    public function editCategory(Category $category): View
    {
        return view('dashboard.editCategory', compact('category'));
    }

    public function updateCategory(CategoryRequest $request, Category $category): RedirectResponse
    {
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
