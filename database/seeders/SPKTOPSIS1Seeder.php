<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\NilaiAlternatif;

class SPKTOPSIS1Seeder extends Seeder
{
    public function run(): void
    {
        // Data Kriteria: kode, nama, bobot, jenis (benefit)
        $kriteriaData = [
            ['kode' => 'C1', 'nama' => 'Kelengkapan Administrasi (KTP, KK)', 'bobot' => 0.457, 'jenis' => 'benefit'],
            ['kode' => 'C2', 'nama' => 'Status Pernikahan (Buku Nikah dan Pas Photo Suami Istri)', 'bobot' => 0.257, 'jenis' => 'benefit'],
            ['kode' => 'C3', 'nama' => 'Buku Tabungan (Ada/Tidak Ada)', 'bobot' => 0.157, 'jenis' => 'benefit'],
            ['kode' => 'C4', 'nama' => 'Jaminan (Akta Tanah, Sertifikat Rumah, BPKB)', 'bobot' => 0.090, 'jenis' => 'benefit'],
            ['kode' => 'C5', 'nama' => 'Pendapatan Usaha', 'bobot' => 0.040, 'jenis' => 'benefit'],
        ];

        foreach ($kriteriaData as $kriteria) {
            Kriteria::create($kriteria);
        }

        $kriterias = Kriteria::all();

        // Data Alternatif dan Nilai Rating
        $alternatifData = [
            'A1' => [
                'nama' => 'Rizkah Fadillah',
                'nilai' => [5, 1, 4, 2, 3250000],
            ],
            'A2' => [
                'nama' => 'Saskia Pinim',
                'nilai' => [3, 5, 4, 2, 5000000],
            ],
            'A3' => [
                'nama' => 'M. Akbar Maulana',
                'nilai' => [3, 3, 2, 5, 11000000],
            ],
            'A4' => [
                'nama' => 'Khairil Anfi',
                'nilai' => [5, 3, 4, 5, 8750000],
            ],
            'A5' => [
                'nama' => 'Suriadi Alfalah',
                'nilai' => [5, 5, 4, 3, 7500000],
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
