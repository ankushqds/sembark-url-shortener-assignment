@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1>Super Admin Dashboard</h1>
    <a href="{{ route('urls.create') }}" class="btn btn-success">+ Create New Short URL</a>
</div>

<p style="margin-bottom: 2rem; color: #666;">
    Welcome to the URL Shortener! You can manage all companies, users, and URLs from here.
</p>

<div class="stats-grid">
    <div class="stat-card">
        <h3>{{ $totalUrls }}</h3>
        <p>Total URLs Shortened</p>
    </div>
    <div class="stat-card">
        <h3>{{ $totalCompanies }}</h3>
        <p>Active Companies</p>
    </div>
    <div class="stat-card">
        <h3>{{ $totalUsers }}</h3>
        <p>Total Users</p>
    </div>
</div>

<div style="margin: 2rem 0; display: flex; gap: 1rem;">
    <a href="{{ route('companies.index') }}" class="btn btn-success">Manage Companies</a>
    <a href="{{ route('urls.index') }}" class="btn">View All URLs</a>
    <a href="{{ route('users.index') }}" class="btn">View All Users</a>
</div>

<div class="card">
    <h2>Recent Short URLs</h2>
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