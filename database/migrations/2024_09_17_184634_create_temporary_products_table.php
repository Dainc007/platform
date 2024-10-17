<?php

use App\Models\Product;
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
            $table->string('type')->default(Product::AVAILABLE_TYPES[0]);
            $table->integer('price');
            $table->integer('quantity')->nullable();
            $table->foreignId('currency_id')->constrained();

            $table->foreignId('contractor_id')->constrained()->onDelete('cascade');
            $table->foreignId('file_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('cascade');

            $table->timestamps();

            $table->unique(['contractor_id', 'code', 'brand_id', 'type']);
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
