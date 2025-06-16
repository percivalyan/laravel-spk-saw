<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $kriterias = [
            [
                'kode'  => 'C1',
                'nama'  => 'Kriteria 1',
                'bobot' => 0.1,
                'jenis' => 'cost',
            ],
            [
                'kode'  => 'C2',
                'nama'  => 'Kriteria 2',
                'bobot' => 0.2,
                'jenis' => 'cost',
            ],
            [
                'kode'  => 'C3',
                'nama'  => 'Kriteria 3',
                'bobot' => 0.3,
                'jenis' => 'benefit',
            ],
            [
                'kode'  => 'C4',
                'nama'  => 'Kriteria 4',
                'bobot' => 0.4,
                'jenis' => 'benefit',
            ],
        ];

        foreach ($kriterias as $kriteria) {
            Kriteria::create($kriteria);
        }
    }
}
