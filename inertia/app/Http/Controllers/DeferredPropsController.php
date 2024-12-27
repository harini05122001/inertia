<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Company;

class DeferredPropsController extends Controller
{
    public function index()
    {
        return Inertia::render('DeferredProps', [
            'users' => User::all(),
            'companyCount' => Company::count(), 
        ])->with([
            'companies' => fn () => Company::all(),
        ]);
    }    
}
