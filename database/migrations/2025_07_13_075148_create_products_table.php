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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_image')->nullable();
            $table->json('images')->nullable();
            $table->string('breadcrumb')->nullable();
            $table->float('price', 8, 2)->default(0.00);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->enum('type', ['fixed', 'percentage'])->nullable();
            $table->decimal('value', 8, 2)->default(0); 
            $table->tinyInteger('order')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};