<?php
/** @var \Illuminate\Database\Eloquent\Collection $categories */
?>

<x-app-layout>
    <?php if ($categories->count() === 0): ?>
        <div class="text-center text-gray-600 py-16 text-xl">
            There are no Brands
        </div>
    <?php else: ?>

        <div>
            <h1>Brands List</h1>
        </div>
        <div
            class="grid gap-6 grid-cols-6 lg:grid-cols-5 p-5"
        >
            @foreach($categories as $category)
                <a href="{{ route('category.view', $category->slug) }}"
                   class="aspect-w-3 aspect-h-2 block overflow-hidden">
                    <img
                        src="{{ $category->image }}"
                        alt="{{$category->name}}"
                        class="object-cover rounded-lg hover:scale-105 hover:rotate-1 transition-transform"
                    />
                </a>
                <!-- Product Item -->
{{--                <div--}}
{{--                    x-data="productItem({{ json_encode([--}}
{{--                        'id' => $category->id,--}}
{{--                        'slug' => $category->slug,--}}
{{--                        'image' => $category->image,--}}
{{--                        'name' => $category->name,--}}
{{--                        'description' => $category->description,--}}
{{--                        'meta_description' => $category->meta_description,--}}
{{--                        'addToCartUrl' => ''--}}
{{--                    ]) }})"--}}
{{--                    class="border border-1 border-gray-200 rounded-md hover:border-purple-600 transition-colors bg-white"--}}
{{--                >--}}
{{--                    <a href="{{ route('category.view', $category->slug) }}"--}}
{{--                       class="aspect-w-3 aspect-h-2 block overflow-hidden">--}}
{{--                        <img--}}
{{--                            src="{{ $category->image }}"--}}
{{--                            alt=""--}}
{{--                            class="object-cover rounded-lg hover:scale-105 hover:rotate-1 transition-transform"--}}
{{--                        />--}}
{{--                    </a>--}}
{{--                    <div class="p-4">--}}
{{--                        <h3 class="text-lg">--}}
{{--                            <a href="{{ route('category.view', $category->slug) }}">--}}
{{--                                {{$category->title}}--}}
{{--                            </a>--}}
{{--                        </h3>--}}
{{--                        <h5 class="font-bold">${{$category->price}}</h5>--}}
{{--                    </div>--}}
{{--                    <div class="flex justify-between py-3 px-4">--}}
{{--                        <button class="btn-primary" @click="addToCart()">--}}
{{--                            Add to Cart--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <!--/ Product Item -->
            @endforeach
        </div>
        {{$categories->links()}}
    <?php endif; ?>
</x-app-layout>
