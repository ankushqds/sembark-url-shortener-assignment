@extends('layouts.app')

@section('title', 'Create Short URL')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Create Short URL</h2>
    
    <form method="POST" action="{{ route('urls.store') }}">
        @csrf
        
        <div class="form-group">
            <label for="original_url">Original URL</label>
            <input type="url" name="original_url" id="original_url" value="{{ old('original_url') }}" required placeholder="https://example.com/very/long/url">
            @error('original_url')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="title">Title (Optional)</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="My Awesome Link">
            @error('title')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-success">Create Short URL</button>
        <a href="{{ route('urls.index') }}" class="btn">Cancel</a>
    </form>
</div>
@endsection