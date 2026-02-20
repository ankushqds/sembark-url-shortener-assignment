@extends('layouts.app')

@section('title', 'Companies')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Companies</h2>
        <a href="{{ route('companies.create') }}" class="btn btn-success">Add New Company</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Users</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($companies as $company)
            <tr>
                <td>{{ $company->id }}</td>
                <td>{{ $company->name }}</td>
                <td>{{ $company->email }}</td>
                <td>{{ $company->phone ?? 'N/A' }}</td>
                <td>{{ $company->users_count }}</td>
                <td>{{ $company->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('companies.show', $company) }}" class="btn" style="background: #17a2b8;">View</a>
                    <a href="{{ route('companies.edit', $company) }}" class="btn" style="background: #ffc107;">Edit</a>
                    
                    @if($company->users_count == 0)
                        <form method="POST" action="{{ route('companies.destroy', $company) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this company?')">Delete</button>
                        </form>
                    @endif
                    
                    <a href="{{ route('invitations.create', ['company_id' => $company->id]) }}" 
                       class="btn btn-success">Invite Admin</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No companies found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $companies->links() }}
</div>
@endsection