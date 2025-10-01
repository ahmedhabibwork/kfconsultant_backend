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
        Schema::table('seos', function (Blueprint $table) {
            $table->text('og_description')->nullable()->after('description');
            $table->string('og_image')->nullable()->after('og_description');
            $table->text('twitter_description')->nullable()->after('og_image');
            $table->string('twitter_image')->nullable()->after('twitter_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seos', function (Blueprint $table) {
            $table->dropColumn([
                'og_description',
                'og_image',
                'twitter_description',
                'twitter_image',
            ]);
        });
    }
};
