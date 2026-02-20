@extends('layouts.app')

@section('title', 'Edit ' . $company->name)

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Edit Company: {{ $company->name }}</h2>
    
    <form method="POST" action="{{ route('companies.update', $company) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Company Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $company->name) }}" required>
            @error('name')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="email">Company Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $company->email) }}" required>
            @error('email')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="phone">Phone Number (Optional)</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $company->phone) }}">
            @error('phone')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-success">Update Company</button>
        <a href="{{ route('companies.show', $company) }}" class="btn">Cancel</a>
    </form>
</div>
@endsection