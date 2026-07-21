<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'customer_id';
    protected $fillable = ['customer_code', 'full_name', 'phone', 'customer_type'];

    public function vehicles() {
        return $this->hasMany(Vehicle::class, 'customer_id');
    }
}