<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function add(Product $product)
    {
        if (auth()->check()) {
            if ($product->checkUserWishlist(auth()->id())) {
                alert()->warning('محصول مورد نظر به لیست علاقه مندی هااضافه شده است', 'دقت کنید')->persistent('حله');
                return redirect()->back();
            } else {
                Wishlist::create([
                    'user_is' => auth()->id(),
                    'product_id' => $product->id
                ]);
                alert()->success('محصول مورد نظر به لیست علاقه مندی های شمااضافه شده', 'باتشکر')->persistent('حله');
                return redirect()->back();
            }

        } else {
            alert()->warning('برای افزودن به لیست علاقه مندی ها نیازهست درابتدا وارد سایت شوید', 'دقت کنید')->persistent('حله');
            return redirect()->back();
        }
    }

    public function remove(Product $product)
    {
        if (auth()->check()){
            $wishlist=Wishlist::where('product_id',$product->id)->where('user_id',auth()->id())->firstOrFail();
            if ($wishlist){
                $wishlist=Wishlist::where('product_id',$product->id)->where('user_id',auth()->id())->delete();
            }

            alert()->success('محصول مورد نظرازلیست علاقه مندی هاحذف شد', 'باتشکر')->persistent('حله');
            return redirect()->back();

        }else{
            alert()->warning('برای حذف از لیست علاقه مندی ها نیازهست درابتدا وارد سایت شوید', 'دقت کنید')->persistent('حله');
            return redirect()->back();
        }
    }

    public function UsersProfileIndex()
    {
        $wishlists=Wishlist::where('user_id',auth()->id())->get();
        return view('home.user_profile.wishlist',compact('wishlists'));
    }
}
