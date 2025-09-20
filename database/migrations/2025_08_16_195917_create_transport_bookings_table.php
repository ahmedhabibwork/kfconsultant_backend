<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transport_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('destination'); // المكان المطلوب
            $table->date('trip_date'); // تاريخ الرحلة
            $table->time('trip_time'); // وقت النقل
            $table->integer('people_count')->default(1);
            $table->enum('car_type', ['mini_bus', 'big_bus', 'private_car'])->nullable();
            $table->text('special_requests')->nullable(); // طلبات خاصة
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_bookings');
    }
};
