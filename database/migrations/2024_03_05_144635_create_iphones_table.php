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
        Schema::create('iphones', function (Blueprint $table) {
            $table->id('i_id');
            $table->string('i_nom', 100);
            $table->string('i_serie', 200);
            $table->string('i_barcode', 100);
            $table->decimal('i_poids', 15, 2);
            $table->decimal('i_hauteur', 15, 2);
            $table->decimal('i_largeur', 15, 2);
            $table->decimal('i_epaisseur', 15, 2);
            $table->decimal('i_ecran', 15, 2);
            $table->unsignedBigInteger('m_id');

            // Clé étrangère
            $table->foreign('m_id')->references('m_id')->on('modeles');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iphones');
    }
};
