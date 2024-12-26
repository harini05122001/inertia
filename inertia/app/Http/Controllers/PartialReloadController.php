<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Company;

class PartialReloadController extends Controller
{
    public function index()
    {   
        $users = User::all();
        $companies = Company::all();
        $count = session('count', 0); 
        return Inertia::render('PartialReload', [
            'count' => $count, 'users' => $users,'companies' => $companies]);    
    }

    public function increment()
    {
        $count = session('count', 0) + 1;
        session(['count' => $count]);

        return response()->json(['count' => $count]);
    }

    public function reload(Request $request)
    {
        $request->validate([
            'company_id' => 'nullable|exists:companies,id',
        ]);
    
        $usersQuery = User::query();
        
        if ($request->has('company_id') && $request->company_id) {
            $usersQuery->where('company_id', $request->company_id);
        }
    
        $users = $usersQuery->get();
    
        return response()->json([
            'users' => $users
        ]);
    }
    
}
