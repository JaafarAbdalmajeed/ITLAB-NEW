<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth provider
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
            return $this->handleSocialCallback($socialUser, 'google');
        } catch (Exception $e) {
            return redirect()->route('auth.login')
                ->with('error', 'Failed to login with Google. Please try again.');
        }
    }

    /**
     * Redirect to Facebook OAuth provider
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Handle Facebook OAuth callback
     */
    public function handleFacebookCallback()
    {
        try {
            $socialUser = Socialite::driver('facebook')->user();
            return $this->handleSocialCallback($socialUser, 'facebook');
        } catch (Exception $e) {
            return redirect()->route('auth.login')
                ->with('error', 'Failed to login with Facebook. Please try again.');
        }
    }

    /**
     * Redirect to LinkedIn OAuth provider
     */
    public function redirectToLinkedIn()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    /**
     * Handle LinkedIn OAuth callback
     */
    public function handleLinkedInCallback()
    {
        try {
            $socialUser = Socialite::driver('linkedin')->user();
            return $this->handleSocialCallback($socialUser, 'linkedin');
        } catch (Exception $e) {
            return redirect()->route('auth.login')
                ->with('error', 'Failed to login with LinkedIn. Please try again.');
        }
    }

    /**
     * Redirect to Twitter OAuth provider
     */
    public function redirectToTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Handle Twitter OAuth callback
     */
    public function handleTwitterCallback()
    {
        try {
            $socialUser = Socialite::driver('twitter')->user();
            return $this->handleSocialCallback($socialUser, 'twitter');
        } catch (Exception $e) {
            return redirect()->route('auth.login')
                ->with('error', 'Failed to login with Twitter. Please try again.');
        }
    }

    /**
     * Redirect to Instagram OAuth provider
     */
    public function redirectToInstagram()
    {
        return Socialite::driver('instagram')->redirect();
    }

    /**
     * Handle Instagram OAuth callback
     */
    public function handleInstagramCallback()
    {
        try {
            $socialUser = Socialite::driver('instagram')->user();
            return $this->handleSocialCallback($socialUser, 'instagram');
        } catch (Exception $e) {
            return redirect()->route('auth.login')
                ->with('error', 'Failed to login with Instagram. Please try again.');
        }
    }

    /**
     * Handle social authentication callback
     */
    protected function handleSocialCallback($socialUser, $provider)
    {
        try {
            // Find or create user
            $user = User::where('provider', $provider)
                ->where('provider_id', $socialUser->getId())
                ->first();

            if (!$user) {
                // Check if user with same email exists (link accounts)
                $user = User::where('email', $socialUser->getEmail())->first();

                if ($user) {
                    // Link social account to existing user
                    $user->update([
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                        'avatar' => $socialUser->getAvatar(),
                    ]);
                } else {
                    // Create new user
                    $user = User::create([
                        'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
                        'email' => $socialUser->getEmail(),
                        'provider' => $provider,
                        'provider_id' => $socialUser->getId(),
                        'avatar' => $socialUser->getAvatar(),
                        'email_verified_at' => now(), // Social accounts are pre-verified
                        'password' => null, // No password for social auth users
                        'is_admin' => false,
                    ]);
                }
            } else {
                // Update avatar in case it changed
                $user->update([
                    'avatar' => $socialUser->getAvatar(),
                ]);
            }

            // Login user
            Auth::login($user, true);

            // Redirect based on user role
            if ($user->is_admin) {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/');
        } catch (Exception $e) {
            return redirect()->route('auth.login')
                ->with('error', 'An error occurred during authentication. Please try again.');
        }
    }
}
