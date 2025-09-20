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
        Schema::create('flight_bookings', function (Blueprint $table) {
            $table->id();

            // بيانات المسافر
            $table->string('name');
            $table->string('email');
            $table->string('phone');

            // نوع التذكرة (ذهاب فقط / ذهاب وعودة)
            $table->enum('ticket_type', ['one_way', 'round_trip']);

            // الوجهات
            $table->string('origin');   // من
            $table->string('destination'); // إلى

            // درجة الحجز (اقتصادية، رجال أعمال، أولى)
            $table->enum('class_type', ['economy', 'business', 'first'])->default('economy');

            // عدد الركاب
            $table->unsignedInteger('adults')->default(1); // بالغ
            $table->unsignedInteger('children')->default(0); // طفل (11-2 عام)
            $table->unsignedInteger('infants')->default(0);  // رضيع (<2 عام)

            // التواريخ
            $table->date('departure_date'); // تاريخ السفر
            $table->date('return_date')->nullable(); // تاريخ العودة (فقط لو ذهاب وعودة)
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_bookings');
    }
};
