<?php
/** @var \Illuminate\Database\Eloquent\Collection $categories */
?>

<x-app-layout>
    @section('meta_title', 'Купить шины по категориям в магазине TyreShop по выгодной цене.')
    @section('meta_description', 'Купить по брендам шины на летний и зимний сезон, 17-22 радиуса в TyreShop по удивительным ценам! Доставим быстрее всех! Товар всегда в наличии!')
    <?php if ($categories->count() === 0): ?>
        <div class="text-center text-gray-600 py-16 text-xl">
            Нет марок / брендов
        </div>
    <?php else: ?>

        <div>
            <h1 class="text-center text-gray-600 py-4 text-xl">Список Брендов / Марок</h1>
        </div>
        <div
            class="grid gap-6 grid-cols-3 lg:grid-cols-5 p-5"
        >
            @foreach($categories as $category)
                <a href="{{ route('category.view', $category->slug) }}"
                   class="logotype2">
                    <span>{{$category->name}}</span>
                </a>
            @endforeach
        </div>
        {{$categories->links()}}
    <?php endif; ?>
</x-app-layout>
