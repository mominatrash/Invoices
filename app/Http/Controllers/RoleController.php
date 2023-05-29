<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    // function __construct()
    // {

    //     $this->middleware('permission:عرض صلاحية', ['only' => ['show_roles']]);
    //     $this->middleware('permission:اضافة صلاحية', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:تعديل صلاحية', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);
    // }

    public function show_roles(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('roles.roles', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create_role()
    {
        $permission = Permission::get();
        return view('roles.create', compact('permission'));
    }

    public function store_role(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('show_roles')
            ->with('success', 'Role created successfully');
    }

    public function show_details($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();
        return view('roles.show', compact('role', 'rolePermissions'));
    }

    public function edit_role($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    public function roles_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
        $role = Role::find($request->role_id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('show_roles')
            ->with('success', 'تم تحديث الدور بنجاح');
    }

    public function delete_role(Request $request)
    {
        DB::table("roles")->where('id', $request->role_id)->delete();
        return redirect()->route('show_roles')
            ->with('success', 'تم حذف الدور بنجاح');
    }
}
