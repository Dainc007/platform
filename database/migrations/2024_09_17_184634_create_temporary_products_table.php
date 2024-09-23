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


        Schema::create('temporary_products', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('price')->default(0);
            $table->integer('quantity')->nullable()->default(0);
            $table->foreignId('currency_id')->constrained();
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('cascade');

            $table->timestamps();

            $table->unique(['code', 'brand_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporary_products');
    }
};
