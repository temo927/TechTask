<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Admin;
use App\Models\Player;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function login(StoreUserRequest $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'role' => 'required|string|in:admin,player',
        ]);

        // Attempt to authenticate the user based on the role
        if ($validatedData['role'] === 'admin') {
            if (Auth::guard('admin')->attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
                // Authentication passed for admin
                return response()->json(['message' => 'Admin authenticated successfully'], 200);
            }
        } elseif ($validatedData['role'] === 'player') {
            if (Auth::guard('player')->attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
                // Authentication passed for player
                return response()->json(['message' => 'Player authenticated successfully'], 200);
            }
        }

        // Authentication failed
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function register(StoreUserRequest $request) : string
    {
        $data = $request->only(['name', 'email', 'password', 'role']);

        // Create a new user based on the role
        if ($data['role'] === 'admin') {
            $user = Admin::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
        } elseif ($data['role'] === 'player') {
            $user = Player::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
        } else {
            return response()->json(['error' => 'Invalid role'], 400);
        }

        $token = $user->createToken($data['role'] . ' Token')->plainTextToken;

        return response()->json(
            [
            'token' => $token,
            'message' => 'User created successfully'
            ], 201);
    }
}
