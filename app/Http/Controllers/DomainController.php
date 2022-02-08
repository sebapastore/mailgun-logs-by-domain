<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DomainController extends Controller
{
    public function index(){
        $domains = Domain::all();
        return Inertia::render('Domains/Index', [
            'domains' => $domains,
        ]);
    }
}
