<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phone;
use App\Models\Technology;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    //
    public function getProfile()
    {
        $user = Auth::user()->load('phones');
        return response()->json($user);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'additional_phones' => 'array',
            'additional_phones.*' => 'string|max:20',
            'location' => 'nullable|string', // Latitude, Longitude
            'technology_interests' => 'array',
            'technology_interests.*' => 'exists:technologies,id'
        ]);

        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'location' => $validated['location'] ?? null,
        ]);

        // Manage additional phones
        Phone::where('user_id', $user->id)->delete();
        if (!empty($validated['additional_phones'])) {
            foreach ($validated['additional_phones'] as $phone) {
                Phone::create([
                    'user_id' => $user->id,
                    'phone_number' => $phone,
                ]);
            }
        }

        // Sync technology interests
        $user->technologies()->sync($validated['technology_interests']);

        Log::info('User updated profile: ' . $user->email);

        return response()->json(['message' => 'Profile updated successfully']);
    }
}
