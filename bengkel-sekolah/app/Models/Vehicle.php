<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $primaryKey = 'vehicle_id';
    protected $fillable = ['vehicle_code', 'customer_id', 'brand_id', 'plate_number', 'model'];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function brand() {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function bookings() {
        return $this->hasMany(Booking::class, 'vehicle_id');
    }
}