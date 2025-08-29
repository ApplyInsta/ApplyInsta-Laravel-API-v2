<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email|unique:users,email',
            'phone'    => 'nullable|string|unique:users,phone',
            'password' => 'required|string|min:6',
        ]);

        if (!$request->email && !$request->phone) {
            return response()->json([
                'success' => false,
                'message' => 'Either email or phone is required.'
            ], 422);
        }
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }


        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data'    => $user
        ], 201);

    }

    // SPA cookie/session login (for React web)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        if (!auth()->attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $request->session()->regenerate();
        return response()->json(['message' => 'Logged in']);
    }

    // Token login (for Mobile apps)
    public function tokenLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
            'device'   => ['nullable','string','max:255'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $abilities = ['*']; // or e.g. ['read', 'write']
        $token = $user->createToken($credentials['device'] ?? 'mobile', $abilities)->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function tokenLogout(Request $request)
    {
        // Revoke current token
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Token revoked']);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
