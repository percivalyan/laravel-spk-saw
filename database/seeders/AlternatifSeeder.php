<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alternatif;

class AlternatifSeeder extends Seeder
{
    public function run(): void
    {
        $alternatifs = [
            [
                'kode' => 'A1',
                'nama' => 'Alternatif 1',
            ],
            [
                'kode' => 'A2',
                'nama' => 'Alternatif 2',
            ],
            [
                'kode' => 'A3',
                'nama' => 'Alternatif 3',
            ],
        ];

        foreach ($alternatifs as $alternatif) {
            Alternatif::create($alternatif);
        }
    }
}
