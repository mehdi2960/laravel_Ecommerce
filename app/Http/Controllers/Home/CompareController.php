<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function add(Product $product)
    {
        // وجود داشتن سشن
        if (session()->has('compareProducts')) {

           // اگه تکراری وجود داشت اضافه نکن
            if (in_array($product->id, session()->get('compareProducts'))) {
                alert()->warning('محصول مورد نظر به لیست مقایسه شما اضافه شده است', 'دقت کنید');
                return redirect()->back();
            }
            session()->push('compareProducts', $product->id);
        } else {
            session()->put('compareProducts', [$product->id]);
        }

        alert()->success('محصول مورد نظر به لیست مقایسه شما اضافه شد', 'باتشکر');
        return redirect()->back();
    }

    public function index()
    {
        if (session()->has('compareProducts')) {

            $products = Product::findOrFail(session()->get('compareProducts'));

            return view('home.compare.index', compact('products'));
        }

        alert()->warning('در ابتدا باید محصولی برای مقایسه اضافه کنید', 'دقت کنید');
        return redirect()->back();
    }

    public function remove($productId)
    {
        if (session()->has('compareProducts')) {
            foreach (session()->get('compareProducts') as $key=>$item){
                if ($item==$productId){
                    session()->pull('compareProducts'.$key);
                }
            }
            if (session()->get('compareProducts')==[]){
                session()->forget('compareProducts');
                return redirect()->route('home.index');
            }
            return redirect()->route('home.compare.index');

        }else{
            alert()->warning('در ابتدا باید محصولی برای مقایسه اضافه کنید', 'دقت کنید');
            return redirect()->back();
        }
    }
}
