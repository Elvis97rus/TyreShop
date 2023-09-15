<x-app-layout :meta_title="$product->meta_title ?? $product->title">
    @section('meta_title', $product->meta_title ?? $product->title)
    @section('meta_description', $product->meta_description ?? $product->title)
{{--    {{dd($product->meta_title)}}--}}
    <div  x-data="productItem({{ json_encode([
                    'id' => $product->id,
                    'slug' => $product->slug,
                    'image' => $product->image,
                    'title' => $product->title,
                    'price' => $product->price,
                    'addToCartUrl' => route('cart.add', $product)
                ]) }})" class="container mx-auto">
        <div class="grid gap-6 grid-cols-1 lg:grid-cols-5">
            <div class="lg:col-span-3">
                <div
                    x-data="{
                      images: ['{{$product->img_big_pish}}'],
                      activeImage: null,
                      prev() {
                          let index = this.images.indexOf(this.activeImage);
                          if (index === 0)
                              index = this.images.length;
                          this.activeImage = this.images[index - 1];
                      },
                      next() {
                          let index = this.images.indexOf(this.activeImage);
                          if (index === this.images.length - 1)
                              index = -1;
                          this.activeImage = this.images[index + 1];
                      },
                      init() {
                          this.activeImage = this.images.length > 0 ? this.images[0] : null
                      }
                    }"
                >
                    <div class="relative">
                        <template x-for="image in images">
                            <div
                                x-show="activeImage === image"
                                class="aspect-w-3 aspect-h-2"
                            >
                                <img :src="image" alt="" class="w-auto mx-auto"/>
                            </div>
                        </template>
                        <a
                            @click.prevent="prev"
                            class="cursor-pointer bg-black/30 text-white absolute left-0 top-1/2 -translate-y-1/2"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-10 w-10"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 19l-7-7 7-7"
                                />
                            </svg>
                        </a>
                        <a
                            @click.prevent="next"
                            class="cursor-pointer bg-black/30 text-white absolute right-0 top-1/2 -translate-y-1/2"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-10 w-10"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                        </a>
                    </div>
                    <div class="flex">
                        <template x-for="image in images">
                            <a
                                @click.prevent="activeImage = image"
                                class="cursor-pointer w-[80px] h-[80px] border border-gray-300 hover:border-purple-500 flex items-center justify-center"
                                :class="{'border-purple-600': activeImage === image}"
                            >
                                <img :src="image" alt="" class="w-auto max-auto max-h-full"/>
                            </a>
                        </template>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2">
                <h1 class="text-lg font-semibold">
                    {{$product->title}}
                </h1>
                <div class="flex flex-col sm:flex-row justify-between mt-4">
                    <div class="text-xl font-bold flex flex-col">
                        @if(is_array($rest = json_decode($product->rest)))
                            @foreach($rest as $item)
                                <p class="font-semibold mt-2">Остаток: {{$item->rest}}</p>
                                <p class="font-semibold">Склад: {{$item->wrh}}</p>
                                <p class="font-semibold">Доставка со склада: {{\App\Services\WarehouseService::logisticDays($item->wrh) != '0' ?: '1'}} д.</p>
                            @endforeach
                        @else
                            <p class="font-semibold">Остаток: {{$rest->rest}}</p>
                            <p class="font-semibold">Склад: {{$rest->wrh}}</p>
                            <p class="font-semibold">Доставка со склада: {{\App\Services\WarehouseService::logisticDays($rest->wrh) != '0' ?: '1'}} д.</p>
                        @endif
                    </div>
                    <div class="text-xl font-bold mb-6">
                        @if(auth()->user() && (!auth()->user()->customer || auth()->user()->customer->is_manager))
                            <p class="font-semibold text-gray-400 py-2">Опт. &#8381;{{$product->price_opt}}</p>
                            <p class="font-semibold text-gray-400">Розн. &#8381;{{$product->price_rozn}}</p>
                            <p class="font-bold py-2">Цена: &#8381;{{$product->price}}</p>
                        @else
                            <p class="font-semibold text-gray-400 line-through">Цена: &#8381;{{$product->price_rozn}}</p>
                            <p class="font-bold py-2">Цена: &#8381;{{$product->price}}</p>
                        @endif

                    </div>
                </div>
                <div class="flex items-center justify-between mb-5">
                    <label for="quantity" class="block font-bold mr-4">
                        Количество
                    </label>
                    <input
                        type="number"
                        name="quantity"
                        x-ref="quantityEl"
                        value="1"
                        min="1"
                        class="w-32 focus:border-purple-500 focus:outline-none rounded"
                    />
                </div>
                <button
                    @click="addToCart($refs.quantityEl.value)"
                    class="btn-primary py-4 text-lg flex justify-center min-w-0 w-full mb-6"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 mr-2"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                        />
                    </svg>
                    Добавить в корзину
                </button>
                <div class="mb-6" x-data="{expanded: false}">
                    <div
                        x-show="expanded"
                        x-collapse.min.120px
                        class="text-gray-500 wysiwyg-content"
                    >
                        {{ $product->description }} <p>Какое то невероятное СЕО описание которое можно скрыть кликнув по кнопке.</p> <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus minus, repellendus. Ab architecto, dignissimos dolor facilis iusto minus nam necessitatibus, nemo nobis sit temporibus totam veniam voluptas! Amet at corporis explicabo quisquam?Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus minus, repellendus. Ab architecto, dignissimos dolor facilis iusto minus nam necessitatibus, nemo nobis sit temporibus totam veniam voluptas! Amet at corporis explicabo quisquam?Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus minus, repellendus. Ab architecto, dignissimos dolor facilis iusto minus nam necessitatibus, nemo nobis sit temporibus totam veniam voluptas! Amet at corporis explicabo quisquam?Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus minus, repellendus. Ab architecto, dignissimos dolor facilis iusto minus nam necessitatibus, nemo nobis sit temporibus totam veniam voluptas! Amet at corporis explicabo quisquam?</p>
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
    </div>
</x-app-layout>
