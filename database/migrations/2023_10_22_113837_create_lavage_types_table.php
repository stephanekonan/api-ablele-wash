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
        Schema::create('lavage_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lavage_id');
            $table->unsignedBigInteger('type_lavage_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
    
            $table->foreign('lavage_id')->references('id')->on('lavages')->onDelete('cascade');
            $table->foreign('type_lavage_id')->references('id')->on('type_lavages')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lavage_types');
    }
};
