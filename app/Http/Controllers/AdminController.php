<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $admin = Admin::where('email', $validated['email'])->first();

        if (!$admin || !Hash::check($validated['password'], $admin->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        Log::info('Admin logged in: ' . $admin->email);

        return response()->json([
            'message' => 'Admin login successful',
            'token' => $admin->createToken('admin-token', ['admin'])->plainTextToken,
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = Auth::user(); // Get authenticated user

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Revoke all tokens for the user
        $user->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function technologyReport() {
        
    }
}
