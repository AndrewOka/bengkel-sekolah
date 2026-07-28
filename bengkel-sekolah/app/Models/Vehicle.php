<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Import SoftDeletes

class Vehicle extends Model
{
    use HasFactory, SoftDeletes; // 2. Pasang SoftDeletes di sini

    protected $table = 'vehicles';
    protected $primaryKey = 'vehicle_id'; // Sesuaikan jika primaryKey kamu vehicle_id atau id

    protected $fillable = [
        'vehicle_code',
        'plate_number',
        'customer_id',
        'brand_id',
        'model_name',
    ];

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relasi ke Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}