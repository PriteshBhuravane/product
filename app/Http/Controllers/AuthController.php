<?php

namespace App\Http\Controllers;

use App\Http\User;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLog;
use App\Models\AdminLog;


use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function showLogin()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ],
            [
                'email.required' => 'Email is required',
                'email.email' => 'Enter a valid email',
                'password.required' => 'Password is required',
                'password.min' => 'Password must be at least 6 characters',
            ]
        );
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // Log to userlog (file)
            $userLogPath = storage_path('logs/userlog/userlog.txt');
            $userLogMsg = date('Y-m-d H:i:s') . " | User Login: " . Auth::user()->email . " | User ID: " . Auth::id() . "\n";
            file_put_contents($userLogPath, $userLogMsg, FILE_APPEND);

            // Log to user_logs table
            UserLog::create([
                'user_id' => Auth::id(),
                'action' => 'login',
                'details' => 'User Login: ' . Auth::user()->email,
            ]);

            // Log to adminlog if admin
            if (Auth::user()->user_type === 'admin') {
                $adminLogPath = storage_path('logs/adminlog/adminlog.txt');
                $adminLogMsg = date('Y-m-d H:i:s') . " | Admin Login: " . Auth::user()->email . " | Admin ID: " . Auth::id() . "\n";
                file_put_contents($adminLogPath, $adminLogMsg, FILE_APPEND);
                // Log to admin_logs table
                AdminLog::create([
                    'admin_id' => Auth::id(),
                    'action' => 'login',
                    'details' => 'Admin Login: ' . Auth::user()->email,
                ]);
                return redirect()->intended('/admin/dashboard');
            }
            return redirect('/user/home');
        }
        return back()->withErrors(['email' => 'Invalid credentials']);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }

    // Show profile edit form
    public function editProfile()
    {
        $user = Auth::user();
        return view('user.edit-profile', compact('user'));
    }

    // Update user profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}
