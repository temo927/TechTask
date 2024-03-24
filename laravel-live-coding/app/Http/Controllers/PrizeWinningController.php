<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Prize;
use App\Models\PrizeAssignment;
use App\Models\PrizeWinning;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PrizeWinningController extends Controller
{
    public function checkPrize()
    {
        // Retrieve the most recently registered player
        $player = Player::latest()->first();

        // Check if player exists
        if (!$player) {
            return response()->json(['message' => 'No players found'], 404);
        }

        // Check if player has spun the wheel recently
        $lastSpinTime = $player->last_spin_time;
        $currentTime = now();
        $settings = Setting::first();
        $cooldownHours = $settings->wheel_spin_cooldown_hours ?? 24; // Default cooldown time is 24 hours

        // Check if cooldown period has passed since last spin
        if ($lastSpinTime && Carbon::parse($lastSpinTime)->addHours($cooldownHours)->gt($currentTime)) {
            $remainingCooldown = Carbon::parse($lastSpinTime)->addHours($cooldownHours)->diffInHours($currentTime);
            return response()->json(['message' => 'Please wait until the cooldown period is over.', 'cooldown_hours_remaining' => $remainingCooldown], 403);
        }
        // Retrieve player's rank and associated rank group
        $rank = $player->rank; // Assuming the player's rank is stored in a 'rank' relationship
        $rankGroup = $rank->rankGroups()->first(); // Assuming rank groups are stored in a 'rankGroups' relationship

        // Check if rank group exists
        if (!$rankGroup) {
            return response()->json(['message' => 'Rank group not found for the player'], 404);
        }

        // Retrieve prize assignments for the player's rank group
        $prizeAssignments = PrizeAssignment::where('rank_group_id', $rankGroup->id)->get();

        // Generate a random number between 0 and 1
        $randomNumber = mt_rand() / mt_getrandmax();

        // Check each prize assignment's odds of winning
        foreach ($prizeAssignments as $prizeAssignment) {
            // Check if the random number falls within the odds of winning for this prize assignment
            if ($randomNumber <= $prizeAssignment->odds_of_winning) {
                // Player wins the prize
                // Log the prize winning
                PrizeWinning::create([
                    'player_id' => $player->id,
                    'prize' => $prizeAssignment->prize,
                    'won_at' => now(),
                ]);

                // Update player's last spin time
                $player->update(['last_spin_time' => $currentTime]);

                // Check if the prize won is of lottery type
                if ($prizeAssignment->prize->type === 'lottery') {
                    // Fetch a lottery prize from the prizes table
                    $lotteryPrize = Prize::where('type', 'lottery')->inRandomOrder()->first();

                    // Give the lottery prize to the player
                    // Implement your logic here for giving the prize to the player

                    // Return response indicating the player won a lottery prize
                    return response()->json(['message' => 'Congratulations! You won a lottery prize.', 'prize' => $lotteryPrize], 200);
                }

                // Return response indicating the player won the prize
                return response()->json(['message' => 'Congratulations! You won a prize.', 'prize' => $prizeAssignment->prize], 200);
            }
        }

        // If the loop completes without finding a matching prize assignment, the player does not win a prize
        // Update player's last spin time
        $player->update(['last_spin_time' => $currentTime]);

        return response()->json(['message' => 'Sorry, you did not win a prize this time.'], 200);
    }
}
