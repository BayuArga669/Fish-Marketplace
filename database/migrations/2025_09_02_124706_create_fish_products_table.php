<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fish_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->string('unit'); // kg, ekor, etc
            $table->enum('fish_type', ['air_tawar', 'air_laut', 'air_payau']);
            $table->json('images')->nullable();
            $table->enum('status', ['available', 'out_of_stock', 'inactive'])->default('available');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fish_products');
    }
};
