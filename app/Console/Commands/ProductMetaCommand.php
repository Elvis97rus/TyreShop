<?php

namespace App\Console\Commands;

use App\Models\Api\Category;
use App\Models\Api\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use RicorocksDigitalAgency\Soap\Facades\Soap;
use SoapClient;
use App\Helpers\ImageHelper;

class ProductMetaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prod:meta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate products meta-data';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $products = Product::all();
        foreach ($products as $product) {
            if ($product->product_type == 'tyre'){
                $size = '';
                foreach (explode(' ', $product->title) as $part){
                    if (str_contains($part, '/') && str_contains($part, 'R')){
                        $size = explode('R', $part);
                    }
                }
                $thorn = $product->thorn ? 'шипованные ' : '';
                $season = $product->season == 'w' ? 'зимние ' : 'летние ';
                $str = "Купить {$thorn}{$season}шины марки $product->marka, размер $size[0] радиус R$size[1], модель $product->model в магазине TyreShop по выгодной цене!";
                $str_des = "Купить {$thorn}{$season}шины $product->marka модель $product->model размер $size[0] радиус R$size[1] в интернет–магазине TyreShop. Мы предлагаем широкий ассортимент продукции, индивидуальный подход к каждому клиенту, профессиональные консультации и гарантии на продукцию.";
                $product->meta_title = $str;
                $product->meta_description = $str_des;
                $product->save();
            }
        }
    }
}
