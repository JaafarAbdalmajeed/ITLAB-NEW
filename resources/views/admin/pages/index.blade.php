@extends('admin.layout')

@section('title', 'Manage Pages')
@section('page-title', 'Manage Pages')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>All Pages</h2>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Page
        </a>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Slug</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pages as $page)
                <tr>
                    <td><strong>{{ $page->title }}</strong></td>
                    <td><code>{{ $page->slug }}</code></td>
                    <td>
                        @if($page->published)
                            <span style="color: var(--admin-secondary); font-weight: bold;">Published</span>
                        @else
                            <span style="color: #999;">Draft</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.pages.sections.index', $page) }}" class="btn btn-info" style="padding: 5px 10px; font-size: 12px; margin-left: 5px; background: #17a2b8; border-color: #17a2b8;">
                            <i class="fas fa-layer-group"></i> Sections
                        </a>
                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;" onclick="return confirm('Are you sure you want to delete this page?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No pages found. <a href="{{ route('admin.pages.create') }}">Add a new page</a></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

