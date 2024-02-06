<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\product\Bookedtables;
use App\Models\Product\Cart;
use App\Models\Product\Order;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

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

        $checkingInCart = Cart::where('prod_id', $id)
            ->where('user_id', Auth::id())
            ->count();

        return view('products.productsingle', compact('product', 'relatedProducts', 'checkingInCart'));
    }

    public function addCart(Request $request, $id)
    {
        $addCart = Cart::create([
            "prod_id" => $request->prod_id,
            "name" => $request->name,
            "image" => $request->image,
            "price" => $request->price,
            "user_id" => Auth::id(),
        ]);

        session()->flash('success', 'Product successfully added to cart!');
        return redirect()->route('product.single', $id);
    }

    public function cart()
    {
        $cartProducts = Cart::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        $totalPrice = Cart::where('user_id', Auth::id())->sum('price');
        return view('products.cart', compact('cartProducts', 'totalPrice'));
    }

    public function deleteProductCart($id)
    {
        $ProductCart = Cart::where('prod_id', $id)
            ->where('user_id', Auth::id());

        $ProductCart->delete();

        if ($ProductCart) {
            return Redirect::route('cart')->with(['delete' => 'product deleted from Cart successfully']);
        }
    }

    public function prepareCheckout(Request $request)
    {
        $value = $request->price;

        Session::put('price', $value);
        $newPrice = Session::get('price');

        if ($newPrice > 0) {
            return Redirect::route('checkout');
        }
    }

    public function checkout()
    {
        return view('products.checkout');
    }

    public function storeCheckout(Request $request)
    {

        $checkout = Order::create([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "state" => $request->state,
            "address" => $request->address,
            "city" => $request->city,
            "zip_code" => $request->zip_code,
            "phone" => $request->phone,
            "email" => $request->email,
            "price" => $request->price,
            "user_id" => Auth::id(),
        ]);

        echo "Welcome To Paypal";

    }

    public function BookTables(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            "first_name" => "required|max:40|min:3",
            "last_name" => "required|max:40|min:3",
            "bookdate" => "required",
            "time" => "required",
            "phone" => "required|max:15",
            "message" => "required",
        ]);

        // Add the user_id to the validated data
        $validatedData['user_id'] = Auth::id();

        // Create the booked table record
        $booked = Bookedtables::create($validatedData);

        // Flash message and redirect
        session()->flash('success', 'Table Booked Successfully');
        return redirect()->route('home');
    }

    public function menu()
    {
        $menuDrinks = Product::select()->where('type', 'drinks')->orderBy('id', 'desc')->limit(4)->get();
        $menuDesserts = Product::select()->where('type', 'desserts')->orderBy('id', 'desc')->limit(4)->get();

        return view('products.menu', compact('menuDrinks', 'menuDesserts'));

    }

}
