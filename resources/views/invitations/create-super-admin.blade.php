@extends('layouts.app')

@section('title', 'Invite Admin')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Invite Company Admin</h2>
    
    <form method="POST" action="{{ route('invitations.store') }}">
        @csrf
        
        <div class="form-group">
            <label for="company_id">Company</label>
            <select name="company_id" id="company_id" required>
                <option value="">Select Company</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
            @error('company_id')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>
        
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
        
        <input type="hidden" name="role" value="admin">
        
        <button type="submit" class="btn btn-success">Invite Admin</button>
        <a href="{{ route('dashboard') }}" class="btn">Cancel</a>
    </form>
</div>
@endsection