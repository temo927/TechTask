<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankGroup extends Model
{
    use HasFactory;

    protected $table = 'rank_groups';

    protected $fillable = ['name'];
    public function ranks()
    {
        return $this->belongsToMany(Rank::class, 'rank_group_members', 'rank_group_id', 'rank_id');
    }
}
