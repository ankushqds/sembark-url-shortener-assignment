<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        
        if ($user->isSuperAdmin()) {
            $companies = Company::all();
            return view('invitations.create-super-admin', compact('companies'));
        }
        
        if ($user->isAdmin()) {
            return view('invitations.create-admin');
        }
        
        abort(403);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,member',
        ]);

        if ($user->isSuperAdmin()) {
            $request->validate([
                'company_id' => 'required|exists:companies,id',
            ]);
            
            // Super admin can only invite admins
            if ($request->role !== 'admin') {
                return back()->withErrors(['role' => 'Super Admin can only invite Admins.']);
            }
            
            $companyId = $request->company_id;
            
        } elseif ($user->isAdmin()) {
            // Admin can invite to their own company
            $companyId = $user->company_id;
            
        } else {
            abort(403);
        }

        // Generate random password
        $password = Str::random(10);
        
        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => $request->role,
            'company_id' => $companyId,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User invited successfully!')
            ->with('generated_password', $password);
    }

}