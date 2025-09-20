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
        Schema::table('trips', function (Blueprint $table) {
            $table->text('meta_title')->after( 'is_best_offer')->nullable();
            $table->text('meta_keywords')->after( 'meta_title')->nullable();
            $table->text('meta_description')->after( 'meta_keywords')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn( 'meta_title');
            $table->dropColumn('meta_keywords');
            $table->dropColumn( 'meta_description');
        });
    }
};
