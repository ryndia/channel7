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
        Schema::create('category_article', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aID');
            $table->unsignedBigInteger('cID');
            $table->unsignedBigInteger('sID');
            $table->foreign('aID')->references('id')->on('article');
            $table->foreign('cID')->references('id')->on('category');
            $table->foreign('sID')->references('id')->on('subcategories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_article');
    }
};
