<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrizeWinning extends Model
{
    use HasFactory;
    protected $fillable = ['player_id', 'prize', 'won_at'];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
