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
        Schema::create('vcommandes', function (Blueprint $table) {
            $table->id('vc_id');
            $table->unsignedBigInteger('i_id');
            $table->unsignedBigInteger('v_id');
            $table->integer('vc_etat');
            $table->decimal('vc_qte', 15, 2);
            $table->decimal('vc_prix', 15, 2);
            $table->string('vc_motif', 200);
            // Clés étrangères
            $table->foreign('i_id')->references('i_id')->on('iphones');
            $table->foreign('v_id')->references('v_id')->on('vendres');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vcommandes');
    }
};
