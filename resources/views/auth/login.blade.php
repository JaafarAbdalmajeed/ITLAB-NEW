@extends('layouts.app')

@section('title', 'Login - ITLAB Admin')
@section('body-class', 'page-auth')

@section('content')
<div style="max-width: 400px; margin: 100px auto; padding: 20px;">
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="color: #04aa6d; margin-bottom: 10px;">IT<span style="background: #04aa6d; color: #000; padding: 2px 8px; border-radius: 3px;">LAB</span></h1>
        <h2>Admin Login</h2>
    </div>

    <form action="{{ route('auth.login') }}" method="POST" style="background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        @csrf
        
        <div style="margin-bottom: 20px;">
            <label for="email" style="display: block; margin-bottom: 5px; font-weight: 600;">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password" style="display: block; margin-bottom: 5px; font-weight: 600;">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div style="margin-bottom: 20px;">
            <label>
                <input type="checkbox" name="remember" value="1">
                Remember me
            </label>
        </div>

        <button type="submit" style="width: 100%; padding: 12px; background: #04aa6d; color: #000; border: none; border-radius: 5px; font-weight: 600; cursor: pointer; font-size: 16px;">
            Login
        </button>
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('home') }}" style="color: #666; text-decoration: none;">Back to Main Site</a>
    </div>
</div>
@endsection

