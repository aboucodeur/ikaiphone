<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Premiers Entreprises
        $entreprise = \App\Models\Entreprise::create([
            'en_nom' => 'Softia Mali',
            'en_tel' => '+223 94 86 58 79',
            'en_adr' => 'Bamako, Mali',
            'en_email' => 'softiamali@iphone.com',
            'en_logo' => null, // le lien du fichier stocker sur le serveur lors de la creation de l'entreprise
            'en_desc' => 'Entreprise de ventes d\'iphones a Halles de Bamako'
        ]);

        $en_id = $entreprise['en_id'];

        // Premiers Utilisateurs
        \App\Models\User::create(
            [
                'u_prenom' => 'ROOT',
                'u_nom' => 'ROOT',
                'u_username' => 'abou',
                'u_type' => 'admin',
                'email' => 'codeurabou123@gmail.com',
                'password' => Hash::make('12345678'),
                'en_id' => $en_id
            ]
        );

        \App\Models\Client::create([
            'c_nom' => 'VENTE RAPIDE',
            'c_type' => 'SIMPLE',
            'en_id' => $en_id
        ]);

        \App\Models\Fournisseur::create([
            'f_nom' => 'STOCKS',
            'en_id' => $en_id
        ]);

        function getItem($arr = [])
        {
            return $arr[array_rand($arr)];
        };
    }
}
