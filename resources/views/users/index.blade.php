@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="card">
    <h2>Users</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                @if(auth()->user()->isSuperAdmin())
                    <th>Company</th>
                @endif
                <th>Joined</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                @if(auth()->user()->isSuperAdmin())
                    <td>{{ $user->company->name ?? 'N/A' }}</td>
                @endif
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No users found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection