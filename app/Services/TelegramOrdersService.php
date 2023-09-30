<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramOrdersService
{
    protected string $chat_id;
    protected string $bot_api;

    public function __construct()
    {
        $this->chat_id = config('app.telegram_chat_id');
        $this->bot_api = config('app.telegram_bot_api');
        $this->api = "https://api.telegram.org/bot$this->bot_api/sendMessage?chat_id=$this->chat_id";
    }

    public function sendOrderDetails($details, $address)
    {
        $text = "Заказ №" . ($details->id ?? 0) . PHP_EOL;
        $text .= "Статус: " . $details->status->value . PHP_EOL;
        $text .= "Цена заказа: $details->total_price р." . PHP_EOL;
        $text .= "Контакт: $details->contact_name" . PHP_EOL;
        $text .= "Телефон: $details->contact_phone" . PHP_EOL;
        $text .= "Почта: $details->contact_email" . PHP_EOL;
        $text .= "Адрес доставки: $address->city, $address->address1, $address->address2, $address->zipcode,$address->state" . PHP_EOL
            . " id заказчика - $address->customer_id " . PHP_EOL;

        $this->api .= "&text=$text";

        $this->makeRequest();
    }

//    public function sendStatusChanged($order)
//    {
//       $text = "Заказ №" . ($details->id ?? 0) . PHP_EOL;
//       $text .= "Статус: " . $order->status->value . PHP_EOL;
//       $this->api .= "&text=$text";
//       $this->makeRequest();
//    }

    protected function makeRequest()
    {
        try {
            $result = Http::get($this->api);
        } catch (\Exception $e){
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/telegram_orders.log'),
            ])->info(print_r([$e->getMessage(),$this->api],1));
        }
    }
}
