<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>URL Shortener</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .container { max-width: 800px; margin: 0 auto; padding: 2rem; }
        .card { background: white; border-radius: 10px; padding: 3rem; box-shadow: 0 20px 60px rgba(0,0,0,0.3); text-align: center; }
        h1 { font-size: 3rem; margin-bottom: 1rem; color: #333; }
        p { font-size: 1.2rem; color: #666; margin-bottom: 2rem; line-height: 1.6; }
        .btn { display: inline-block; padding: 1rem 2rem; background: #667eea; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; margin: 0 0.5rem; transition: background 0.3s; }
        .btn:hover { background: #764ba2; }
        .btn-outline { background: transparent; border: 2px solid #667eea; color: #667eea; }
        .btn-outline:hover { background: #667eea; color: white; }
        .features { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-top: 3rem; text-align: left; }
        .feature h3 { color: #333; margin-bottom: 0.5rem; }
        .feature p { color: #666; font-size: 0.9rem; margin-bottom: 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>🔗 URL Shortener</h1>
            <p>Shorten your long URLs and make them easy to share.<br>A complete solution for companies to manage their links.</p>
            
            <div>
                @if(Auth::check())
                    <a href="{{ route('urls.index') }}" class="btn">Go to My URLs</a>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn">Login</a>
                @endif
            </div>
            
            <div class="features">
                <div class="feature">
                    <h3>🔗 Short URLs</h3>
                    <p>Create short, memorable links from long URLs with just one click.</p>
                </div>
                <div class="feature">
                    <h3>🏢 Multi-Company</h3>
                    <p>Support for multiple companies with isolated data and users.</p>
                </div>
                <div class="feature">
                    <h3>👥 Role-Based Access</h3>
                    <p>SuperAdmin, Admin, and Member roles with different permissions.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>