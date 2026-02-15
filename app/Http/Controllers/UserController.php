<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isSuperAdmin()) {
            $users = User::with('company')
                ->where('role', '!=', 'super_admin')
                ->latest()
                ->paginate(15);
        } elseif ($user->isAdmin()) {
            $users = User::where('company_id', $user->company_id)
                ->latest()
                ->paginate(15);
        } else {
            abort(403);
        }
        
        return view('users.index', compact('users'));
    }
}