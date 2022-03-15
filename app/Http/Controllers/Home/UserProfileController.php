<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index()
    {
        $user=User::query()->latest()->findOrFail(1);
        return view('home.user_profile.index',compact('user'));
    }
}
