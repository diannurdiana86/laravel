<?php

namespace App\Http\Controllers\Modules\Auth;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:role/index', ['only' => ['index']]);
        $this->middleware('permission:role/show', ['only' => ['show']]);
        $this->middleware('permission:role/store', ['only' => ['store']]);
        $this->middleware('permission:role/create', ['only' => ['create']]);
        $this->middleware('permission:role/update', ['only' => ['update']]);
        $this->middleware('permission:role/edit', ['only' => ['edit']]);
        $this->middleware('permission:role/delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data = [
            'title' => 'Role List',
            'roles' => Role::orderBy('id', 'DESC')->paginate(10),
        ];
        return view('modules.auth.roles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data = [
            'title' => 'Create Role',
            'permissions' => Permission::get(),
        ];
        return view('modules.auth.roles.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $role = Role::create(['name' => $request->name]);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        return redirect()->route('auth.roles.index')
            ->withSuccess('New role is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): View
    {
        // $rolePermissions = Permission::join("role_has_permissions", "permission_id", "=", "id")
        //     ->where("role_id", $role->id)
        //     ->select('name')
        //     ->select('title')
        //     ->get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_id", $role->id)
            ->pluck('permission_id')
            ->all();

        $data = [
            'title' => 'Detail Role',
            'role' => $role,
            'permissions' => Permission::get(),
            'rolePermissions' => $rolePermissions,
        ];
        return view('modules.auth.roles.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        if ($role->name == 'Super Admin') {
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE EDITED');
        }

        $rolePermissions = DB::table("role_has_permissions")->where("role_id", $role->id)
            ->pluck('permission_id')
            ->all();

        $data = [
            'title' => 'Edit Role',
            'role' => $role,
            'permissions' => Permission::get(),
            'rolePermissions' => $rolePermissions,
        ];
        return view('modules.auth.roles.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $input = $request->only('name');

        $role->update($input);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        return redirect()->back()
            ->withSuccess('Role is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        if ($role->name == 'Super Admin') {
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE DELETED');
        }
        if (auth()->user()->hasRole($role->name)) {
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
        }
        $role->delete();
        return redirect()->route('auth.roles.index')
            ->withSuccess('Role is deleted successfully.');
    }
}
