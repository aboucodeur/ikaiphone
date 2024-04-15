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
        Schema::create('retours', function (Blueprint $table) {
            $table->id('re_id');
            $table->date('re_date')->default('now()');
            $table->string('re_motif')->nullable(); // motif du retour
            $table->smallInteger('etat')->default(0); // pour securiser le retour
            $table->timestamps();
            // cle etrangere
            $table->unsignedBigInteger('i_id'); // la dite iphone retourner
            $table->unsignedBigInteger('i_ech_id'); // contre une nouvelle iphone
            $table->foreign('i_id')->references('i_id')->on('iphones')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('i_ech_id')->references('i_id')->on('iphones')->cascadeOnUpdate()->cascadeOnDelete();
            // suppression en douce
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retours');
    }
};
