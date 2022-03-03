<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Domain;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserDomainController extends Controller
{

    public function index(User $user)
    {
        $domains = Domain::query()
            ->whereDoesntHave('users', function($q) use ($user) {
                $q->where('users.id', $user->id);
            })
            ->select('domains.id', 'domains.name')
            ->orderBy('name')
            ->get();

        return Inertia::render('UserDomains/List', [
            'user_edit' => $user,
            'user_domains' => $user->domains,
            'domains' => $domains,
        ]);
    }

    public function store(User $user, Domain $domain)
    {
        //todo: don't accept duplications

        $user->domains()->attach($domain->id);

        return redirect()->route('user-domain.index', ['user' => $user->id]);
    }

    public function destroy(User $user, Domain $domain)
    {
        $user->domains()->detach($domain->id);

        return redirect()->route('user-domain.index', ['user' => $user->id]);
    }


}
