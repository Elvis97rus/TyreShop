<?php
/** @var \Illuminate\Database\Eloquent\Collection $products */
?>

<x-app-layout>
    <div class="container">
        <form method="POST" action="{{route('home.search')}}" class="flex w-full">
            @csrf
            @method('POST')
            <input name="search" class="appearance-none relative block mw-100 px-4 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                   placeholder="Type to Search categories">
            <select name="brand" id="brand" class="ml-3 px-4">
                <option value="" name="search" class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    Choose Brand
                </option>
                @foreach($categories as $category)
                    <option value="{{$category->name}}" name="search" @selected(isset($params) && isset($params['brand']) && $params['brand'] == $category->name) class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                        {{$category->name}}
                    </option>
                @endforeach
            </select>
            <div class="p-3">
                <label for="thorn" class="">Thorn</label>
                <input type="checkbox" @checked(isset($params) && isset($params['thorn']) && $params['thorn'] == 'on') name="thorn" class="m-3" id="thorn" />
            </div>
            <div class="px-4 py-3">
                <label class="" for="season_all">All</label>
                <input type="radio" @checked(isset($params) && isset($params['season']) && !in_array($params['season'], ['winter', 'summer'])) name="season" class="" value="all" id="season_all" />
                <label class="" for="season_winter">Winter</label>
                <input type="radio" @checked(isset($params) && isset($params['season']) && $params['season'] == 'winter')  name="season" class="" value="winter" id="season_winter" />
                <label class="" for="season_summer">Summer</label>
                <input type="radio" @checked(isset($params) && isset($params['season']) && $params['season'] == 'summer') name="season" class="" value="summer" id="season_summer" />
            </div>

            <input type="submit" class="btn btn-primary btn-danger" value="Search" />
        </form>
    </div>
    <?php if ($products->count() === 0): ?>
        <div class="text-center text-gray-600 py-16 text-xl">
            There are no products published
        </div>
    <?php else: ?>
        <div
            class="grid gap-6 grid-cols-6 lg:grid-cols-5 p-5"
        >
            @foreach($products as $product)
                <!-- Product Item -->
                <div
                    x-data="productItem({{ json_encode([
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'image' => $product->image,
                        'title' => $product->title,
                        'price' => $product->price,
                        'addToCartUrl' => route('cart.add', $product)
                    ]) }})"
                    class="border border-1 border-gray-200 rounded-md hover:border-purple-600 transition-colors bg-white flex flex-col justify-between"
                >
                    <a href="{{ route('product.view', $product->slug) }}"
                       class="flex justify-center block overflow-hidden">
                        <img
                            src="{{ $product->img_small }}"
                            alt=""
                            class="object-contain rounded-lg hover:scale-105 hover:rotate-1 transition-transform"
                        />
                    </a>
                    <div class="p-4">
                        <h3 class="text-lg">
                            <a href="{{ route('product.view', $product->slug) }}">
                                {{$product->title}}
                            </a>
                        </h3>
                        <div class="flex flex-2 justify-between">
                            <div class="flex flex-col justify-end">
                                <p class="font-semibold text-gray-400 py-2">Опт. &#8381;{{$product->price_opt}}</p>
                                <p class="font-semibold text-gray-400">Розн. &#8381;{{$product->price_rozn}}</p>
                                <p class="font-bold py-2">Цена: &#8381;{{$product->price}}</p>
                            </div>
                            <div class="flex flex-col justify-end">
                                @if(is_array($rest = json_decode($product->rest)))
                                    @foreach($rest as $item)
                                        <p class="font-semibold mt-2">Остаток: {{$item->rest}} шт.</p>
                                        <p class="font-semibold">Склад: №{{$item->wrh}}</p>
                                        <p class="font-semibold">Доставка со склада: {{\App\Services\WarehouseService::logisticDays($item->wrh)}} д.</p>
                                    @endforeach
                                @else
                                    <p class="font-semibold">Остаток: {{$rest->rest}} шт.</p>
                                    <p class="font-semibold">Склад: №{{$rest->wrh}}</p>
                                    <p class="font-semibold">Доставка со склада: {{\App\Services\WarehouseService::logisticDays($rest->wrh)}} д.</p>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between py-3 px-4">
                        <button class="btn-primary" @click="addToCart()">
                            Add to Cart
                        </button>
                    </div>
                </div>
                <!--/ Product Item -->
            @endforeach
        </div>
        {{$products->links()}}
    <?php endif; ?>
</x-app-layout>
