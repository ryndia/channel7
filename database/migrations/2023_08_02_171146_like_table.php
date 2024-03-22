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
        Schema::create('like', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uID');
            $table->unsignedBigInteger('aID');
            $table->foreign('uID')->references('id')->on('users');
            $table->foreign('aID')->references('id')->on('article');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('like');
    }
};
