<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->authorize('browse_user');

        $users = User::search(request()->query('keyword'))
                     ->paginate();

        return view("users.index", compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create() {
        $roles = Role::all()->reduce(function (array $carry, Role $role) {
            $carry[$role->id] = $role->name;

            return $carry;
        }, []);

        return view("users.create", compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function store(StoreRequest $request) {
        $user = new User($request->validated());
        $password = Str::random(8);
        $user->password = bcrypt($password);
        $user->save();

        return redirect()->route("users.index")
                         ->withMessage('New user created!');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user) {
        $this->authorize('edit_user', $user);
        $roles = Role::all();

        return view("users.edit", compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User                $user
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateRequest $request, User $user) {
        $data = $request->validated();
        $user->update($request->validated());
        $user->syncRoles($data['roles']);

        return redirect('users.index')->with('message', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
