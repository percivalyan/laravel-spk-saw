<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\NilaiAlternatif;

class SPKWP1Seeder extends Seeder
{
    public function run(): void
    {
        // 1. Insert Kriteria
        $kriteriaData = [
            ['kode' => 'C1', 'nama' => 'Jumlah Hotel', 'bobot' => 4, 'jenis' => 'benefit'],
            ['kode' => 'C2', 'nama' => 'Kamar', 'bobot' => 5, 'jenis' => 'benefit'],
            ['kode' => 'C3', 'nama' => 'Tempat Tidur', 'bobot' => 3, 'jenis' => 'benefit'],
            ['kode' => 'C4', 'nama' => 'Pekerja per Hotel', 'bobot' => 2, 'jenis' => 'benefit'],
            ['kode' => 'C5', 'nama' => 'Pekerja per Kamar', 'bobot' => 2, 'jenis' => 'benefit'],
        ];

        foreach ($kriteriaData as $kriteria) {
            Kriteria::create($kriteria);
        }

        $kriterias = Kriteria::all();

        // 2. Insert Alternatif + nilai
        $alternatifData = [
            'A1' => [
                'nama' => 'DKI Jakarta',
                'nilai' => [326, 46899, 60849, 222.3, 0.6]
            ],
            'A2' => [
                'nama' => 'Jawa Barat',
                'nilai' => [463, 43034, 62725, 106.6, 0.6]
            ],
            'A3' => [
                'nama' => 'Jawa Tengah',
                'nilai' => [291, 23516, 3353, 53.9, 0.6]
            ],
            'A4' => [
                'nama' => 'DI Yogyakarta',
                'nilai' => [143, 14328, 23477, 81.8, 0.6]
            ],
            'A5' => [
                'nama' => 'Bali',
                'nilai' => [551, 52927, 78801, 122.6, 1]
            ],
        ];

        foreach ($alternatifData as $kode => $data) {
            $alternatif = Alternatif::create([
                'kode' => $kode,
                'nama' => $data['nama'],
            ]);

            foreach ($data['nilai'] as $index => $nilai) {
                NilaiAlternatif::create([
                    'alternatif_id' => $alternatif->id,
                    'kriteria_id' => $kriterias[$index]->id,
                    'nilai' => $nilai,
                ]);
            }
        }
    }
}
