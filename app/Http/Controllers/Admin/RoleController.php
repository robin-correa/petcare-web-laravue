<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Http\Resources\Admin\PermissionResource;
use App\Http\Resources\Admin\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        if (!empty($search)) {
            $roles = Role::with('permissions')->search($search)->paginate(10)->withQueryString();
        } else {
            $roles = Role::with('permissions')->orderBy('id', 'DESC')->paginate(10);
        }

        return Inertia::render('Admin/Roles/Index', [
            'roles' => RoleResource::collection($roles),
            'permissions' => PermissionResource::collection(Permission::all()),
            'search' => $search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create($request->validated());
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index')->with('flash', [
            'success' => 'New role has been added'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        $role->syncPermissions($request->permissions);

        return redirect()->back()->with('flash', [
            'success' => 'Role has been updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->revokePermissionTo($role->permissions);
        $role->delete($id);

        return redirect()->back()->with('flash', [
            'success' => 'Role has been deleted'
        ]);
    }
}
