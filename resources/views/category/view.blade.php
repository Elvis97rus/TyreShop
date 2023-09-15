<x-app-layout>
    <div  class="mx-auto">
        <div class="flex justify-between flex-col md:flex-row ">
            <div class="w-full md:w-1/3">
                <h1 class="text-center text-gray-600 py-4 text-xl">Бренд / Марка {{$category->name}}</h1>
                <div class="p-4">
                    <img class="mx-auto" src="{{$category->image ?? 'https://place-hold.it/500x300'}}" alt="Шины бренда {{$category->name}}">
                </div>
            </div>
            <div class="lg:col-span-2 w-full md:max-w-2/3 px-4">
                <div class="text-xl font-semibold text-left">
                    О шинах марки {{$category->name}}
                </div>
                <div class="mb-6" x-data="{expanded: false}">
                    <div
                        x-show="expanded"
                        x-collapse.min.80px
                        class="text-gray-500 wysiwyg-content"
                    >
                        {{ $category->description ?? 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi debitis, exercitationem illum nesciunt odit quibusdam quis quod quos sapiente voluptas. Eaque id non obcaecati optio qui, rem sequi sint suscipit veniam. Aliquid consequatur culpa eum expedita hic maxime perferendis quas sit tempora vitae? Ab, architecto error iste nam porro quibusdam reiciendis? Accusantium consectetur deserunt explicabo fuga molestiae nulla officiis, omnis possimus quae quasi quis, reiciendis sapiente! Accusamus, asperiores at blanditiis eos error laborum soluta temporibus. Asperiores atque dolorem exercitationem facilis ipsum nemo quas sed tempora voluptates? Molestias, repudiandae!' }}
                    </div>
                    <p class="text-right">
                        <a
                            @click="expanded = !expanded"
                            href="javascript:void(0)"
                            class="text-purple-500 hover:text-purple-700"
                            x-text="expanded ? 'Скрыть описание' : 'Читать описание'"
                        ></a>
                    </p>
                </div>
            </div>
        </div>
        <p class="font-bold my-4">Шины бренда / марки {{$category->name}}</p>
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
                                <div class="flex flex-row justify-end py-2">
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
                        <div class="flex justify-between py-3 px-4 ">
                            <button class="btn-primary mx-auto" @click="addToCart()">
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
