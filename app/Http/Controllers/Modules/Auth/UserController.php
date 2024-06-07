<?php

namespace App\Http\Controllers\Modules\Auth;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:user/index', ['only' => ['index']]);
        $this->middleware('permission:user/show', ['only' => ['show']]);
        $this->middleware('permission:user/store', ['only' => ['store']]);
        $this->middleware('permission:user/create', ['only' => ['create']]);
        $this->middleware('permission:user/update', ['only' => ['update']]);
        $this->middleware('permission:user/edit', ['only' => ['edit']]);
        $this->middleware('permission:user/delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data = [
            'title' => 'Manajemen User',
            'users' => User::latest('id')->paginate(3),
        ];
        return view('modules.auth.users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data = [
            'title' => 'Tambah User',
            'roles' => Role::pluck('name')->all(),
        ];
        return view('modules.auth.users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        $user = User::create($input);
        $user->assignRole($request->roles);

        return redirect()->route('users.index')
            ->withSuccess('New user is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        $data = [
            'title' => 'Detail User',
            'user' => $user,
        ];
        return view('modules.auth.users.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        // Check Only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')) {
            if ($user->id != auth()->user()->id) {
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all()
        ];
        return view('modules.auth.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $input = $request->all();

        if (!empty($request->password)) {
            $input['password'] = Hash::make($request->password);
        } else {
            $input = $request->except('password');
        }

        $user->update($input);

        $user->syncRoles($request->roles);

        return redirect()->back()
            ->withSuccess('User is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $user->syncRoles([]);
        $user->delete();
        return redirect()->route('users.index')
            ->withSuccess('User is deleted successfully.');
    }
}
