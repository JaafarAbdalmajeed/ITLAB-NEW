

  <!-- AUTH MODAL -->
  <div class="auth-backdrop" id="authBackdrop">
    <div class="auth-modal">
      <button class="auth-close" id="authCloseBtn">&times;</button>

      <div class="auth-tabs">
        <button class="auth-tab active" id="tabLogin">Login</button>
        <button class="auth-tab" id="tabSignup">Sign Up</button>
      </div>

      <div class="auth-body">
        <!-- LOGIN FORM -->
        <form id="loginForm" class="auth-form" method="POST" action="{{ route('auth.login') }}">
          @csrf
          <label for="login-email">Email</label>
          <input id="login-email" name="email" type="email" placeholder="you@university.edu" required value="{{ old('email') }}">

          <label for="login-password">Password</label>
          <input id="login-password" name="password" type="password" placeholder="Password" required>

          <label style="display: flex; align-items: center; gap: 8px; margin-top: 8px;">
            <input type="checkbox" name="remember" value="1">
            <span style="font-size: 14px;">Remember me</span>
          </label>

          @if($errors->has('email') || $errors->has('password'))
            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-top: 12px; font-size: 14px;">
              {{ $errors->first('email') ?: $errors->first('password') }}
            </div>
          @endif

          <button type="submit" class="auth-primary-btn">Login</button>
        </form>

        <!-- SIGNUP FORM -->
        <form id="signupForm" class="auth-form hidden" method="POST" action="{{ route('auth.register') }}">
          @csrf
          <label for="signup-name">Full Name</label>
          <input id="signup-name" name="name" type="text" placeholder="Your name" required value="{{ old('name') }}">

          <label for="signup-email">Email</label>
          <input id="signup-email" name="email" type="email" placeholder="you@university.edu" required value="{{ old('email') }}">

          <label for="signup-password">Password</label>
          <input id="signup-password" name="password" type="password" placeholder="Create password (min 8 characters)" required>

          <label for="signup-password-confirm">Confirm Password</label>
          <input id="signup-password-confirm" name="password_confirmation" type="password" placeholder="Confirm password" required>

          @if($errors->any() && !$errors->has('email') && !$errors->has('password'))
            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-top: 12px; font-size: 14px;">
              @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
              @endforeach
            </div>
          @endif

          @if($errors->has('email'))
            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-top: 12px; font-size: 14px;">
              {{ $errors->first('email') }}
            </div>
          @endif

          @if($errors->has('password'))
            <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-top: 12px; font-size: 14px;">
              {{ $errors->first('password') }}
            </div>
          @endif

          <button type="submit" class="auth-primary-btn">Create Account</button>
        </form>

        <div class="auth-or">or continue with</div>

        <div class="auth-providers" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 10px;">
          <a href="{{ route('auth.google') }}" class="auth-provider-btn" style="text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px; background: #fff; border: 1px solid #ddd; border-radius: 5px; color: #333; font-weight: 500; cursor: pointer; transition: all 0.3s;">
            <i class="fab fa-google" style="color: #db4437;"></i> Google
          </a>
          <a href="{{ route('auth.facebook') }}" class="auth-provider-btn" style="text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px; background: #fff; border: 1px solid #ddd; border-radius: 5px; color: #333; font-weight: 500; cursor: pointer; transition: all 0.3s;">
            <i class="fab fa-facebook" style="color: #1877f2;"></i> Facebook
          </a>
          <a href="{{ route('auth.linkedin') }}" class="auth-provider-btn" style="text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px; background: #fff; border: 1px solid #ddd; border-radius: 5px; color: #333; font-weight: 500; cursor: pointer; transition: all 0.3s;">
            <i class="fab fa-linkedin" style="color: #0077b5;"></i> LinkedIn
          </a>
          <a href="{{ route('auth.twitter') }}" class="auth-provider-btn" style="text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px; background: #fff; border: 1px solid #ddd; border-radius: 5px; color: #333; font-weight: 500; cursor: pointer; transition: all 0.3s;">
            <i class="fab fa-twitter" style="color: #1da1f2;"></i> Twitter
          </a>
        </div>
        <div style="margin-bottom: 15px;">
          <a href="{{ route('auth.instagram') }}" class="auth-provider-btn" style="text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px; background: #fff; border: 1px solid #ddd; border-radius: 5px; color: #333; font-weight: 500; cursor: pointer; transition: all 0.3s; width: 100%;">
            <i class="fab fa-instagram" style="color: #e4405f;"></i> Instagram
          </a>
        </div>

        @if(session('error'))
          <div style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-top: 12px; font-size: 14px;">
            {{ session('error') }}
          </div>
        @endif

        <div class="auth-footer-text">
          Already have an account?
          <button type="button" onclick="switchAuthTab('login')">Login</button>
          • New here?
          <button type="button" onclick="switchAuthTab('signup')">Sign up</button>
        </div>
      </div>
    </div>
  </div>
