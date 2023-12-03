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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable();
            $table->foreignId('vehicule_id');
            $table->foreignId('lavage_id');
            $table->foreignId('type_lavage_id');
            $table->foreignId('user_id');
            $table->string('status')->default('encours');
            $table->integer('employe_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
