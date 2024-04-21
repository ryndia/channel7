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
        Schema::create('user_admin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uID');
            $table->string('level');
            $table->string('profil_pic');
            $table->string('description');
            $table->unsignedBigInteger('who_created');
            $table->foreign('who_created')->references('id')->on('user_admin');
            $table->foreign('uID')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_admin');
    }
};
