<?php

namespace App\Http\Controllers;

use App\Enums\OAuthProvider;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    public function redirect(OAuthProvider $provider): RedirectResponse
    {
        return Socialite::driver($provider->driver())->redirect();
    }

    public function callback(OAuthProvider $provider): RedirectResponse
    {
        $oAuthUser = Socialite::driver($provider->driver())->user();

        $user = User::where('email', $oAuthUser->email)->first();
        if ($user) {
            $user->oauth_id = $oAuthUser->id;
            $user->oauth_provider = $provider;
            $user->oauth_token = $oAuthUser->token;
            $user->oath_refresh_token = $oAuthUser->refreshToken;
            $user->save();
        } else {
            $user = User::create([
                'name' => $oAuthUser->name,
                'email' => $oAuthUser->email,
                'oauth_id' => $oAuthUser->id,
                'oauth_provider' => $provider,
                'oauth_token' => $oAuthUser->token,
                'oath_refresh_token' => $oAuthUser->refreshToken,
            ]);
        }

        Auth::login($user);

        return redirect(config('app.frontend_url').'?type=success&message=successfully+logged+in');
    }
}
