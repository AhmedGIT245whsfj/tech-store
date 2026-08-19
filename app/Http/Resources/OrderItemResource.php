<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product' => [
                'id' => $this->product?->id,
                'name' => $this->product?->name,
                'image' => $this->product?->image
                    ? asset('storage/' . $this->product->image)
                    : null,
            ],
            'quantity' => $this->quantity,
            'price' => $this->price,
            'subtotal' => number_format(
                (float) $this->price * $this->quantity,
                2,
                '.',
                ''
            ),
        ];
    }
}
