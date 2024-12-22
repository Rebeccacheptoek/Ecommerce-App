<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'image_url' => $this->image_url,
            'sku' => $this->sku,
            'available' => $this->stock > 0,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}