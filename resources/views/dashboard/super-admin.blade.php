@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
<h1>Super Admin Dashboard</h1>

<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ $totalUrls }}</h3>
        <p>Total URLs</p>
    </div>
    <div class="stat-card">
        <h3>{{ $totalCompanies }}</h3>
        <p>Total Companies</p>
    </div>
    <div class="stat-card">
        <h3>{{ $totalUsers }}</h3>
        <p>Total Users</p>
    </div>
</div>

<div class="card">
    <h2>Recent URLs</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Short URL</th>
                <th>Original URL</th>
                <th>Company</th>
                <th>Created By</th>
                <th>Clicks</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentUrls as $url)
            <tr>
                <td><a href="{{ $url->short_url }}" target="_blank">{{ $url->short_code }}</a></td>
                <td>{{ Str::limit($url->original_url, 50) }}</td>
                <td>{{ $url->company->name }}</td>
                <td>{{ $url->user->name }}</td>
                <td>{{ $url->clicks }}</td>
                <td>{{ $url->created_at->diffForHumans() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection