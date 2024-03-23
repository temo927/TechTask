<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function login(LoginUserRequest $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'role' => 'required|string|in:admin,player',
        ]);

        // Attempt to authenticate the user based on the role
        if ($validatedData['role'] === 'admin') {
            $credentials = $request->only('email', 'password');
            if (Auth::guard('admin')->attempt($credentials)) {
                // Authentication passed for admin
                $user = Auth::guard('admin')->user();
                // Revoke all of the user's tokens
                $user->tokens()->delete();
                // Create a new token
                $token = $user->createToken('Admin Token')->plainTextToken;
                return response()->json(['token' => $token, 'message' => 'Admin logged in successfully'], 200);
            }
        } elseif ($validatedData['role'] === 'player') {
            $credentials = $request->only('email', 'password');
            if (Auth::guard('player')->attempt($credentials)) {
                // Authentication passed for player
                $user = Auth::guard('player')->user();
                // Revoke all of the user's tokens
                $user->tokens()->delete();
                // Create a new token
                $token = $user->createToken('Player Token')->plainTextToken;
                return response()->json(['token' => $token, 'message' => 'Player logged in successfully'], 200);
            }
        }

        // If authentication fails, return error response
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function register(StoreUserRequest $request) : string
    {
        $data = $request->only(['name', 'email', 'password', 'role']);

        // Create a new user based on the role

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role'=> $data['role']
            ]);

        $token = $user->createToken($data['role'] . ' Token')->plainTextToken;

        return response()->json(
            [
            'token' => $token,
            'message' => 'User created successfully'
            ], 201);
    }
}
