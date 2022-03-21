<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $visiteurs = json_decode(file_get_contents('database/factories/json/visiteurs.json'), true);

        foreach ($visiteurs['rows'] as $visiteur) {
            User::create([
                'last_name' => $visiteur['nom'],
                'first_name' => $visiteur['prenom'],
                'login' => $visiteur['login'],
                'password' => Hash::make($visiteur['mdp']),
                'address' => $visiteur['adresse'],
                'zip_code' => $visiteur['cp'],
                'city' => $visiteur['ville'],
                'hired_at' => $visiteur['dateEmbauche']
            ]);
        }

        \App\Models\User::factory(20)->create();

        $stateLalbels = [
            'Saisie clôturée',
            'Fiche créée, saisie en cours',
            'Remboursée',
            'Validée et mise en paiement'
        ];

        for ($i = 0; $i < 4; $i++) {
            \App\Models\State::create([
                'label' => $stateLalbels[$i]
            ]);
        }

        $typeLabels = [
            ['Forfait Etape', 11000],
            ['Frais Kilométrique', 62],
            ['Nuitée Hôtel', 8000],
            ['Repas Restaurant', 2500]
        ];

        for ($i = 0; $i < 4; $i++) {
            \App\Models\Type::create([
                'label' => $typeLabels[$i][0],
                'amount' => $typeLabels[$i][1],
            ]);
        }
    }
}
