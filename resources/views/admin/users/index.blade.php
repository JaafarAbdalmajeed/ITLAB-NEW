@extends('admin.layout')

@section('title', 'Manage Users')
@section('page-title', 'Manage Users')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>All Users</h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Add New User
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filters and Search -->
    <form method="GET" action="{{ route('admin.users.index') }}" style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap; align-items: end;">
        <div style="flex: 1; min-width: 200px;">
            <label for="search" style="display: block; margin-bottom: 5px; font-size: 13px;">Search:</label>
            <input type="text" id="search" name="search" class="form-control" value="{{ request('search') }}" placeholder="Name or Email">
        </div>
        <div style="flex: 1; min-width: 150px;">
            <label for="admin_only" style="display: block; margin-bottom: 5px; font-size: 13px;">Filter:</label>
            <select id="admin_only" name="admin_only" class="form-control">
                <option value="">All Users</option>
                <option value="1" {{ request('admin_only') == '1' ? 'selected' : '' }}>Admins Only</option>
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary" style="margin-top: 20px;">
                <i class="fas fa-search"></i> Search
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" style="margin-top: 20px;">
                <i class="fas fa-times"></i> Reset
            </a>
        </div>
    </form>

    <table class="admin-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Quizzes</th>
                <th>Tracks</th>
                <th>Registration Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->is_admin)
                            <span style="color: var(--admin-secondary); font-weight: bold;">Admin</span>
                        @else
                            <span>User</span>
                        @endif
                    </td>
                    <td>{{ $user->quiz_results_count }}</td>
                    <td>{{ $user->progress_count }}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;" onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">No users found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top: 20px;">
        {{ $users->links() }}
    </div>
</div>
@endsection

