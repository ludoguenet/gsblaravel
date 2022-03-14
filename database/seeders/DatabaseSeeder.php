<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(50)->create();

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
