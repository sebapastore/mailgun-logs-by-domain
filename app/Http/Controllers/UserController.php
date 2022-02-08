<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserController extends Controller
{

    public function index()
    {
        $users = User::query()
            ->when(request()->input('search'), function($q, $search) {
                $q->where(function($q) use ($search) {
                    $q->whereLike('name', $search)
                        ->orWhereLike('email', $search);
                });
            })
            ->when(request()->input('role'), function($q, $role) {
                $q->where('role', $role);
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $roles = User::getRolesForSelectWithAllOption();

        return Inertia::render('Users/List', [
            'users' => $users,
            'filters' => request()->only('search', 'role'),
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        $roles = User::getRolesForSelect();

        return Inertia::render('Users/CreateForm', ['roles' => $roles]);
    }

    public function store()
    {
        $attributes = validator(request()->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'role' => [ 'required', Rule::in(User::$roles)],
            'password' => 'required|min:8|confirmed',
        ])->validate();

        $attributes['password'] = Hash::make($attributes['password']);

        User::create($attributes);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        $roles = User::getRolesForSelect();

        return Inertia::render('Users/UpdateForm', [
            'user_edit' => $user,
            'roles' => $roles,
        ]);
    }

    public function update(User $user)
    {
        $attributes = validator(request()->all(), [
            'name' => 'required',
            'role' => [ 'required', Rule::in(User::$roles)],
            'email' => 'required|email',
        ])->validate();

        $user->update($attributes);

        return redirect()->route('users.index');
    }

    public function updatePassword(User $user)
    {
        $attributes = validator(request()->all(), [
            'password' => 'required|min:8|confirmed',
        ])->validate();

        $attributes['password'] = Hash::make($attributes['password']);

        $user->update($attributes);

        return redirect()->route('users.index');
    }

    //todo: destroy or deactivate user

}
