<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrizeAssignment extends Model
{
    use HasFactory;

    protected $table = 'prize_assignments';

    protected $fillable = [
        'rank_group_id',
        'prize_amount_usd',
        'prize_number',
        'odds_of_winning',
    ];
}
