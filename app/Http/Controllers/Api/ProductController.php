<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Traits\GerenalApi;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    use GerenalApi;

    public function index(Request $request)
    {
        //get products all
        //with return multi row must be use ::collection not use new Resource
        $product_all =  ProductCollection::collection( Product::all());

        return $this->sendResponse(true, 'Show all products', $product_all, 200);
    }

    public function show(Request $request)
    {

        $product = Product::with('reviews')->where('id', $request->id)->first();

            if (!$product) {
                return $this->sendResponse(false, 'not found product', '', 404);
            }

        $product = new ProductResource($product);

        return $this->sendResponse(true, 'Show this product', $product, 200);
    }

    public function showReviewProduct(Request $request)
    {

        $product = Product::with('reviews')->where('id', $request->id)->first();

        $product = new ProductResource($product);

        return $this->sendResponse(true, 'Show this product', $product, 200);
    }

    public function store(Request $request){

        $product = Product::create([
            'name' => $request->name,
            'detail' => $request->detail,
            'price' => $request->price,
            'discount' => $request->discount,
        ]);

        $product = new ProductResource($product);

        return $this->sendResponse(true, 'create successfully',$product ,200);

    }
}
