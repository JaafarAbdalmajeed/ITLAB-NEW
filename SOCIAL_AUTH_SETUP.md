# Social Authentication Setup Guide

This guide explains how to configure social authentication (Google, Facebook, LinkedIn, Twitter, Instagram) for ITLAB.

## 📋 Overview

The application supports OAuth authentication through the following providers:
- ✅ Google
- ✅ Facebook
- ✅ LinkedIn
- ✅ Twitter
- ✅ Instagram

## 🔧 Configuration Steps

### 1. Run Migration

First, run the migration to add social auth columns to the users table:

```bash
php artisan migrate
```

This will add:
- `provider` - The OAuth provider name (google, facebook, linkedin, twitter, instagram)
- `provider_id` - The user's ID from the OAuth provider
- `avatar` - User's profile picture URL
- Make `password` nullable (for social-only accounts)

### 2. Configure OAuth Providers

Add the following environment variables to your `.env` file:

#### Google OAuth

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable Google+ API
4. Go to "Credentials" → "Create Credentials" → "OAuth client ID"
5. Select "Web application"
6. Add authorized redirect URI: `http://your-domain.com/auth/google/callback`
7. Copy Client ID and Client Secret

```env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://your-domain.com/auth/google/callback
```

#### Facebook OAuth

1. Go to [Facebook Developers](https://developers.facebook.com/)
2. Create a new app
3. Add "Facebook Login" product
4. Go to Settings → Basic
5. Add your site URL and redirect URI: `http://your-domain.com/auth/facebook/callback`
6. Copy App ID and App Secret

```env
FACEBOOK_CLIENT_ID=your_facebook_app_id
FACEBOOK_CLIENT_SECRET=your_facebook_app_secret
FACEBOOK_REDIRECT_URI=http://your-domain.com/auth/facebook/callback
```

#### LinkedIn OAuth

1. Go to [LinkedIn Developers](https://www.linkedin.com/developers/)
2. Create a new app
3. Under "Auth" tab, add redirect URL: `http://your-domain.com/auth/linkedin/callback`
4. Copy Client ID and Client Secret

```env
LINKEDIN_CLIENT_ID=your_linkedin_client_id
LINKEDIN_CLIENT_SECRET=your_linkedin_client_secret
LINKEDIN_REDIRECT_URI=http://your-domain.com/auth/linkedin/callback
```

#### Twitter OAuth

1. Go to [Twitter Developer Portal](https://developer.twitter.com/)
2. Create a new app
3. Go to "Keys and tokens"
4. Generate OAuth 1.0a credentials
5. Add callback URL: `http://your-domain.com/auth/twitter/callback`
6. Copy API Key and API Secret Key

```env
TWITTER_CLIENT_ID=your_twitter_api_key
TWITTER_CLIENT_SECRET=your_twitter_api_secret_key
TWITTER_REDIRECT_URI=http://your-domain.com/auth/twitter/callback
```

#### Instagram OAuth

1. Go to [Facebook Developers](https://developers.facebook.com/) (Instagram uses Facebook's platform)
2. Create a new app
3. Add "Instagram Basic Display" product
4. Configure OAuth Redirect URIs: `http://your-domain.com/auth/instagram/callback`
5. Copy App ID and App Secret

```env
INSTAGRAM_CLIENT_ID=your_instagram_app_id
INSTAGRAM_CLIENT_SECRET=your_instagram_app_secret
INSTAGRAM_REDIRECT_URI=http://your-domain.com/auth/instagram/callback
```

### 3. Update .env File

Add all credentials to your `.env` file:

```env
# Google OAuth
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# Facebook OAuth
FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/facebook/callback

# LinkedIn OAuth
LINKEDIN_CLIENT_ID=
LINKEDIN_CLIENT_SECRET=
LINKEDIN_REDIRECT_URI=http://localhost:8000/auth/linkedin/callback

# Twitter OAuth
TWITTER_CLIENT_ID=
TWITTER_CLIENT_SECRET=
TWITTER_REDIRECT_URI=http://localhost:8000/auth/twitter/callback

# Instagram OAuth
INSTAGRAM_CLIENT_ID=
INSTAGRAM_CLIENT_SECRET=
INSTAGRAM_REDIRECT_URI=http://localhost:8000/auth/instagram/callback
```

**Note:** Replace `http://localhost:8000` with your actual domain in production.

### 4. Clear Config Cache

After updating `.env`, clear the config cache:

```bash
php artisan config:clear
php artisan config:cache
```

## 🎯 How It Works

### User Registration/Login Flow

1. User clicks on a social login button (e.g., "Login with Google")
2. User is redirected to the OAuth provider's consent screen
3. User grants permissions
4. OAuth provider redirects back to the application with an authorization code
5. Application exchanges the code for user information
6. System checks if user exists:
   - **If exists**: Login the user
   - **If doesn't exist**: Create a new user account
   - **If email matches existing account**: Link social account to existing account

### Account Linking

If a user registers with email/password and later logs in with social auth using the same email, the accounts are automatically linked. The user can then use either method to log in.

### User Model Changes

The `User` model now includes:
- `provider` - OAuth provider name (nullable)
- `provider_id` - OAuth provider user ID (nullable)
- `avatar` - Profile picture URL (nullable)
- `password` - Now nullable (required only for email/password accounts)

## 🔐 Security Notes

1. **Never commit** your OAuth credentials to version control
2. Use different OAuth apps for development and production
3. Regularly rotate your OAuth client secrets
4. Implement rate limiting on authentication endpoints
5. Validate all OAuth callbacks to prevent CSRF attacks (Laravel Socialite handles this)

## 🧪 Testing

To test social authentication:

1. Ensure all environment variables are set
2. Visit `/login` or `/register`
3. Click on any social login button
4. Complete the OAuth flow
5. Verify you're logged in and redirected appropriately

## 🐛 Troubleshooting

### Error: "Invalid redirect URI"
- Check that the redirect URI in your `.env` matches exactly with the one configured in the OAuth provider's dashboard
- Ensure there are no trailing slashes or protocol mismatches

### Error: "Invalid client"
- Verify that `CLIENT_ID` and `CLIENT_SECRET` are correct
- Check that the OAuth app is in the correct environment (development/production)

### Error: "User not found"
- This is normal for first-time social logins - the system will create a new user
- Ensure the database migration has been run

### Social login not appearing
- Check that the routes are registered correctly
- Verify that `SocialAuthController` is properly set up
- Clear route cache: `php artisan route:clear`

## 📚 Additional Resources

- [Laravel Socialite Documentation](https://laravel.com/docs/socialite)
- [Google OAuth Setup](https://developers.google.com/identity/protocols/oauth2)
- [Facebook Login Setup](https://developers.facebook.com/docs/facebook-login)
- [LinkedIn OAuth Setup](https://www.linkedin.com/developers/)
- [Twitter OAuth Setup](https://developer.twitter.com/en/docs/authentication/overview)
- [Instagram OAuth Setup](https://developers.facebook.com/docs/instagram-basic-display-api)

## ✅ Features Implemented

- ✅ Google OAuth
- ✅ Facebook OAuth
- ✅ LinkedIn OAuth
- ✅ Twitter OAuth
- ✅ Instagram OAuth
- ✅ Automatic account creation
- ✅ Account linking (email matching)
- ✅ Avatar/profile picture support
- ✅ Error handling and user feedback
- ✅ Social login buttons in login/register pages
- ✅ Social login buttons in auth modal

## 🎨 UI Integration

Social login buttons are integrated in:
- `/login` page
- `/register` page
- Auth modal (site-wide)
- Styled with Font Awesome icons
- Responsive grid layout

## 📝 Notes

- Users registered via social auth cannot use email/password login (they don't have passwords)
- Social auth users are automatically email-verified
- Avatar URLs are stored from the OAuth provider
- All OAuth providers are optional - you can enable/disable them by simply not setting credentials

