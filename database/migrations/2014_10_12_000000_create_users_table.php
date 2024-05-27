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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('u_prenom', 60);
            $table->string('u_nom', 30);
            $table->string('u_type', 6);
            $table->string('u_username', 80);

            // Provient de quel entreprise
            $table->unsignedBigInteger('en_id');
            $table->foreign('en_id')->references('en_id')->on('entreprises')->cascadeOnUpdate();

            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
