<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'reservation_id',
        'admin_id',
        'amount',
        'payment_method',
        'payment_date',
        'status',
    ];
    public function admin()
{
    return $this->belongsTo(User::class, 'admin_id');
}

public function reservation()
{
    return $this->belongsTo(Reservation::class);
}

public function details()
{
    return $this->hasMany(DetailPayment::class);
}

}