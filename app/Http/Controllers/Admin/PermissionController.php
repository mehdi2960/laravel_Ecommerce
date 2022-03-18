<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions=Permission::latest()->paginate(10);
        return view('admin.permissions.index',compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'display_name'=>'required',
        ]);

        Permission::create([
            'name'=>$request->get('name'),
            'display_name'=>$request->get('display_name'),
            'guard_name'=>'web',
        ]);

        alert()->success('مجوز مورد نظر شما ایجاد شد.','با تشکر');
        return redirect()->route('admin.permissions.index');

    }
}
