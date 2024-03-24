<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use Laravel\Sanctum\HasApiTokens;

class Player extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'gender',
        'lang',
        'email',
        'rank_id',
        'password',
        'balance',
        'is_blocked',
        'last_spin_time'
    ];

    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }
}
