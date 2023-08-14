<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class OrderResource extends JsonResource
{
    public static $wrap = false;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $customer = $this->user->customer;
        $shipping = $customer->shippingAddress;
        $billing = $customer->billingAddress;
//        dd($this, $customer);
        return [
            'id' => $this->id,
            'status' => $this->status,
            'total_price' => $this->total_price,
            'items' => $this->items->map(fn($item) => [
                'id' => $item->id,
                'unit_price' => $item->unit_price,
                'quantity' => $item->quantity,
                'product' => [
                    'id' => $item->product->id,
                    'slug' => $item->product->slug,
                    'title' => $item->product->title,
                    'image' => $item->product->img_small,
                ]
            ]),
            'customer' => [
                'id' => $this->user->id,
                'email' => $this->user->email,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'phone' => $customer->phone,
                'shippingAddress' => [
                    'id' => $shipping->id ?? '[not-set]',
                    'address1' => $shipping->address1 ?? '[not-set]',
                    'address2' => $shipping->address2 ?? '[not-set]',
                    'city' => $shipping->city ?? '[not-set]',
                    'state' => $shipping->state ?? '[not-set]',
                    'zipcode' => $shipping->zipcode ?? '[not-set]',
                    'country' => $shipping->country->name ?? '[not-set]',
                ],
                'billingAddress' => [
                    'id' => $billing->id ?? '[not-set]',
                    'address1' => $billing->address1 ?? '[not-set]',
                    'address2' => $billing->address2 ?? '[not-set]',
                    'city' => $billing->city ?? '[not-set]',
                    'state' => $billing->state ?? '[not-set]',
                    'zipcode' => $billing->zipcode ?? '[not-set]',
                    'country' => $billing->country->name ?? '[not-set]',
                ]
            ],
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
