@extends('layouts.app')

@section('title', 'Member Dashboard')

@section('content')
<h1>Member Dashboard</h1>

<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ $myUrls }}</h3>
        <p>My URLs</p>
    </div>
    <div class="stat-card">
        <h3>{{ $totalClicks }}</h3>
        <p>Total Clicks</p>
    </div>
</div>

<div class="card">
    <h2>My Recent URLs</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Short URL</th>
                <th>Original URL</th>
                <th>Clicks</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentUrls as $url)
            <tr>
                <td><a href="{{ $url->short_url }}" target="_blank">{{ $url->short_code }}</a></td>
                <td>{{ Str::limit($url->original_url, 50) }}</td>
                <td>{{ $url->clicks }}</td>
                <td>{{ $url->created_at->diffForHumans() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="text-center mt-4">
    <a href="{{ route('urls.create') }}" class="btn btn-success">Create New Short URL</a>
</div>
@endsection