<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::query()->latest()->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'display_name' => 'required',
        ]);

        $role = Role::create([
            'name' => $request->get('name'),
            'display_name' => $request->get('display_name'),
            'guard_name' => 'web',
        ]);

        $permissions = $request->except('_token', 'display_name', 'name');
        $role->givePermissionTo($permissions);

        alert()->success('نقش مورد نظر شما ایجاد شد.', 'با تشکر');
        return redirect()->route('admin.roles.index');

    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
            'display_name' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $role->update([
                'name' => $request->name,
                'display_name' => $request->display_name
            ]);
            $permissions = $request->except('_token', 'display_name', 'name', '_method');
            $role->syncPermissions($permissions);

            DB::commit();
        } catch
        (\Exception $ex) {
            DB::rollBack();
            alert()->error('مشکل در ویرایش نقش', $ex->getMessage())->persistent('حله');
            return redirect()->back();
        }
        alert()->success('نقش مورد نظر ویرایش شد', 'باتشکر');
        return redirect()->route('admin.roles.index');
    }
}
