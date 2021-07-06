<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'text' => "required|min:5|max:4000",
            'rate' => "required|digits_between:0,5",
        ]);

        if ($validator->fails()) {
            return redirect()->to(url()->previous() . '#comments')->withErrors($validator);
        }

        if (auth()->check()) {
            try {
                DB::beginTransaction();
                Comment::create([
                    'user_id'=>auth()->id(),
                    'product_id'=>$product->id,
                    'text'=>$request->text,
                ]);

                if ($product->rates()->where('user_id',auth()->id())->exists()){
                    $productRate=$product->rates()->where('user_id',auth()->id())->first();
                    $productRate->update([
                        'rate'=>$request->rate,
                    ]);
                }else{
                    ProductRate::create([
                        'user_id'=>auth()->id(),
                        'product_id'=>$product->id,
                        'rate'=>$request->rate
                    ]);
                }

                DB::commit();

            } catch (\Exception $ex) {
                DB::rollBack();
                alert()->error('مشکل در ویرایش محصول', $ex->getMessage())->persistent('حله');
                return redirect()->back();
            }

            alert()->success('نظر ارزشمند شما برای این محصول با موفقیت ثبت شد', 'باتشکر');
            return redirect()->back();

        } else {
            alert()->warning('برای ثیت نظر نیاز است در ابتدا وارد سایت شوید', 'دقت کنید');

            return redirect()->back();
        }
    }

    public function UsersProfileIndex()
    {
        $comments=Comment::where('user_id',auth()->id())->where('approved',1)->get();
        return view('home.user_profile.comments',compact('comments'));
    }
}
