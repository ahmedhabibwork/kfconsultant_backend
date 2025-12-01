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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->longText('description')->nullable();
            $table->longText('mission')->nullable();
            $table->longText('vision')->nullable();
            $table->longText('our_founder')->nullable();
            $table->text('short_description')->nullable();
            $table->integer('experience_years')->nullable();
            $table->integer('experts')->nullable();
            $table->integer('clients')->nullable();
            $table->integer('projects')->nullable();
            // $table->string('phone')->nullable();
            $table->string('mission_image')->nullable();
            $table->string('vision_image')->nullable();
            $table->string('our_founder_image')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
