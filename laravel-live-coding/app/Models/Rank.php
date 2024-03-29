<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory;
    protected $table = 'ranks';
    protected $fillable = ['name', 'created_at', 'updated_at'];

    public function rankGroups()
    {
        return $this->belongsToMany(RankGroup::class, 'rank_group_members', 'rank_id', 'rank_group_id');
    }

}
