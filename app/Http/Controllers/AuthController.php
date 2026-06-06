<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        // Mendukung login menggunakan format email atau username secara fleksibel
        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        $loginData = [
            $loginType => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($loginData, $remember)) {
            // Mencegah session fixation attack dengan memperbarui ID session
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('username');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Bersihkan data sesi dan perbarui CSRF token untuk mencegah session hijacking
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
