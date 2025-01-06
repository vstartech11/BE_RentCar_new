<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehicle extends Model
{
    use HasFactory;

    public function type()
{
    return $this->belongsTo(TypeVehicle::class);
}

public function reservation()
{
    return $this->hasMany(Reservation::class);
}

}