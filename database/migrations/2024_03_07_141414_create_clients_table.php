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
        Schema::create('clients', function (Blueprint $table) {
            $table->id('c_id');
            $table->string('c_nom', 100);
            $table->string('c_tel', 25)->nullable();
            $table->string('c_adr', 200)->nullable();
            $table->string('c_type', 10);

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
        Schema::dropIfExists('clients');
    }
};
