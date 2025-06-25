<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\NilaiAlternatif;

class JournalSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Insert Kriteria
        $kriteriaData = [
            ['kode' => 'C1', 'nama' => 'ScreenResolution', 'bobot' => 1, 'jenis' => 'benefit'],
            ['kode' => 'C2', 'nama' => 'Cpu', 'bobot' => 1, 'jenis' => 'benefit'],
            ['kode' => 'C3', 'nama' => 'Ram', 'bobot' => 1, 'jenis' => 'benefit'],
            ['kode' => 'C4', 'nama' => 'Memory', 'bobot' => 2, 'jenis' => 'benefit'],
            ['kode' => 'C5', 'nama' => 'Gpu', 'bobot' => 2, 'jenis' => 'benefit'],
            ['kode' => 'C6', 'nama' => 'Weight', 'bobot' => 1, 'jenis' => 'cost'],
            ['kode' => 'C7', 'nama' => 'Price_euros', 'bobot' => 2, 'jenis' => 'cost'],
        ];

        foreach ($kriteriaData as $kriteria) {
            Kriteria::create($kriteria);
        }

        $kriterias = Kriteria::all();

        // 2. Insert Alternatif + nilai
        $alternatifData = [
            'A1' => [
                'nama' => 'Razer Blade Pro Gaming (32 GB RAM 1 TB SSD)',
                'nilai' => [4, 4, 3, 3, 4, 4, 1],
            ],
            'A2' => [
                'nama' => 'Asus ROG G703VI-E5062T',
                'nilai' => [1, 4, 3, 2, 4, 1, 3],
            ],
            'A3' => [
                'nama' => 'Dell Alienware 17 (4K Ultra HD 3840x2160)',
                'nilai' => [3, 3, 3, 4, 3, 2, 4],
            ],
            'A4' => [
                'nama' => 'Dell Alienware 17 (IPS Panel Full HD 1920x1080)',
                'nilai' => [2, 3, 3, 4, 2, 2, 4],
            ],
            'A5' => [
                'nama' => 'Razer Blade Pro (32 RAM 512 GB SSD)',
                'nilai' => [4, 4, 3, 1, 4, 4, 2],
            ],
            'A6' => [
                'nama' => 'Asus ROG G701VO',
                'nilai' => [3, 2, 4, 3, 1, 3, 3],
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
