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
        Schema::create('modeles', function (Blueprint $table) {
            $table->id('m_id');
            $table->string('m_nom', 60);
            $table->string('m_couleur', 100);
            $table->string('m_type', 25);
            $table->smallInteger('m_memoire', false);
            $table->decimal('m_qte', 15, 2);
            $table->decimal('m_prix', 15, 2);
            $table->smallInteger('m_annee', false);
            $table->string('m_numero',60);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modeles');
    }
};
