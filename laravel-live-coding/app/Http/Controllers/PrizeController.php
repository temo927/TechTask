<?php

namespace App\Http\Controllers;

use App\Models\Prize;
use Illuminate\Http\Request;

class PrizeController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:custom_prize,lottery',
        ]);

        // Create a new prize instance
        $prize = new Prize();
        $prize->name = $validatedData['name'];
        $prize->type = $validatedData['type'];
        $prize->save();

        // Return the newly created prize
        return response()->json(['prize' => $prize], 201);
    }
}
