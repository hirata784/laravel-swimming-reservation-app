<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardRedemption extends Model
{
    use HasFactory;

    protected $fillable = ['reward_ticket_id', 'reward_item_id'];

    public function reward_ticket()
    {
        return $this->belongsTo(RewardTicket::class);
    }

    public function reward_item()
    {
        return $this->belongsTo(RewardItem::class);
    }
}
