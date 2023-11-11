<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::query()->orderBy('name', 'asc')->get();
        $products = Product::query()
            ->where('product_type', '=', 'tyre')
            ->where('published', '=', 1)
            ->orderBy('updated_at', 'desc')
            ->paginate(30);

        return view('product.index', compact('products', 'categories'));
    }
    public function search(Request $request)
    {
//        dd($request);
        $categories = Category::query()->orderBy('name', 'asc')->get();
        $products = Product::query()
            ->where('published', '=', 1)
            ->where('product_type', '=', 'tyre');

        if (isset($request->thorn) && $request->thorn == 'on'){
            $products = $products->where('thorn', true);
        }
        if (isset($request->search) && strlen($request->search) > 0){
            $products = $products->where('title', 'like',  '%'.$request->search.'%');
        }
        if (isset($request->width) && isset($request->height) && strlen($request->height) > 0 && strlen($request->width) > 0){
            $products = $products->where('title', 'like',  '%'.$request->width.'/'. $request->height.'%');
        }
        if (isset($request->radius) && strlen($request->radius) > 0){
            $products = $products->where('title', 'like',  '%R'.$request->radius.'%');
        }
        if (isset($request->brand) && strlen($request->brand) > 0){
            $products = $products->where('marka', $request->brand);
        }

        if (isset($request->season) && ($request->season == 'winter' || $request->season == 'summer')){
            $season = $request->season == 'winter' ? 'w' : 's';
            $products = $products->where('season', $season);
        }

        $products = $products->orderBy('price', 'desc')
            ->paginate(30);

        // прокидываем обратно параметры фильтрации
        $params = [
            'thorn' => $request->thorn,
            'search' => $request->search,
            'brand' => $request->brand,
            'season' => $request->season,
            'height' => $request->height,
            'width' => $request->width,
            'radius' => $request->radius,
        ];
        return view('product.index', compact('products', 'categories', 'params'));
    }

    // TODO передавать на фронт словарь названий для складов

    public function view(Product $product)
    {
        return view('product.view', ['product' => $product]);
    }
}
