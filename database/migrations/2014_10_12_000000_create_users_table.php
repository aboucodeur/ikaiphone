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
        // adapter la table aux besoins de l'application
        /**
         * Se connecter avec : username et password
         */
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('u_prenom', 60); // ok
            $table->string('u_nom', 30); // ok
            $table->string('u_type', 6); // en cours
            $table->string('u_username', 80); // en cours

            $table->string('email')->unique(); // laravel
            $table->string('password'); // laravel
            $table->timestamp('email_verified_at')->nullable(); // laravel
            $table->rememberToken(); // laravel
            $table->timestamps(); // laravel
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
