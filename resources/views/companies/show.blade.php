@extends('layouts.app')

@section('title', $company->name)

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>{{ $company->name }}</h2>
        <div>
            <a href="{{ route('companies.edit', $company) }}" class="btn" style="background: #ffc107;">Edit</a>
            <a href="{{ route('invitations.create', ['company_id' => $company->id]) }}" class="btn btn-success">Invite Admin</a>
            <a href="{{ route('companies.index') }}" class="btn">Back</a>
        </div>
    </div>

    <div style="margin-top: 2rem;">
        <h3>Company Details</h3>
        <table class="table" style="width: 50%;">
            <tr>
                <th>ID:</th>
                <td>{{ $company->id }}</td>
            </tr>
            <tr>
                <th>Name:</th>
                <td>{{ $company->name }}</td>
            </tr>
            <tr>
                <th>Email:</th>
                <td>{{ $company->email }}</td>
            </tr>
            <tr>
                <th>Phone:</th>
                <td>{{ $company->phone ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Created:</th>
                <td>{{ $company->created_at->format('Y-m-d H:i:s') }}</td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 2rem;">
        <h3>Company Users ({{ $company->users->count() }})</h3>
        
        @if($company->users->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($company->users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No users in this company yet. <a href="{{ route('invitations.create', ['company_id' => $company->id]) }}">Invite an admin</a> to get started.</p>
        @endif
    </div>
</div>
@endsection