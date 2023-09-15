<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrderEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $forAdmin;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public Order $order, public $recipient)
    {
        $this->forAdmin = config('app.mail_from') == $this->recipient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Создан новый заказ в магазине TyreShop')
            ->to($this->recipient)
            ->view('mail.new-order');
    }
}
