<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;

class productsController extends Controller
{
    //
    public function singleProduct($id)
    {

        $product = Product::find($id);

        $relatedProducts = Product::where('type', '=', $product->type)
            ->where('id', '!=', $id)->limit(4)
            ->orderBy('id', 'desc')
            ->get();

        return view('products.productsingle', compact('product', 'relatedProducts'));

    }
}
