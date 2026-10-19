<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardTicket extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'earned_at_uses', 'used_at'];
}
