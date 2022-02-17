<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Inertia\Inertia;

class DomainController extends Controller
{
    public function index(){
        $domains = Domain::all();
        return Inertia::render('Domains/List', [
            'domains' => $domains,
        ]);
    }

    public function create(){
        return Inertia::render('Domains/CreateForm');
    }

    public function store()
    {
        $attributes = validator(request()->all(), [
            'name' => 'required',
        ])->validate();

        Domain::create($attributes);

        return redirect()->route('domains.index');
    }
}
