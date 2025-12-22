@extends('admin.layout')

@section('title', 'Manage Contacts')
@section('page-title', 'Manage Contacts')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Contact Messages</h2>
        <div>
            <span style="margin-left: 15px; color: #666;">
                Total: {{ $totalCount }} | Unread: <strong style="color: var(--admin-secondary);">{{ $unreadCount }}</strong>
            </span>
        </div>
    </div>

    <!-- Filters -->
    <div style="margin-bottom: 20px; padding: 15px; background: var(--admin-bg); border-radius: 5px;">
        <a href="{{ route('admin.contacts.index') }}" class="btn {{ !request('filter') ? 'btn-primary' : 'btn-secondary' }}" style="margin-left: 10px;">
            All
        </a>
        <a href="{{ route('admin.contacts.index', ['filter' => 'unread']) }}" class="btn {{ request('filter') === 'unread' ? 'btn-primary' : 'btn-secondary' }}" style="margin-left: 10px;">
            Unread ({{ $unreadCount }})
        </a>
        <a href="{{ route('admin.contacts.index', ['filter' => 'read']) }}" class="btn {{ request('filter') === 'read' ? 'btn-primary' : 'btn-secondary' }}" style="margin-left: 10px;">
            Read
        </a>
    </div>

    <form id="bulkDeleteForm" action="{{ route('admin.contacts.bulk-delete') }}" method="POST">
        @csrf
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 30px;">
                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                    </th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    <tr style="{{ !$contact->read ? 'background: #fff3cd;' : '' }}">
                        <td>
                            <input type="checkbox" name="contacts[]" value="{{ $contact->id }}" class="contact-checkbox">
                        </td>
                        <td><strong>{{ $contact->name }}</strong></td>
                        <td>{{ $contact->email }}</td>
                        <td>
                            {{ $contact->subject ?: 'No Subject' }}
                            @if(!$contact->read)
                                <span style="background: var(--admin-secondary); color: #000; padding: 2px 8px; border-radius: 10px; font-size: 11px; margin-right: 5px;">New</span>
                            @endif
                        </td>
                        <td>{{ $contact->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($contact->read)
                                <span style="color: #28a745;">✓ Read</span>
                            @else
                                <span style="color: #dc3545; font-weight: bold;">● Unread</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;" onclick="return confirm('Are you sure you want to delete this message?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px;">
                            No contact messages found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($contacts->count() > 0)
            <div style="margin-top: 20px;">
                <button type="button" class="btn btn-danger" onclick="bulkDelete()" style="margin-top: 10px;">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
            </div>
        @endif
    </form>
    
    <div style="margin-top: 20px;">
        {{ $contacts->links() }}
    </div>
</div>

<script>
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.contact-checkbox');
    checkboxes.forEach(cb => cb.checked = selectAll.checked);
}

function bulkDelete() {
    const checked = document.querySelectorAll('.contact-checkbox:checked');
    if (checked.length === 0) {
        alert('Please select at least one message');
        return;
    }
    if (confirm('Are you sure you want to delete the selected messages?')) {
        document.getElementById('bulkDeleteForm').submit();
    }
}
</script>
@endsection

