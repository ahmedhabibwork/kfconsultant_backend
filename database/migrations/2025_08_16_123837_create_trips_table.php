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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->text('description')->nullable();
            $table->text('overview')->nullable();
            $table->text('highlights')->nullable();
            $table->text('itinerary')->nullable();


            $table->text('accommodation')->nullable();
            $table->text('inclusions')->nullable();
            $table->string('duration');

            $table->decimal('price', 10, 2);
            $table->string('currency')->default('EGP');
            $table->string('images')->nullable();
            $table->string('map_link')->nullable();
            $table->boolean('is_best_seller')->default(false)->nullable();
            $table->boolean('is_popular')->default(false)->nullable();
            $table->boolean('is_best_offer')->default(false)->nullable();
            $table->integer('rating')->default(0)->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
