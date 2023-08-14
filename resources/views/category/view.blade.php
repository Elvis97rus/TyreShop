<x-app-layout>
    <div  class="mx-auto">
        <div class="flex justify-between">
            <h1>Brand </h1>

            <div class="lg:col-span-3">
                <img src="{{$category->image}}" alt="image {{$category->name}}">
            </div>
            <div class="lg:col-span-2">
                <h1 class="text-xl font-semibold">
                    {{$category->name}}
                </h1>
                <div class="mb-6" x-data="{expanded: false}">
                    <div
                        x-show="expanded"
                        x-collapse.min.120px
                        class="text-gray-500 wysiwyg-content"
                    >
                        {{ $category->description }}
                    </div>
                </div>
            </div>
        </div>
        <p class="font-bold my-4">Brand Product List</p>
        <div>
            {{--            {{$category->products->where('published', 1)}}--}}

            <?php if ($category->products->where('published', 1)->count() === 0): ?>
            <div class="text-center text-gray-600 py-16 text-xl">
                There are no products published
            </div>
            <?php else: ?>
            <div
                class="grid gap-6 grid-cols-6 lg:grid-cols-5 p-5"
            >
                @foreach($category->products->where('published', 1) as $product)
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
            <?php endif; ?>
        </div>
    </div>
</x-app-layout>
