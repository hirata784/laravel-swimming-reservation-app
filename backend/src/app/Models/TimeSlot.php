<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['date', 'start_time', 'capacity'])]
class TimeSlot extends Model
{
    use HasFactory;

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
