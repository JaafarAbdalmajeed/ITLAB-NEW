@extends('layouts.app')

@section('title', 'Create New Account - ITLAB')
@section('body-class', 'page-auth')

@section('content')
<div style="max-width: 400px; margin: 100px auto; padding: 20px;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="color: #04aa6d; margin-bottom: 10px;">IT<span style="background: #04aa6d; color: #000; padding: 2px 8px; border-radius: 3px;">LAB</span></h1>
        <h2>Create New Account</h2>
    </div>

    <form action="{{ route('auth.register') }}" method="POST" style="background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        @csrf
        
        <div style="margin-bottom: 20px;">
            <label for="name" style="display: block; margin-bottom: 5px; font-weight: 600;">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
            @error('name')
                <span style="color: red; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="email" style="display: block; margin-bottom: 5px; font-weight: 600;">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
            @error('email')
                <span style="color: red; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password" style="display: block; margin-bottom: 5px; font-weight: 600;">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
            @error('password')
                <span style="color: red; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password_confirmation" style="display: block; margin-bottom: 5px; font-weight: 600;">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" style="width: 100%; padding: 12px; background: #04aa6d; color: #000; border: none; border-radius: 5px; font-weight: 600; cursor: pointer; font-size: 16px;">
            Create Account
        </button>
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('auth.login') }}" style="color: #666; text-decoration: none;">Already have an account? Login</a>
    </div>

    <div style="text-align: center; margin-top: 10px;">
        <a href="{{ route('home') }}" style="color: #666; text-decoration: none;">Back to Main Site</a>
    </div>
</div>
@endsection

