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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Utilisateurs
        \App\Models\User::create([
            'u_prenom' => 'mohamed',
            'u_nom' => 'Traore',
            'u_username' => 'mohamed',
            'u_type' => 'admin',
            'email' => 'codeurabou123@gmail.com',
            'password' => Hash::make('12345678'),

        ]);

        // Clients no seeder class
        // \App\Models\Client::factory(60)->create();

        // Fournisseurs no seeder class
        // \App\Models\Fournisseur::factory(60)->create();

        // Reductions no seeder class

        // TODO : Modeles et Iphones Custom seeder

        $modeles_iphones = [
            'iPhone 13', 'iPhone 13 Pro', 'iPhone 13 Pro Max', 'iPhone 13 Mini',
            'iPhone 12', 'iPhone 12 Pro', 'iPhone 12 Pro Max', 'iPhone 12 Mini',
            'iPhone 11', 'iPhone 11 Pro', 'iPhone 11 Pro Max',
            'iPhone SE (2020)',
            'iPhone XS', 'iPhone XS Max',
            'iPhone XR',
            'iPhone X',
            'iPhone 8', 'iPhone 8 Plus',
            'iPhone 7', 'iPhone 7 Plus',
            'iPhone SE (2016)',
            'iPhone 6S', 'iPhone 6S Plus', 'iPhone 6', 'iPhone 6 Plus',
            'iPhone 5S', 'iPhone 5C', 'iPhone 5',
            'iPhone 4S', 'iPhone 4',
        ];
        $types_iphones = ['Pro Max', 'Pro', 'Plus', 'Mini', 'SE', 'S', 'C', 'S Plus'];
        $memoires_iphones = ['32', '64', '128', '256', '500'];
        $series_iphones = [
            'C39FH8S3VCG6', 'B7FN4A9K2DHJ', 'X4H82PQ93V6R', 'Z6XJ9FD72QNH',
            'L5Y3X2P8D7JK', 'G2K9R3V6X5CL', 'W8R4FC5J3DVN', 'M3L6Z9G5X2RV',
            'Q9J4X8C6DN2F', 'R5G2X9C8FJ3D', 'P9R2X5C6J3DV', 'H7Z5K9P4F6QC',
            'D3H7J9N4Z6PC', 'A8F3C7V4J9K2', 'T6Y3X8C9V4J', 'E4R8V5J3DN6P',
            'V6X3C8J2DN4R', 'S9H4P7D3V5GC', 'K2N8V3C6J7DF', 'U5X8C3J2DN6V',
        ];
        $couleurs_iphones = ['Orange', 'Noir', 'Bleu', 'Violet'];

        /**
         * Cette methode retourne un element aleatoire du tableaux
         */
        function getItem($arr = [])
        {
            return $arr[array_rand($arr)];
        };

        // 50 modeles
        for ($i = 1; $i < 2; $i++) {
            // array_rand($arr) => donne un nombre aleatoire qui depasse pas la limite
            // generer des donnees aleatoires de modeles
            $modele = getItem($modeles_iphones);
            $type = getItem($types_iphones);
            $memoire = getItem($memoires_iphones);
            $couleur = getItem($couleurs_iphones);

            \App\Models\Modele::create([
                'm_nom' => $modele,
                'm_type' => $type,
                'm_memoire' => $memoire,
                'm_couleur' => $couleur,
                'm_qte' => 0,
                'm_prix' => 125000 // comme test
            ]);
        }

        // 25 iphones
        $tous_modeles =  \App\Models\Modele::pluck('m_id')->toArray();
        for ($i = 1; $i < 2; $i++) {
            $serie = getItem($series_iphones);
            $m_id = getItem($tous_modeles);
            \App\Models\Iphone::create([
                'i_barcode' => $serie,
                'm_id' => $m_id,
            ]);
        };
    }
}
