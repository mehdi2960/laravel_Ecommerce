<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Province;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

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
        if (\Cart::get($rowId) == null) {
            \Cart::add(array(
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
            'qtybutton' => 'required'
        ]);

        foreach ($request->qtybutton as $rowId => $quantity) {
            $item = \Cart::get($rowId);
            if ($quantity > $item->attributes->quantity) {
                alert()->error('تعداد وارد شده از محصول درست نمی باشد.', 'دقت کنید');
                return redirect()->back();
            }

            \Cart::update($rowId, array(
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
        \Cart::remove($rowId);

        alert()->success('محصول مورد نطر از سبد خرید شما حذف شد.', 'با تشکر');
        return redirect()->back();
    }

    public function clear()
    {
        \Cart::clear();

        alert()->warning('سبد خرید شما پاک شد.', 'با تشکر');
        return redirect()->back();
    }

    public function checkCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        if (!auth()->check()) {
            alert()->error('برای استفاده از کد تخفیف نیاز هست در ابتدا وارد سایت شوید.', 'دقت کنید');
            return redirect()->back();
        }

        $result = checkCoupon($request->code);

        if (array_key_exists('error', $result)) {
            alert()->error($result['error'], 'دقت کنید');
        } else {
            alert()->success($result['success'], 'با تشکر');
        }
        return redirect()->back();
    }

    public function checkout()
    {
        if (\Cart::isEmpty()){
            alert()->warning('سبد خرید شما خالی می باشد.', 'دقت کنید');
            return redirect()->route('home.index');
        }

        $addresses=UserAddress::query()->where('user_id',auth()->id())->get();
        $provinces=Province::all();
         return view('home.cart.checkout',compact('addresses','provinces'));
    }

    public function userProfileIndex()
    {
        $orders=Order::query()->where('user_id',auth()->id())->get();
        return view('home.user_profile.orders',compact('orders'));
    }
}
