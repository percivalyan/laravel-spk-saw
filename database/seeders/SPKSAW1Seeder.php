<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\NilaiAlternatif;

class SPKSAW1Seeder extends Seeder
{
    public function run(): void
    {
        // Data Kriteria: kode, nama, bobot, jenis (cost/benefit)
        $kriteriaData = [
            ['kode' => 'K1', 'nama' => 'Inisiatif', 'bobot' => 5, 'jenis' => 'cost'],
            ['kode' => 'K2', 'nama' => 'Kepatuhan', 'bobot' => 5, 'jenis' => 'cost'],
            ['kode' => 'K3', 'nama' => 'Pengetahuan dan Keterampilan', 'bobot' => 5, 'jenis' => 'cost'],
            ['kode' => 'K4', 'nama' => 'Komunikasi dan Kerjasama', 'bobot' => 15, 'jenis' => 'benefit'],
            ['kode' => 'K5', 'nama' => 'Kepemimpinan', 'bobot' => 5, 'jenis' => 'cost'],
            ['kode' => 'K6', 'nama' => 'Tanggung Jawab', 'bobot' => 10, 'jenis' => 'cost'],
            ['kode' => 'K7', 'nama' => 'Hasil Pekerjaan', 'bobot' => 15, 'jenis' => 'benefit'],
            ['kode' => 'K8', 'nama' => 'Disiplin Kerja', 'bobot' => 5, 'jenis' => 'cost'],
            ['kode' => 'K9', 'nama' => 'Pemecahan Masalah', 'bobot' => 15, 'jenis' => 'benefit'],
            ['kode' => 'K10', 'nama' => 'Loyalitas', 'bobot' => 5, 'jenis' => 'cost'],
            ['kode' => 'K11', 'nama' => 'Absensi', 'bobot' => 15, 'jenis' => 'benefit'],
        ];

        foreach ($kriteriaData as $kriteria) {
            Kriteria::create($kriteria);
        }

        $kriterias = Kriteria::all();

        // Data Alternatif dan Nilai
        $alternatifData = [
            'A1' => [2, 1, 2, 2, 4, 5, 2, 3, 4, 1, 1],
            'A2' => [3, 5, 4, 1, 2, 3, 4, 5, 2, 1, 1],
            'A3' => [1, 3, 1, 2, 3, 4, 5, 2, 1, 2, 2],
        ];

        foreach ($alternatifData as $kode => $nilaiList) {
            $alternatif = Alternatif::create([
                'kode' => $kode,
                'nama' => "Alternatif $kode",
            ]);

            foreach ($nilaiList as $index => $nilai) {
                NilaiAlternatif::create([
                    'alternatif_id' => $alternatif->id,
                    'kriteria_id' => $kriterias[$index]->id,
                    'nilai' => $nilai,
                ]);
            }
        }
    }
}
