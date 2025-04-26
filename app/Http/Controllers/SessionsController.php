<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('session.login-session'); // Your login blade
    }

    public function store(Request $request)
    {
      // Hardcoded credentials for testing
    $defaultEmail = 'admin@gmail.com';
    $defaultPassword = '1234567890';

    if ($request->email === $defaultEmail && $request->password === $defaultPassword) {
        Auth::guard('corporate')->loginUsingId(1); // or Auth::login($adminUser)
        $request->session()->regenerate();
    
        // ✅ store role info in session
        session(['user_role' => 'admin']);
    
        return redirect()->route('dashboard')->with('success', 'Logged in successfully!');
    } else {
        // Try corporate login
        $corporate = \App\Models\Corporate::where('email', $request->email)
            ->where('password', $request->password) // Plaintext match
            ->first();
    
        if ($corporate) {
            Auth::guard('corporate')->login($corporate);
            $request->session()->regenerate();
    
            // ✅ store role info in session
            session(['user_role' => 'corporate']);
    
            return redirect()->route('dashboard')->with('success', 'Logged in successfully!');
        } else {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
    }
    
    }

    public function destroy(Request $request)
    {
        \Log::info('Logging out user'); // Debug log
    
        Auth::guard('corporate')->logout(); // Logs the user out
        $request->session()->invalidate(); // Invalidates the session
        $request->session()->regenerateToken(); // Regenerates CSRF token
    
        return redirect('/login')->with('success', 'Logged out successfully.');
    }
    
}
