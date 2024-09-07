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
        Schema::create('article', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->string('content');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('audio')->nullable();
            $table->boolean('display');
            $table->boolean('approved');
            $table->boolean('carousel_display')->default(0);
            $table->dateTime('approved_time')->nullable();
            $table->unsignedBigInteger('writeby');
            $table->unsignedBigInteger('approvedby')->nullable();
            $table->foreign('writeby')->references('uID')->on('user_admin');
            $table->foreign('approvedby')->references('uID')->on('user_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article');
    }
};
