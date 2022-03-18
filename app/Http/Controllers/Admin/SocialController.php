<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Social;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function index()
    {
        $socials=Social::query()->latest()->paginate(10);
        return view('admin.socials.index',compact('socials'));
    }
    public function create()
    {
        return view('admin.socials.create');
    }

    public function store(Request $request)
    {
       $request->validate([
           'title'=>'required|string',
           'link'=>'required'
       ]);

       Social::create([
           'title'=>$request->get('title'),
           'link'=>$request->get('link'),
           'is_active' => $request->get('is_active'),
       ]);
        alert()->success('شبکه اجتماعی مورد نظر ایجاد شد', 'باتشکر');
        return redirect()->route('admin.socials.index');
    }

    public function edit(Social $social)
    {
        return view('admin.socials.edit',compact('social'));
    }

    public function update(Social $social,Request $request)
    {
        $request->validate([
            'title'=>'nullable|string',
            'link'=>'nullable'
        ]);

        $social->update([
            'title'=>$request->get('title'),
            'link'=>$request->get('link'),
            'is_active' => $request->get('is_active'),
        ]);
        alert()->success('شبکه اجتماعی مورد نظر ویرایش شد', 'باتشکر');
        return redirect()->route('admin.socials.index');
    }
}
