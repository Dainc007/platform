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
        Schema::create('pricings', function (Blueprint $table) {
            $table->id();
            $table->integer('distance_limit')->default(0); //if set to 0 that means
            $table->integer('price_without_tax')->default(0);
            $table->integer('price_with_tax')->default(0);
            $table->integer('tax_rate')->default(0);
            $table->integer('tax')->default(0);
            $table->unsignedInteger('currency_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricings');
    }
};
