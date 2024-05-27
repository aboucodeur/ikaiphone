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
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->id('f_id');
            $table->string('f_nom', 100);
            $table->string('f_tel', 25)->nullable();
            $table->string('f_adr', 200)->nullable();

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
        Schema::dropIfExists('fournisseurs');
    }
};
