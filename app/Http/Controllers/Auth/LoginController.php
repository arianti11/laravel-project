<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        // Redirect if already logged in
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Validation
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Remember me
        $remember = $request->filled('remember');

        // Attempt login
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Log login activity
            $this->logLogin(Auth::user(), $request);

            // Redirect based on role
            return $this->redirectBasedOnRole();
        }

        // Login failed
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        // IMPORTANT: Log BEFORE logout (karena setelah logout Auth::user() jadi null)
        if (Auth::check()) {
            $this->logLogout(Auth::user(), $request);
        }

        // Logout user
        Auth::guard()->logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Flush session
        Session::flush();

        // Redirect to login
        return redirect()->route('login')
            ->with('success', 'Logout berhasil');
    }

    /**
     * Redirect user based on their role
     */
    protected function redirectBasedOnRole()
    {
        $user = Auth::user();

        // Check if user is active
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Akun Anda tidak aktif. Hubungi administrator.');
        }

        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isStaff()) {
            return redirect()->route('staff.dashboard');
        }

        // Default to user dashboard
        return redirect()->route('user.dashboard');
    }

    /**
     * Log login activity
     */
    protected function logLogin($user, $request)
    {
        try {
            ActivityLog::create([
                'user_id' => $user->id,
                'type' => 'login',
                'description' => "User {$user->name} logged in",
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        } catch (\Exception $e) {
            // Silent fail - don't break login if logging fails
            \Log::error('Failed to log login activity: ' . $e->getMessage());
        }
    }

    /**
     * Log logout activity
     */
    protected function logLogout($user, $request)
    {
        try {
            ActivityLog::create([
                'user_id' => $user->id,
                'type' => 'logout',
                'description' => "User {$user->name} logged out",
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        } catch (\Exception $e) {
            // Silent fail - don't break logout if logging fails
            \Log::error('Failed to log logout activity: ' . $e->getMessage());
        }
    }
}