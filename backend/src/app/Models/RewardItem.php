<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'is_active'])]
class RewardItem extends Model
{
    use HasFactory;

    public function reward_redemptions()
    {
        return $this->hasMany(RewardRedemption::class);
    }
}
