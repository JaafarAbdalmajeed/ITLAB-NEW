@extends('admin.layout')

@section('title', 'View Contact Message')
@section('page-title', 'View Contact Message')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Message Details</h2>
        <div>
            @if(!$contact->read)
                <form action="{{ route('admin.contacts.mark-read', $contact) }}" method="POST" style="display: inline; margin-left: 10px;">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i> Mark as Read
                    </button>
                </form>
            @else
                <form action="{{ route('admin.contacts.mark-unread', $contact) }}" method="POST" style="display: inline; margin-left: 10px;">
                    @csrf
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Mark as Unread
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary" style="margin-left: 10px;">
                <i class="fas fa-arrow-right"></i> Back
            </a>
        </div>
    </div>

    <div style="padding: 20px;">
        <div style="background: var(--admin-bg); padding: 20px; border-radius: 5px; margin-bottom: 20px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div>
                    <strong style="color: #666; display: block; margin-bottom: 5px;">Name:</strong>
                    <span style="font-size: 16px;">{{ $contact->name }}</span>
                </div>
                <div>
                    <strong style="color: #666; display: block; margin-bottom: 5px;">Email:</strong>
                    <a href="mailto:{{ $contact->email }}" style="color: var(--admin-secondary);">{{ $contact->email }}</a>
                </div>
                @if($contact->phone)
                <div>
                    <strong style="color: #666; display: block; margin-bottom: 5px;">Phone:</strong>
                    <a href="tel:{{ $contact->phone }}" style="color: var(--admin-secondary);">{{ $contact->phone }}</a>
                </div>
                @endif
                <div>
                    <strong style="color: #666; display: block; margin-bottom: 5px;">Date:</strong>
                    <span>{{ $contact->created_at->format('Y-m-d H:i:s') }}</span>
                </div>
                <div>
                    <strong style="color: #666; display: block; margin-bottom: 5px;">Status:</strong>
                    @if($contact->read)
                        <span style="color: #28a745;">✓ Read</span>
                        @if($contact->read_at)
                            <br><small style="color: #666;">At: {{ $contact->read_at->format('Y-m-d H:i') }}</small>
                        @endif
                        @if($contact->readByUser)
                            <br><small style="color: #666;">By: {{ $contact->readByUser->name }}</small>
                        @endif
                    @else
                        <span style="color: #dc3545; font-weight: bold;">● Unread</span>
                    @endif
                </div>
            </div>
        </div>

        @if($contact->subject)
        <div style="margin-bottom: 20px;">
            <strong style="color: #666; display: block; margin-bottom: 5px;">Subject:</strong>
            <div style="background: var(--admin-card); padding: 15px; border-radius: 5px; border-right: 3px solid var(--admin-secondary);">
                {{ $contact->subject }}
            </div>
        </div>
        @endif

        <div style="margin-bottom: 20px;">
            <strong style="color: #666; display: block; margin-bottom: 5px;">Message:</strong>
            <div style="background: var(--admin-card); padding: 20px; border-radius: 5px; border-right: 3px solid var(--admin-secondary); white-space: pre-wrap; line-height: 1.6;">
                {{ $contact->message }}
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <strong style="color: #666; display: block; margin-bottom: 5px;">Admin Notes:</strong>
            <form action="{{ route('admin.contacts.update-notes', $contact) }}" method="POST">
                @csrf
                @method('PUT')
                <textarea name="admin_notes" class="form-control" rows="4" placeholder="Add your notes here...">{{ $contact->admin_notes }}</textarea>
                <button type="submit" class="btn btn-primary" style="margin-top: 10px;">
                    <i class="fas fa-save"></i> Save Notes
                </button>
            </form>
        </div>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--admin-border);">
            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete Message
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

