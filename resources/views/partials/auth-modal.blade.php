

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

        <div class="auth-providers">
          <button type="button" class="auth-provider-btn" data-provider="Google">
            Continue with Google
          </button>
          <button type="button" class="auth-provider-btn" data-provider="LinkedIn">
            Continue with LinkedIn
          </button>
        </div>

        <div class="auth-footer-text">
          Already have an account?
          <button type="button" onclick="switchAuthTab('login')">Login</button>
          • New here?
          <button type="button" onclick="switchAuthTab('signup')">Sign up</button>
        </div>
      </div>
    </div>
  </div>
