<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {

        request()->validate((['email' => 'required']));

        $user = User::where(['email' => request('email')])->first();

        if (! $user) {
            return response()->withException(throw new \Exception('User not found'));
        }

        $loginLink = URL::temporarySignedRoute('login.token', now()->addMinutes(5), ['user' => $user->id]);

        $user->notify(new \App\Notifications\login($loginLink));

        return response()->noContent();
    }

    public function loginWithToken(User $user)
    {
        Auth::login($user);

        request()->session()->regenerate();

        return redirect(config('app.frontend_url').'?type=success&message=successfully+logged+in');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
