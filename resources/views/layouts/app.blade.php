<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title') {{ config('app.name', 'TyreShop') }}</title>
    <meta name="description" content="@yield('meta_description')">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body x-data="{
            'isModalOpen': false,
            init() {
               setTimeout(() => {
                this.isModalOpen = true
               }, 1500)
               setTimeout(() => {
                this.isModalOpen = false
               }, 10000)
            }
        }"
      x-on:keydown.escape="isModalOpen=false">
    <div
        class="modal flex align-items-center justify-center fixed z-10 w-[100%] h-[100%] bg-opacity-70 bg-gray-200"
        role="dialog"
        tabindex="-1"
        x-show="isModalOpen"
        x-on:click.away="isModalOpen = false"
        x-transition
    >
        <div class="model-inner bg-white rounded-lg max-w-[600px] p-6 m-auto">
            <div class="modal-header flex align-items-center justify-between border-b-2 border-black">
                <h3>Уведомление от службы доставки!</h3>
                <button aria-label="Close" x-on:click="isModalOpen=false" class="text-red-600 text-xl">✖</button>
            </div>
            <p>
                В связи с большим потоком заказов, стандартные сроки доставки увеличены и составляют на 1-2 дня больше.
                Просим принять это во внимание и совершать заказы немного раньше, чтобы успеть до снега!
            </p>
        </div>
    </div>
    @include('layouts.navigation')

    <main class="p-5">
        {{ $slot }}
    </main>

    <!-- Toast -->
    <div
        x-data="toast"
        x-show="visible"
        x-transition
        x-cloak
        @notify.window="show($event.detail.message)"
        class="fixed w-[400px] left-1/2 -ml-[200px] top-16 py-2 px-4 pb-4 bg-transparent text-white"
    >
        <div class="font-semibold bg-emerald-600 px-6 py-2 pb-4" x-text="message"></div>

        <button
            @click="close"
            class="absolute flex items-center justify-center right-4 top-4 w-[30px] h-[30px] rounded-full hover:bg-black/10 transition-colors"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>
        </button>
        <!-- Progress -->
        <div>
            <div
                class="absolute left-0 bottom-0 right-0 h-[6px] bg-black/10"
                :style="{'width': `${percent}%`}"
            ></div>
        </div>
    </div>
    <!--/ Toast -->
</body>
</html>
