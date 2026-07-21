<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    // Deklarasikan primary key
    protected $primaryKey = 'brand_id';

    // Kolom yang boleh diisi
    protected $fillable = [
        'brand_name',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'brand_id', 'brand_id');
    }
}