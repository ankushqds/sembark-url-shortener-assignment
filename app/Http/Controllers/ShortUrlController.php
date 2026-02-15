<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isSuperAdmin()) {
            $urls = ShortUrl::with(['user', 'company'])->latest()->paginate(15);
        } elseif ($user->isAdmin()) {
            $urls = ShortUrl::where('company_id', $user->company_id)
                ->with('user')
                ->latest()
                ->paginate(15);
        } else {
            $urls = ShortUrl::where('user_id', $user->id)->latest()->paginate(15);
        }
        
        return view('urls.index', compact('urls'));
    }

    public function create()
    {
        if (!Auth::user()->canCreateShortUrls()) {
            abort(403, 'You are not authorized to create short URLs.');
        }
        
        return view('urls.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->canCreateShortUrls()) {
            abort(403, 'You are not authorized to create short URLs.');
        }

        $request->validate([
            'original_url' => 'required|url',
            'title' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        
        do {
            $shortCode = Str::random(6);
        } while (ShortUrl::where('short_code', $shortCode)->exists());

        $shortUrl = ShortUrl::create([
            'user_id' => $user->id,
            'company_id' => $user->company_id,
            'original_url' => $request->original_url,
            'short_code' => $shortCode,
            'title' => $request->title,
        ]);

        return redirect()->route('urls.index')
            ->with('success', 'Short URL created successfully!')
            ->with('short_url', $shortUrl->short_url);
    }

    public function redirect($code)
    {
        $shortUrl = ShortUrl::where('short_code', $code)->firstOrFail();
        $shortUrl->incrementClicks();
        
        return redirect()->away($shortUrl->original_url);
    }

    public function destroy(ShortUrl $shortUrl)
    {
        $user = Auth::user();
        
        // Check authorization
        if ($user->isSuperAdmin()) {
            // Super admin can delete any
        } elseif ($user->isAdmin()) {
            // Admin can delete only from their company
            if ($shortUrl->company_id !== $user->company_id) {
                abort(403);
            }
        } else {
            // Member can delete only their own
            if ($shortUrl->user_id !== $user->id) {
                abort(403);
            }
        }
        
        $shortUrl->delete();
        
        return redirect()->route('urls.index')
            ->with('success', 'Short URL deleted successfully!');
    }
}