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

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        print_r('tut' . PHP_EOL);
        $client = Soap::to("http://api-b2b.4tochki.ru/WCF/ClientService.svc?wsdl");
        $params = array
        (
            'login' => config('app.four_tochki_login') ?? '',
            'password' => config('app.four_tochki_pass') ?? '',
            'filter' => array(
                'season_list' => array(0 => 'w', 1 => 's'),
                'width_min' => 175,
                'width_max' => 235,
                'height_min' => 55,
                'height_max' => 75,
                'diameter_min' => 17,
                'diameter_max' => 22,
            ),
            'page' => 0,
            'pageSize' => 1500,
        );
        $answer = $client->call('GetFindTyre', $params);
        $tyres = $answer->GetFindTyreResult->price_rest_list->TyrePriceRest;
        $warehouses = $answer->GetFindTyreResult->warehouseLogistics->WarehouseLogistic;

        // снимаем товары с публикации перед синхронизацией
        Product::where('product_type', 'tyre')->update(['published' => false]);
        $c = 1;
        $log = "SYNC TYRES LOG \n*************\n";
        foreach ($tyres as $tyre) {
            $no_image = false;

            $category = Category::where('name', $tyre->marka)->first();
            if (!$category) {
                $category = Category::create([
                    'name' => $tyre->marka,
                    'type' => 'tyre_category',
                    'slug' => str_replace(' ', '_', strtolower($tyre->marka))
                ]);
            }

            $price_opt = !is_array($tyre->whpr->wh_price_rest) ? $tyre->whpr->wh_price_rest->price : $tyre->whpr->wh_price_rest[0]->price;
            $price_rozn = !is_array($tyre->whpr->wh_price_rest) ? $tyre->whpr->wh_price_rest->price_rozn: $tyre->whpr->wh_price_rest[0]->price_rozn;

            $p = Product::where('code', 'tyre_' . $tyre->code)->first();


            if ($p && $p->id) {
                $data = [
                    'price' => !is_array($tyre->whpr->wh_price_rest) ? $tyre->whpr->wh_price_rest->price_rozn * 0.95 : $tyre->whpr->wh_price_rest[0]->price_rozn * 0.95,
                    'published' => true,
                    'price_opt' => $price_opt,
                    'price_rozn' => $price_rozn,
                    'rest' => json_encode($tyre->whpr->wh_price_rest),
                    'img_big_my' => $tyre->img_big_my,
                    'img_big_pish' => $tyre->img_big_pish,
                    'img_small' => $tyre->img_small,
                ];

                if (($price_opt != $p->price_opt || $price_rozn != $p->price_rozn )) {
                    $p->update($data);
                }
                $log .= "Product ({$c} of " . count($tyres) . ") #$p->id updated! \n";
            } else {
                try {
                    $storage_path = ImageHelper::saveTyreImage($tyre);
                    $data['image'] = $storage_path;
                }catch (\Exception $e){
                    Log::build([
                        'driver' => 'single',
                        'path' => storage_path('logs/tyres-sync.log'),
                    ])->info(print_r(['IMAGE DOWNLOAD ERROR', "$tyre->code ", $e->getMessage()],1));
                }
                // Сохраняем картинку

                $data = [
                    'title' => $tyre->marka . ' ' . $tyre->name . '. арт.' . $tyre->code,
                    'description' => $tyre->marka . ' ' . $tyre->name,
                    'price' => !is_array($tyre->whpr->wh_price_rest) ? $tyre->whpr->wh_price_rest->price_rozn * 0.95 : $tyre->whpr->wh_price_rest[0]->price_rozn * 0.95,
                    'product_type' => 'tyre',
                    'published' => true,
                    'meta_description' => $tyre->marka . ' ' . $tyre->name,
                    'meta_title' => $tyre->marka . ' ' . $tyre->name,
                    'price_opt' => $price_opt,
                    'price_rozn' => $price_rozn,
                    'rest' => json_encode($tyre->whpr->wh_price_rest),
                    'season' => $tyre->season,
                    'code' => 'tyre_' . $tyre->code,
                    'thorn' => $tyre->thorn,
                    'type' => $tyre->type ?? 'none',
                    'marka' => $tyre->marka,
                    'model' => $tyre->model,
                    'img_big_my' => $tyre->img_big_my,
                    'img_big_pish' => $tyre->img_big_pish,
                    'img_small' => $tyre->img_small,
                ];

                $p = Product::create($data);

                // Добавлям категорию
                $p->category()->associate($category->id);
                $p->save();

                $log .= "Product ({$c} of " . count($tyres) . ") #$p->id created! \n";
            }

            $this->info($c++ ." of " . count($tyres));
        }
//        Log::build([
//            'driver' => 'single',
//            'path' => storage_path('logs/tyres-sync.log'),
//        ])->info(print_r($log,1));
    }
}
