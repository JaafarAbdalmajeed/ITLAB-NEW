@extends('admin.layout')

@section('title', 'Manage Navbar')
@section('page-title', 'Manage Navbar Items')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Navbar Items</h2>
        <a href="{{ route('admin.navbar.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Item
        </a>
    </div>
    
    @if(session('success'))
        <div style="background: var(--admin-secondary); color: #000; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 20px; padding: 15px; background: #f5f5f5; border-radius: 4px;">
        <p style="margin: 0; color: #666;">
            <strong>Note:</strong> Drag and drop items to reorder them. Items are displayed in the navbar based on their order.
        </p>
    </div>

    <table class="admin-table" id="navbarTable">
        <thead>
            <tr>
                <th style="width: 50px;">Order</th>
                <th>Label</th>
                <th>URL / Route</th>
                <th>Icon</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="sortable">
            @forelse($items as $item)
                <tr data-id="{{ $item->id }}" style="cursor: move;">
                    <td>
                        <i class="fas fa-grip-vertical" style="color: #999; cursor: grab;"></i>
                        <span style="margin-left: 8px;">{{ $item->order }}</span>
                    </td>
                    <td><strong>{{ $item->label }}</strong></td>
                    <td>
                        @if($item->route)
                            <code>{{ $item->route }}</code>
                        @else
                            <code>{{ Str::limit($item->url, 40) }}</code>
                        @endif
                    </td>
                    <td>
                        @if($item->icon)
                            <i class="{{ $item->icon }}"></i> {{ $item->icon }}
                        @else
                            <span style="color: #999;">-</span>
                        @endif
                    </td>
                    <td>
                        @if($item->is_active)
                            <span style="color: var(--admin-secondary); font-weight: bold;">Active</span>
                        @else
                            <span style="color: #999;">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.navbar.edit', $item) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.navbar.destroy', $item) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;" onclick="return confirm('Are you sure you want to delete this navbar item?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No navbar items found. <a href="{{ route('admin.navbar.create') }}">Add a new item</a></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tbody = document.getElementById('sortable');
        if (tbody) {
            const sortable = new Sortable(tbody, {
                handle: '.fa-grip-vertical',
                animation: 150,
                onEnd: function(evt) {
                    const items = Array.from(tbody.querySelectorAll('tr[data-id]')).map((row, index) => ({
                        id: row.getAttribute('data-id'),
                        order: index
                    }));
                    
                    fetch('{{ route("admin.navbar.update-order") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ items: items })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update order numbers in the table
                            items.forEach((item, index) => {
                                const row = tbody.querySelector(`tr[data-id="${item.id}"]`);
                                if (row) {
                                    const orderCell = row.querySelector('td:first-child span');
                                    if (orderCell) {
                                        orderCell.textContent = index;
                                    }
                                }
                            });
                            
                            // Show success message
                            const successMsg = document.createElement('div');
                            successMsg.style.cssText = 'background: var(--admin-secondary); color: #000; padding: 12px; border-radius: 4px; margin-bottom: 20px;';
                            successMsg.textContent = 'Order updated successfully!';
                            document.querySelector('.admin-card').insertBefore(successMsg, document.querySelector('.admin-card-header'));
                            setTimeout(() => successMsg.remove(), 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to update order. Please refresh the page.');
                    });
                }
            });
        }
    });
</script>
@endpush
@endsection

