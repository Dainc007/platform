<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meeting_dates', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->boolean('is_enabled')->default(true);
            //mysql not allowes to have default value for json
            $table->json('disabled_hours');
            $table->json('disabled_hours')->default(new Expression('(JSON_ARRAY())'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_dates');
    }
};
