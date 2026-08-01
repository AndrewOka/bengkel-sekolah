<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Import SoftDeletes

class Customer extends Model
{
    use HasFactory, SoftDeletes; // 2. Tambahkan SoftDeletes di sini

    protected $table = 'customers';
    protected $primaryKey = 'customer_id'; // Sesuaikan jika primaryKey kamu menggunakan customer_id atau id

    protected $fillable = [
        'customer_code',
        'full_name',
        'phone',
        'type',
    ];
}