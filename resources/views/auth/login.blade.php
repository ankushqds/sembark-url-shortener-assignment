@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="card" style="max-width: 400px; margin: 0 auto;">
    <h2 class="text-center">Login</h2>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            @error('email')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            @error('password')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>
        
        <div class="form-group">
            <label>
                <input type="checkbox" name="remember"> Remember Me
            </label>
        </div>
        
        <button type="submit" class="btn btn-success" style="width: 100%;">Login</button>
    </form>
    
    <div class="text-center mt-4">
        <p>Demo Credentials:</p>
        <p><strong>Super Admin:</strong> superadmin@example.com / password</p>
        <p><strong>Admin:</strong> admin@example.com / password</p>
        <p><strong>Member:</strong> member@example.com / password</p>
    </div>
</div>
@endsection