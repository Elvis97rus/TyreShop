<?php

namespace App\Console\Commands;

use App\Models\Api\Category;
use App\Models\Api\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use RicorocksDigitalAgency\Soap\Facades\Soap;
use SoapClient;
use App\Helpers\ImageHelper;

class TelegramBotCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:bot';

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
//        $chat_id = config('app.telegram_chat_id');
//        $bot_api = config('app.telegram_bot_api');
//        $text = "Test3";
//        $api = "https://api.telegram.org/bot$bot_api/sendMessage?chat_id=$chat_id&text=$text";
//        $result = Http::get($api);
//
//        $this->info(print_r([$result],1));
//        Log::build([
//            'driver' => 'single',
//            'path' => storage_path('logs/tyres-sync.log'),
//        ])->info(print_r($log,1));
    }
}
