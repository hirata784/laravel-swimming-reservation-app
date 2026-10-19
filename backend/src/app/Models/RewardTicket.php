<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardTicket extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'earned_at_uses', 'used_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reward_redemption()
    {
        return $this->hasOne(RewardRedemption::class);
    }
}
