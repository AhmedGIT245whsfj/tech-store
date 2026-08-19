@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Users</h2>
    <p class="text-muted mb-0">View registered users and their activity</p>
</div>

<div class="card content-card table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Orders</th>
                    <th>Joined</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>#{{ $user->id }}</td>

                        <td>
                            <strong>{{ $user->name }}</strong>
                        </td>

                        <td>{{ $user->email }}</td>

                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-primary">Admin</span>
                            @else
                                <span class="badge bg-secondary">User</span>
                            @endif
                        </td>

                        <td>{{ $user->orders_count }}</td>

                        <td>{{ $user->created_at->format('d M Y') }}</td>

                        <td>
                            <a
                                href="{{ route('admin.users.show', $user) }}"
                                class="btn btn-sm btn-outline-dark"
                            >
                                Details
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $users->links() }}
</div>
@endsection
