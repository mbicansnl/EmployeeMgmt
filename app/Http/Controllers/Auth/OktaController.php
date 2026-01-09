<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OktaController
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('okta')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    public function callback(): RedirectResponse
    {
        $oktaUser = Socialite::driver('okta')->user();

        $user = User::query()->firstOrCreate(
            ['idp_subject' => $oktaUser->getId(), 'idp_provider' => 'okta'],
            [
                'name' => $oktaUser->getName() ?? $oktaUser->getNickname() ?? 'Okta User',
                'email' => $oktaUser->getEmail(),
                'idp_email' => $oktaUser->getEmail(),
                'last_login_at' => now(),
            ]
        );

        $user->update([
            'name' => $oktaUser->getName() ?? $user->name,
            'email' => $oktaUser->getEmail() ?? $user->email,
            'idp_email' => $oktaUser->getEmail() ?? $user->idp_email,
            'last_login_at' => now(),
        ]);

        Auth::login($user, true);

        return redirect()->route('filament.admin.pages.dashboard');
    }
}
