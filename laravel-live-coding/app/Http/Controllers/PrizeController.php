<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Prize;
use Illuminate\Validation\ValidationException;

class PrizeController extends Controller
{

    public function storePrize(Request $request): JsonResponse
    {
        try {
            // Validate incoming request data
            $validatedData = $request->validate([
                'name' => 'required|string',
                'type' => 'required|in:custom_prize,lottery',
            ]);

            // Create a new prize instance
            $prize = Prize::create($validatedData);

            // Return the newly created prize
            return response()->json(['prize' => $prize], 201);
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['error' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            // Handle any other errors that occur during prize creation
            return response()->json(['error' => 'Failed to create prize.'], 500);
        }
    }
}

