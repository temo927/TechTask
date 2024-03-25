<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function login(Request $request)
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
                $admin = Auth::guard('admin')->user();
                // Revoke all of the user's tokens
                $admin->tokens()->delete();
                // Create a new token
                $token = $admin->createToken('Admin Token')->plainTextToken;
                return response()->json(['token' => $token, 'message' => 'Admin logged in successfully'], 200);
            }
        } elseif ($validatedData['role'] === 'player') {
            $credentials = $request->only('email', 'password');
            if (Auth::guard('player')->attempt($credentials)) {
                // Authentication passed for player
                $player = Auth::guard('player')->user();
                // Revoke all of the user's tokens
                $player->tokens()->delete();
                // Create a new token
                $token = $player->createToken('Player Token')->plainTextToken;
                return response()->json(['token' => $token, 'message' => 'Player logged in successfully'], 200);
            }
        }

        // If authentication fails, return error response
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function PlayerRegister(Request $request): string
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
            'lang' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:players',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new player
        $player = Player::create([
            'username' => $validatedData['username'],
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'gender' => $validatedData['gender'],
            'lang' => $validatedData['lang'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'rank_id' => 1, // Default rank ID for newcomer
            'balance' => 0.000, // Default balance
            'is_blocked' => false, // Default is_blocked status
            'last_spin_time' => null // Default is null
        ]);

        // Generate token for player
        $token = $player->createToken('Player Token')->plainTextToken;

        // Return success response with token
        return response()->json([
            'token' => $token,
            'message' => 'Player registered successfully'
        ], 201);
    }

    public function AdminRegister(Request $request): string
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new admin
        $admin = Admin::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Generate token for admin
        $token = $admin->createToken('Admin Token')->plainTextToken;

        // Return success response with token
        return response()->json([
            'token' => $token,
            'message' => 'Admin registered successfully'
        ], 201);
    }
}
