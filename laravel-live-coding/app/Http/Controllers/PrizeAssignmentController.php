<?php

namespace App\Http\Controllers;

use App\Models\PrizeAssignment;
use App\Models\RankGroup;
use Illuminate\Http\Request;

class PrizeAssignmentController extends Controller
{
    public function assignPrizes(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'rank_group_id' => 'required|exists:rank_groups,id',
            'prize_amount_usd' => 'required|numeric|min:0',
            'prize_number' => 'required|integer|min:1',
        ]);

        // Calculate the odds of winning
        $totalPrizeNumbers = 1000000;
        $oddsOfWinning = $validatedData['prize_number'] / $totalPrizeNumbers;

        // Store the prize assignment in the database
        $prizeAssignment = PrizeAssignment::create([
            'rank_group_id' => $validatedData['rank_group_id'],
            'prize_amount_usd' => $validatedData['prize_amount_usd'],
            'prize_number' => $validatedData['prize_number'],
            'odds_of_winning' => $oddsOfWinning,
        ]);

        // Retrieve the group name based on the provided rank_group_id
        $groupName = RankGroup::findOrFail($validatedData['rank_group_id'])->name;

        // Return a success response with the group name and success message
        return response()->json([
            'message' => 'Prize assigned successfully',
            'group_name' => $groupName,
            'request_info' => $validatedData,
        ], 200);
    }
}
