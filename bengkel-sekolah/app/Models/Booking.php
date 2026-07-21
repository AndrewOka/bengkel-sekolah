<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $primaryKey = 'booking_id';
    protected $fillable = ['vehicle_id', 'user_id', 'booking_date', 'status', 'notes'];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}