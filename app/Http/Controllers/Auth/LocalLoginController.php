<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LocalLoginController
{
    public function show()
    {
        abort_unless(config('empmgr.local_auth_enabled'), 403);

        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless(config('empmgr.local_auth_enabled'), 403);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, true)) {
            throw ValidationException::withMessages([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('filament.admin.pages.dashboard');
    }
}
