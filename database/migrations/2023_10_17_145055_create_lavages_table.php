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
        Schema::create('lavages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('lavage_name');
            $table->string('photo');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('commune_id');
            $table->string('status')->default('actif');

            $table->foreign('commune_id')->references('id')->on('communes');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lavages');
    }
};
