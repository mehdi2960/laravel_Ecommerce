<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = User::query()->latest()->findOrFail(1);
        return view('home.user_profile.index', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $user->update([
            'name' => $request->get('name')
        ]);

        alert()->success('تغییرات با موفقیت ویرایش شد', 'با تشکر');
        return redirect()->back();
    }
}
