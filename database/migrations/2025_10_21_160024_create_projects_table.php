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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('title');
            $table->text('introduction')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('scope_id')->nullable();
            $table->unsignedBigInteger('year_id')->nullable();
            $table->unsignedBigInteger('scale_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('images')->nullable();
            $table->string('map_link')->nullable();
            $table->string('owner')->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->text('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('scope_id')->references('id')->on('scopes');
            $table->foreign('year_id')->references('id')->on('years');
            $table->foreign('scale_id')->references('id')->on('scales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
