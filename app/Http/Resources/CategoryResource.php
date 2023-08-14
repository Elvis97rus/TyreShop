<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class CategoryResource extends JsonResource
{
    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        dd($this);
        return [
            'id' => $this->id,
            'name' => $this->name ?? null,
            'slug' => $this->slug ?? null,
            'type' => $this->type ?? null,
            'description' => $this->description ?? null,
            'meta_description' => $this->meta_description ?? null,
            'meta_title' => $this->meta_title ?? null,
            'image' => $this->image ?: null,
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
