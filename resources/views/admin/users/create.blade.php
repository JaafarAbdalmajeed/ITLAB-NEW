@extends('admin.layout')

@section('title', 'Create New User')
@section('page-title', 'Create New User')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Create New User</h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Users
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

    @if($errors->any())
        <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin: 20px;">
            <ul style="margin: 0; padding-right: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}" style="padding: 20px;">
        @csrf
        
        <div style="margin-bottom: 20px;">
            <label for="name" style="display: block; margin-bottom: 5px; font-weight: 600;">Name <span style="color: red;">*</span></label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')
                <span style="color: red; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="email" style="display: block; margin-bottom: 5px; font-weight: 600;">Email <span style="color: red;">*</span></label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
            @error('email')
                <span style="color: red; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password" style="display: block; margin-bottom: 5px; font-weight: 600;">Password <span style="color: red;">*</span></label>
            <input type="password" id="password" name="password" class="form-control" required minlength="8">
            <small style="color: #666; font-size: 12px;">Minimum 8 characters</small>
            @error('password')
                <span style="color: red; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password_confirmation" style="display: block; margin-bottom: 5px; font-weight: 600;">Confirm Password <span style="color: red;">*</span></label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required minlength="8">
            @error('password_confirmation')
                <span style="color: red; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px; padding: 15px; background: #f9f9f9; border-radius: 4px; border: 1px solid #e0e0e0;">
            <label style="display: flex; align-items: center; cursor: pointer;">
                <input type="checkbox" name="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }} style="margin-left: 10px; width: 18px; height: 18px; cursor: pointer;">
                <div>
                    <strong style="display: block; margin-bottom: 5px;">Admin Account</strong>
                    <small style="color: #666; font-size: 12px;">Grant this user full administrative privileges. Admin users can manage all content, users, and settings.</small>
                </div>
            </label>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Create User
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection

