@extends('layouts.app')

@section('title', 'Invite User')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Invite User to {{ auth()->user()->company->name }}</h2>
    
    <form method="POST" action="{{ route('invitations.store') }}">
        @csrf
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            @error('name')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            @error('email')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" required>
                <option value="admin">Admin</option>
                <option value="member">Member</option>
            </select>
            @error('role')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-success">Invite User</button>
        <a href="{{ route('dashboard') }}" class="btn">Cancel</a>
    </form>
</div>
@endsection