<?php

namespace App\Http\Controllers;

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

    public function addCategory(CategoryController $request): RedirectResponse
    {
        $category = new Category();
        $category->name = $request->input('name');
        $category->save();

        return redirect()->back()
            ->with('alert-msg', "Category added successfully.")
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

    public function updateCategory(CategoryController $request, Category $category): RedirectResponse
    {
        $category->name = $request->input('name');
        $category = DB::table('categories')->where('id', $category->id)->update(['name' => $category->name]);

        return redirect()->route('dashboard.showCategories', $category)
            ->with('alert-msg', "Category successfully.")
            ->with('alert-type', 'success');
    }
}