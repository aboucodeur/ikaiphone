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
        Schema::create('vendres', function (Blueprint $table) {
            $table->id('v_id');
            $table->dateTime('v_date');
            $table->char('v_type', 3); // type de vente : classique ou re-vendeur
            $table->integer('v_etat');
            $table->timestamps();
            $table->unsignedBigInteger('c_id');
            // cle etrangere
            $table->foreign('c_id')->references('c_id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendres');
    }
};
