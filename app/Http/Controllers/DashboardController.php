<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isSuperAdmin()) {
            $totalUrls = ShortUrl::count();
            $totalCompanies = Company::count();
            $totalUsers = User::where('role', '!=', 'super_admin')->count();
            $recentUrls = ShortUrl::with(['user', 'company'])
                ->latest()
                ->take(10)
                ->get();
                
            return view('dashboard.super-admin', compact('totalUrls', 'totalCompanies', 'totalUsers', 'recentUrls'));
        }
        
        if ($user->isAdmin()) {
            $companyUrls = ShortUrl::where('company_id', $user->company_id)->count();
            $companyUsers = User::where('company_id', $user->company_id)->count();
            $recentUrls = ShortUrl::where('company_id', $user->company_id)
                ->with('user')
                ->latest()
                ->take(10)
                ->get();
                
            return view('dashboard.admin', compact('companyUrls', 'companyUsers', 'recentUrls'));
        }

        $myUrls = ShortUrl::where('user_id', $user->id)->count();
        $totalClicks = ShortUrl::where('user_id', $user->id)->sum('clicks');
        $recentUrls = ShortUrl::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();
            
        return view('dashboard.member', compact('myUrls', 'totalClicks', 'recentUrls'));
    }
}