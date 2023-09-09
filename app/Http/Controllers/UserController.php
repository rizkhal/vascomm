<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Inertable\UserTable;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function index()
    {
        return inertia('users/index')->inertable(new UserTable())->title('Add Products');
    }

    public function store(UserRequest $request)
    {
        User::create($request->validated());

        return back()->success('Berhasil menambah user');
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());

        return back()->success('Berhasil mengubah user');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->success('Berhasil menghapus user');
    }
}
