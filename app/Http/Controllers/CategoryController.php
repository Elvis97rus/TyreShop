<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->orderBy('id', 'desc')
            ->paginate(30);

        return view('category.index', [
            'categories' => $categories
        ]);
    }

    public function view(Category $category)
    {
        return view('category.view', ['category' => $category]);
    }
}
