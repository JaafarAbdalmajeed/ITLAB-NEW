@extends('admin.layout')

@section('title', 'Manage Page Sections')
@section('page-title', 'Manage Sections: ' . $page->title)

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Page Sections: {{ $page->title }}</h2>
        <div>
            <a href="{{ route('admin.pages.sections.create', $page) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Section
            </a>
            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-secondary" style="margin-left: 10px;">
                <i class="fas fa-arrow-right"></i> Back to Page
            </a>
        </div>
    </div>

    @if($sections->count() > 0)
        <div style="margin-top: 20px;">
            <div id="sections-list">
                @foreach($sections as $section)
                    <div class="section-item" data-id="{{ $section->id }}" style="background: var(--admin-bg); padding: 20px; margin-bottom: 15px; border-radius: 8px; border: 1px solid var(--admin-border); cursor: move;">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                                    <i class="fas fa-grip-vertical" style="color: #999; cursor: move;"></i>
                                    <h3 style="margin: 0; font-size: 18px;">
                                        {{ $section->title ?: 'Untitled Section' }}
                                        <span style="font-size: 12px; color: #666; font-weight: normal;">
                                            ({{ $section->section_type }})
                                        </span>
                                    </h3>
                                    @if(!$section->published)
                                        <span style="background: #ffc107; color: #000; padding: 2px 8px; border-radius: 10px; font-size: 11px;">Draft</span>
                                    @endif
                                </div>
                                @if($section->subtitle)
                                    <p style="color: #666; margin: 5px 0;">{{ Str::limit($section->subtitle, 100) }}</p>
                                @endif
                                @if($section->content)
                                    <p style="color: #999; margin: 5px 0; font-size: 13px;">{{ Str::limit(strip_tags($section->content), 150) }}</p>
                                @endif
                                <div style="margin-top: 10px; font-size: 12px; color: #666;">
                                    Order: {{ $section->order }} | 
                                    Created: {{ $section->created_at->format('Y-m-d H:i') }}
                                </div>
                            </div>
                            <div style="display: flex; gap: 5px;">
                                <a href="{{ route('admin.pages.sections.edit', [$page, $section]) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px;">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.pages.sections.destroy', [$page, $section]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this section?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 40px; color: #999;">
            <i class="fas fa-layer-group" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
            <p style="font-size: 16px; margin-bottom: 10px;">No sections found</p>
            <p style="font-size: 14px; margin-bottom: 20px;">Add sections to organize your page content</p>
            <a href="{{ route('admin.pages.sections.create', $page) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add First Section
            </a>
        </div>
    @endif
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sectionsList = document.getElementById('sections-list');
    if (sectionsList) {
        const sortable = new Sortable(sectionsList, {
            handle: '.fa-grip-vertical',
            animation: 150,
            onEnd: function(evt) {
                const items = Array.from(sectionsList.children);
                const sections = items.map((item, index) => ({
                    id: item.dataset.id,
                    order: index
                }));

                fetch('{{ route('admin.pages.sections.update-order', $page) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ sections: sections })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            }
        });
    }
});
</script>
@endpush
@endsection

