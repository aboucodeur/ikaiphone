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
        Schema::create('vpaiements', function (Blueprint $table) {
            $table->id('vp_id');
            $table->string('vp_motif', 200);
            $table->dateTime('vp_date');
            $table->integer('vp_montant');
            $table->smallInteger('vp_etat')->default(0);
            $table->unsignedBigInteger('v_id');
            $table->unsignedBigInteger('i_id');
            // cle etrangere de la table
            $table->foreign('v_id')->references('v_id')->on('vendres');
            $table->foreign('i_id')->references('i_id')->on('iphones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vpaiements');
    }
};
