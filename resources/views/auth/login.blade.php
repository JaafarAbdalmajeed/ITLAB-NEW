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

    <!-- Social Login Section -->
    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
        <div style="text-align: center; margin-bottom: 15px; color: #666; font-size: 14px;">Or login with</div>
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
            <a href="{{ route('auth.google') }}" style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 10px; background: #fff; border: 1px solid #ddd; border-radius: 5px; text-decoration: none; color: #333; font-weight: 500; transition: all 0.3s;">
                <i class="fab fa-google" style="color: #db4437;"></i> Google
            </a>
            <a href="{{ route('auth.facebook') }}" style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 10px; background: #fff; border: 1px solid #ddd; border-radius: 5px; text-decoration: none; color: #333; font-weight: 500; transition: all 0.3s;">
                <i class="fab fa-facebook" style="color: #1877f2;"></i> Facebook
            </a>
            <a href="{{ route('auth.linkedin') }}" style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 10px; background: #fff; border: 1px solid #ddd; border-radius: 5px; text-decoration: none; color: #333; font-weight: 500; transition: all 0.3s;">
                <i class="fab fa-linkedin" style="color: #0077b5;"></i> LinkedIn
            </a>
            <a href="{{ route('auth.twitter') }}" style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 10px; background: #fff; border: 1px solid #ddd; border-radius: 5px; text-decoration: none; color: #333; font-weight: 500; transition: all 0.3s;">
                <i class="fab fa-twitter" style="color: #1da1f2;"></i> Twitter
            </a>
        </div>
        <div style="margin-top: 10px;">
            <a href="{{ route('auth.instagram') }}" style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 10px; background: #fff; border: 1px solid #ddd; border-radius: 5px; text-decoration: none; color: #333; font-weight: 500; transition: all 0.3s;">
                <i class="fab fa-instagram" style="color: #e4405f;"></i> Instagram
            </a>
        </div>
    </div>

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-top: 15px; font-size: 14px;">
            {{ session('error') }}
        </div>
    @endif

    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('home') }}" style="color: #666; text-decoration: none;">Back to Main Site</a>
    </div>
</div>
@endsection

