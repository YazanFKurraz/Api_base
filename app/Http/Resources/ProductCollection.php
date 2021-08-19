<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'name' => $this->name,
            'price' => $this->price,
            'totalPrice' => round((1 - ($this->discount / 100)) * $this->price),
            'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star') / $this->reviews->count(), 1) : 'No rating yet',

            'link' =>
                [
                    'reviews' => route('product.show', $this->id)
                ],
        ];
    }
}
