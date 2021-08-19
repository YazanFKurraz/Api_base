<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'description' => $this->detail,
            'price' => $this->price,
            'stock' => $this->stock == 0 ? 'Out of stock' : $this->stock,
            'discount' => $this->discount,
            'totalPrice' => round((1 - ($this->discount / 100)) * $this->price),
            //round(value, number) precision => show number after decimal point take parameter integer
            'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star') / $this->reviews->count(), 1) : 'No rating yet',
            'reviews' => $this->reviews
//            'link' =>
//                [
//                    'reviews' => route('product.show', $this->id)
//                ],
        ];
    }
}
