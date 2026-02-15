@extends('layouts.app')

@section('title', 'URLs')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Short URLs</h2>
        @if(auth()->user()->canCreateShortUrls())
            <a href="{{ route('urls.create') }}" class="btn btn-success">Create New</a>
        @endif
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Short URL</th>
                <th>Original URL</th>
                @if(auth()->user()->isSuperAdmin())
                    <th>Company</th>
                    <th>User</th>
                @elseif(auth()->user()->isAdmin())
                    <th>User</th>
                @endif
                <th>Clicks</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($urls as $url)
            <tr>
                <td><a href="{{ $url->short_url }}" target="_blank">{{ $url->short_code }}</a></td>
                <td>{{ Str::limit($url->original_url, 50) }}</td>
                @if(auth()->user()->isSuperAdmin())
                    <td>{{ $url->company->name }}</td>
                    <td>{{ $url->user->name }}</td>
                @elseif(auth()->user()->isAdmin())
                    <td>{{ $url->user->name }}</td>
                @endif
                <td>{{ $url->clicks }}</td>
                <td>{{ $url->created_at->format('Y-m-d') }}</td>
                <td>
                    <form method="POST" action="{{ route('urls.destroy', $url) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No URLs found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $urls->links() }}
</div>
@endsection