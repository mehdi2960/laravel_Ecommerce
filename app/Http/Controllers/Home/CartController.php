<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('home.cart.index');
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'qtybutton' => 'required',
        ]);

        // چک کردن product و variation
        $product = Product::findOrFail($request->product_id);
        $productVariation = ProductVariation::findOrFail(json_decode($request->variation)->id);

        if ($request->qtybutton > $productVariation->quantity) {
            alert()->error('تعداد وارد شده از محصول درست نمی باشد.', 'دقت کنید');
            return redirect()->back();
        }

        // add the product to cart
        $rowId = $product->id . '-' . $productVariation->id;
        if (Cart::get($rowId) == null) {
            Cart::add(array(
                'id' => $rowId,
                'name' => $product->name,
                'price' => $productVariation->is_sale ? $productVariation->sale_price : $productVariation->price,
                'quantity' => $request->qtybutton,
                'attributes' => $productVariation->toArray(),
                'associatedModel' => $product
            ));
        } else {
            alert()->warning('محصول مورد نطر به سبد خرید شما قبلا اضافه شده است.', 'دقت کنید');
            return redirect()->back();
        }

        alert()->success('محصول مورد نطر به سبد خرید شما اضافه شد.', 'با تشکر');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'qtybutton'=>'required'
        ]);

        foreach ($request->qtybutton as $rowId=>$quantity)
        {
            $item=Cart::get($rowId);
            if ($quantity > $item->attributes->quantity) {
                alert()->error('تعداد وارد شده از محصول درست نمی باشد.', 'دقت کنید');
                return redirect()->back();
            }

            Cart::update($rowId, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $quantity
                ),
            ));
        }

        alert()->success('سبد خرید شما ویرایش شد.', 'با تشکر');
        return redirect()->back();
    }

    public function remove($rowId)
    {
        Cart::remove($rowId);

        alert()->success('محصول مورد نطر از سبد خرید شما حذف شد.', 'با تشکر');
        return redirect()->back();
    }

    public function clear()
    {
        Cart::clear();

        alert()->warning('سبد خرید شما پاک شد.', 'با تشکر');
        return redirect()->back();
    }
}
