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
        Schema::create('acommandes', function (Blueprint $table) {
            $table->id('ac_id');
            $table->unsignedBigInteger('i_id');
            $table->unsignedBigInteger('a_id');
            $table->integer('ac_etat');
            $table->decimal('ac_qte', 15, 2);
            $table->decimal('ac_prix', 15, 2);
            // Clés étrangères
            $table->foreign('i_id')->references('i_id')->on('iphones');
            $table->foreign('a_id')->references('a_id')->on('achats');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acommandes');
    }
};
