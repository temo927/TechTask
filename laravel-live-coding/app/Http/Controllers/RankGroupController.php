<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use App\Models\RankGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RankGroupController extends Controller
{
    public function groupRanksByCategory(Request $request): JsonResponse
    {
        // Retrieve category name and rank IDs from the request body
        $categoryName = $request->input('category_name');
        $rankIds = $request->input('rank_ids');

        // Find or create the rank group based on the provided category name
        $rankGroup = RankGroup::firstOrCreate(['name' => $categoryName]);

        // Attach ranks to the rank group
        $rankGroup->ranks()->syncWithoutDetaching($rankIds);

        // Retrieve the rank group ID
        $rankGroupId = $rankGroup->id;

        // Retrieve ranks associated with the rank group ID
        $ranksInGroup = Rank::whereHas('rankGroups', function ($query) use ($rankGroupId) {
            $query->where('id', $rankGroupId);
        })->get();

        // Return a success response with the rank group ID and ranks
        return response()->json([
            'message' => 'Ranks grouped successfully',
            'rank_group_id' => $rankGroupId,
            'ranks_in_group' => $ranksInGroup
        ], 200);
    }
}
