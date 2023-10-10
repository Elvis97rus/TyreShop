<?php
/** @var \Illuminate\Database\Eloquent\Collection $products */
?>

<x-app-layout>
    @section('meta_title', 'Купить шины в магазине TyreShop по выгодной цене.')
    @section('meta_description', 'В магазине TyreShop вы найдете зимние и летние шины от 17 до 22 радиуса, по удивительным ценам! Звоните, спешите купить! Всё что представлено - в наличии!')
    <div class="">
        <form method="POST" action="{{route('home.search')}}" class="flex w-full flex-wrap md:flex-nowrap justify-around gap-2">
            @csrf
            @method('POST')
            <input name="search"
                   class="appearance-none relative block mw-100 w-full px-4 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                   placeholder="Поиск товаров... (например Pirelli 215/65 или 255/65R17)">
            <select name="brand" id="brand" class="ml-3 px-2 md:px-4">
                <option value="" name="search"
                        class="appearance-none relative block w-48 px-3 py-1 md:py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    Марка шин
                </option>
                @foreach($categories as $category)
                    <option value="{{$category->name}}" name="search"
                            @selected(isset($params) && isset($params['brand']) && $params['brand'] == $category->name) class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                        {{$category->name}}
                    </option>
                @endforeach
            </select>
            <div class="flex p-2 md:p-3">
                <label for="thorn" class="m-auto p-2">Шипы</label>
                <input type="checkbox"
                       @checked(isset($params) && isset($params['thorn']) && $params['thorn'] == 'on') name="thorn"
                       class="p-2 m-auto" id="thorn"/>
            </div>
            <div class="px-4 py-3 flex justify-between m-auto md:w-1/4 gap-2">
                <span class="text-center">
                    <label class="" for="season_all">Все</label>
                    <input type="radio"
                       @checked(isset($params) && isset($params['season']) && !in_array($params['season'], ['winter', 'summer'])) name="season"
                       class="" value="all" id="season_all"/>
                </span>
                <span class="text-center">
                    <label class="" for="season_winter">Зимние</label>
                    <input type="radio"
                           @checked(isset($params) && isset($params['season']) && $params['season'] == 'winter')  name="season"
                           class="" value="winter" id="season_winter"/>
                </span>
                <span>
                    <label class="" for="season_summer">Летние</label>
                    <input type="radio"
                           @checked(isset($params) && isset($params['season']) && $params['season'] == 'summer') name="season"
                           class="" value="summer" id="season_summer"/>
                </span>
            </div>

            <input type="submit" class="btn btn-primary btn-danger w-48" value="Поиск"/>
        </form>
    </div>
    <?php if ($products->count() === 0): ?>
    <div class="text-center text-gray-600 py-16 text-xl">
        There are no products published
    </div>
    <?php else: ?>
    <div
        class="grid gap-3 md:gap-6 grid-cols-2 lg:grid-cols-5 p-2 md:p-5"
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
                    <h3 class="text-md md:text-lg">
                        <a href="{{ route('product.view', $product->slug) }}">
                            {{$product->title}}
                        </a>
                    </h3>
                    <div class="flex flex-col justify-between">
                        <div class="flex flex-col justify-start min-h-[140px]">
                            @if(is_array($rest = json_decode($product->rest)))
                                @foreach($rest as $item)
                                    <p class="font-semibold mt-2">Остаток: {{$item->rest}} шт.</p>
                                    <p class="font-semibold">Склад: №{{$item->wrh}}</p>
                                    <p class="font-semibold">Доставка со склада: {{\App\Services\WarehouseService::logisticDays($item->wrh) != '0' ?: '1'}} д.</p>
                                @endforeach
                            @else
                                <p class="font-semibold">Остаток: {{$rest->rest}} шт.</p>
                                <p class="font-semibold">Склад: №{{$rest->wrh}}</p>
                                <p class="font-semibold">Доставка со склада: {{\App\Services\WarehouseService::logisticDays($rest->wrh) != '0' ?: '1'}} д.</p>
                            @endif
                        </div>
                        <div class="flex flex-col justify-between py-2">
                            @if(auth()->user() && (!auth()->user()->customer || auth()->user()->customer->is_manager))
                                <div>
                                    <p class="font-semibold text-gray-400 py-2">Опт. &#8381;{{$product->price_opt}}</p>
                                    <p class="font-semibold text-gray-400">Розн. &#8381;{{$product->price_rozn}}</p>
                                    <p class="font-bold py-2">Цена: &#8381;{{$product->price}}</p>
                                </div>
                            @else
                                <p class="font-semibold text-gray-400 line-through">Цена: &#8381;{{$product->price_rozn}}</p>
                                <p class="font-bold">Цена: &#8381;{{$product->price}}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex justify-center py-3 px-4">
                    <button class="btn-primary" @click="addToCart()">
                        Добавить в корзину
                    </button>
                </div>
            </div>
            <!--/ Product Item -->
        @endforeach
    </div>
    {{$products->links()}}
    <?php endif; ?>
</x-app-layout>
