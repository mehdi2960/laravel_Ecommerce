<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\ContactUs;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;
class HomeController extends Controller
{
    public function index()
    {
        $sliders=Banner::where('type','slider')->where('is_active',1)->orderBy('priority')->get();
        $indexTopBanners=Banner::where('type','index-top')->where('is_active',1)->orderBy('priority')->get();
        $indexBottomBanners=Banner::where('type','index-bottom')->where('is_active',1)->orderBy('priority')->get();
        $products=Product::where('is_active',1)->get()->take(5);
        return view('home.index',compact('sliders','indexTopBanners','indexBottomBanners','products'));
    }

    public function aboutUs()
    {
        $indexBottomBanners=Banner::where('type','index-bottom')->where('is_active',1)->orderBy('priority')->get();
        return view('home.about-us',compact('indexBottomBanners'));
    }

    public function contactUs()
    {
        $setting=Setting::findOrFail(1);
        return view('home.contact-us',compact('setting'));
    }

    public function contactUsForm(Request $request)
    {
        $request->validate([
            'name'=>'required|string|min:4|max:50',
            'email'=>'required|email',
            'subject'=>'required|string|min:4|max:100',
            'text'=>'required|string|min:4|max:3000',
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('contact_us')]
        ]);

        ContactUs::create([
            'name'=>$request->get('name'),
            'email'=>$request->get('email'),
            'subject'=>$request->get('subject'),
            'text'=>$request->get('text'),
        ]);

        alert()->success('پیام شما با موفقیت ثبت شد.','با تشکر');
        return redirect()->back();

    }
}
