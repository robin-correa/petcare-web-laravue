<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePermissionRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        if (!empty($search)) {
            $users = User::with('roles')->search($search)->paginate(10)->withQueryString();
        } else {
            $users = User::with('roles')->orderBy('id', 'DESC')->paginate(10);
        }

        return Inertia::render('Admin/Users/Index', [
            'users' => UserResource::collection($users),
            'roles' => Role::all(),
            'permissions' => Permission::all(),
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
    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')->with('flash', [
            'success' => 'New user has been added'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
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
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());

        $user->syncRoles([$request->role]);

        return redirect()->back()->with('flash', [
            'success' => 'User has been updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete($id);

        $user->syncRoles([]);
        $user->syncPermissions([]);

        return redirect()->back()->with('flash', [
            'success' => 'User has been deleted'
        ]);
    }

    public function updatePermissions(UpdatePermissionRequest $request, User $user) {
        $user->syncPermissions($request->permissions);

        return redirect()->back()->with('flash', [
            'success' => 'Permissions have been updated'
        ]);
    }
}
