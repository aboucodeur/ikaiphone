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
            $table->string('m_type', 25);
            $table->decimal('m_qte', 15, 2); // qte en stock en decimal
            $table->decimal('m_prix', 15, 2); // prix modele en decimal
            $table->smallInteger('m_memoire', false);

            // Provient de quel entreprise
            $table->unsignedBigInteger('en_id');
            $table->foreign('en_id')->references('en_id')->on('entreprises')->cascadeOnUpdate();

            $table->timestamps();
            $table->softDeletes();
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
