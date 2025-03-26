<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\ClientRegister;
use App\Events\ClientLogin;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_numbers' => 'array',
            'referral_source' => 'nullable|string|in:LinkedIn,Facebook,Google,Friend,Website,Other',
        ]);
        $client = User::create($validated);

        event(new ClientRegister($client));
        
        Log::info("New Client Registered: {$client->email}");

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $client->createToken('auth_token')->plainTextToken,
            'user' => $client,
        ], 201);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $validated['email'])->first();
        // dd($validated['password'] = Hash::make($value));
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        Log::info('User logged in: ' . $user->email);

        return response()->json([
            'message' => 'Login successful',
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => $user,
        ], 200);    
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
