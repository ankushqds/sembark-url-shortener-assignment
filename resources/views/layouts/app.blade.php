<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>URL Shortener - @yield('title')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; background: #f4f4f4; }
        .navbar { background: #333; color: white; padding: 1rem; }
        .navbar a { color: white; text-decoration: none; margin-right: 1rem; }
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: white; border-radius: 5px; padding: 1.5rem; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 1rem; }
        .btn { display: inline-block; padding: 0.5rem 1rem; background: #333; color: white; text-decoration: none; border-radius: 3px; border: none; cursor: pointer; }
        .btn-success { background: #28a745; }
        .btn-danger { background: #dc3545; }
        .alert { padding: 1rem; border-radius: 3px; margin-bottom: 1rem; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 0.75rem; text-align: left; border-bottom: 1px solid #ddd; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px; }
        .text-center { text-align: center; }
        .mt-4 { margin-top: 2rem; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-card { background: white; padding: 1.5rem; border-radius: 5px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .stat-card h3 { font-size: 2rem; color: #333; margin-bottom: 0.5rem; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="{{ url('/') }}">URL Shortener</a>
            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('urls.index') }}">My URLs</a>
                @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
                    <a href="{{ route('invitations.create') }}">Invite User</a>
                    <a href="{{ route('users.index') }}">Users</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn" style="background: transparent; border: 1px solid white;">Logout</button>
                </form>
            @endauth
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                @if(session('generated_password'))
                    <br><strong>Generated Password: {{ session('generated_password') }}</strong>
                @endif
                @if(session('short_url'))
                    <br><strong>Short URL: {{ session('short_url') }}</strong>
                @endif
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>