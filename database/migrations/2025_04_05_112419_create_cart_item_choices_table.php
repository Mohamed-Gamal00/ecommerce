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
        Schema::create('cart_item_choices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade');
            $table->foreignId('choice_id')->constrained('choices')->onDelete('cascade');

            $table->foreignId('sub_choice_id')->nullable()->constrained('choices')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_item_choices');
    }
};
