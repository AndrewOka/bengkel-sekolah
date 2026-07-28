<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->foreignId('vehicle_id')->constrained('vehicles', 'vehicle_id')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users', 'user_id')->onDelete('set null');
            $table->date('booking_date');
            $table->enum('status', ['Pending', 'Proses', 'Reschedule', 'Finish', 'Batal'])->default('Pending');
            $table->text('notes')->nullable();
            $table->softDeletes(); // <-- Menambahkan kolom deleted_at untuk Soft Delete
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('bookings');
    }
};