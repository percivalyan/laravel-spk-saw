<?php

namespace App\Http\Controllers;

use App\Models\NilaiAlternatif;
use App\Models\Alternatif;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class NilaiAlternatifController extends Controller
{
    public function index()
    {
        $alternatifs = Alternatif::with('nilaiAlternatif.kriteria')->get();
        $kriterias = Kriteria::all();
        return view('panel.nilai-alternatif.index', compact('alternatifs', 'kriterias'));
    }

    public function create()
    {
        $alternatifs = Alternatif::all();
        $kriterias = Kriteria::all();
        return view('panel.nilai-alternatif.create', compact('alternatifs', 'kriterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alternatif_id' => 'required|exists:alternatifs,id',
            'nilai.*' => 'required|numeric|min:0',
        ]);

        foreach ($request->nilai as $kriteria_id => $nilai) {
            NilaiAlternatif::updateOrCreate(
                [
                    'alternatif_id' => $request->alternatif_id,
                    'kriteria_id' => $kriteria_id,
                ],
                ['nilai' => $nilai]
            );
        }

        return redirect()->route('nilai-alternatif.index')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $alternatif = Alternatif::with('nilaiAlternatif.kriteria')->findOrFail($id);
        return view('panel.nilai-alternatif.show', compact('alternatif'));
    }

    public function edit($id)
    {
        $alternatif = Alternatif::findOrFail($id);
        $kriterias = Kriteria::all();
        $nilaiAlternatif = NilaiAlternatif::where('alternatif_id', $id)->get()->keyBy('kriteria_id');
        return view('panel.nilai-alternatif.edit', compact('alternatif', 'kriterias', 'nilaiAlternatif'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai.*' => 'required|numeric|min:0',
        ]);

        foreach ($request->nilai as $kriteria_id => $nilai) {
            NilaiAlternatif::updateOrCreate(
                [
                    'alternatif_id' => $id,
                    'kriteria_id' => $kriteria_id,
                ],
                ['nilai' => $nilai]
            );
        }

        return redirect()->route('nilai-alternatif.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function hitungSAW()
    {
        $alternatifs = Alternatif::with('nilaiAlternatif.kriteria')->get();
        $kriterias = Kriteria::all();

        $normalisasi = [];
        $maxValues = [];
        $minValues = [];

        foreach ($kriterias as $kriteria) {
            $nilaiPerKriteria = NilaiAlternatif::where('kriteria_id', $kriteria->id)->pluck('nilai');
            $maxValues[$kriteria->id] = $nilaiPerKriteria->max();
            $minValues[$kriteria->id] = $nilaiPerKriteria->min();
        }

        foreach ($alternatifs as $alt) {
            $normalisasi[$alt->id] = [];
            foreach ($alt->nilaiAlternatif as $na) {
                $kriteria = $na->kriteria;
                if ($kriteria->jenis == 'benefit') {
                    $normal = $na->nilai / $maxValues[$kriteria->id];
                } else {
                    $normal = $minValues[$kriteria->id] / $na->nilai;
                }
                $normalisasi[$alt->id][$kriteria->id] = $normal;
            }
        }

        $hasilSAW = [];
        foreach ($normalisasi as $alt_id => $nilaiKriteria) {
            $total = 0;
            foreach ($nilaiKriteria as $kriteria_id => $nilai) {
                $bobot = $kriterias->firstWhere('id', $kriteria_id)->bobot;
                $total += $nilai * $bobot;
            }
            $hasilSAW[$alt_id] = $total;
        }

        arsort($hasilSAW);

        return view('panel.nilai-alternatif.hasil_saw', [
            'hasilSAW' => $hasilSAW,
            'alternatifs' => $alternatifs->keyBy('id'),
            'normalisasi' => $normalisasi,
            'kriterias' => $kriterias,
        ]);
    }

    public function hitungWP()
    {
        $alternatifs = Alternatif::with('nilaiAlternatif.kriteria')->get();
        $kriterias = Kriteria::all();

        // Hitung total bobot
        $totalBobot = $kriterias->sum('bobot');

        // Hitung bobot perbaikan (w)
        $bobotPerbaikan = [];
        foreach ($kriterias as $kriteria) {
            $bobotPerbaikan[$kriteria->id] = $kriteria->bobot / $totalBobot;
        }

        // Hitung nilai vektor S dan simpan detail perhitungan
        $nilaiS = [];
        $perhitunganS = [];

        foreach ($alternatifs as $alt) {
            $produk = 1;
            $uraian = [];

            foreach ($alt->nilaiAlternatif as $na) {
                $nilai = $na->nilai;
                $kriteria = $na->kriteria;
                $w = $bobotPerbaikan[$kriteria->id];
                $pangkat = $kriteria->jenis == 'benefit' ? $w : -$w;

                $hasilPangkat = pow($nilai, $pangkat);
                $produk *= $hasilPangkat;

                $uraian[] = [
                    'kriteria' => $kriteria,
                    'nilai' => $nilai,
                    'w' => $w,
                    'jenis' => $kriteria->jenis,
                    'pangkat' => $pangkat,
                    'hasil' => $hasilPangkat,
                ];
            }

            $nilaiS[$alt->id] = $produk;
            $perhitunganS[$alt->id] = $uraian;
        }

        // Hitung total S (ΣS)
        $totalS = array_sum($nilaiS);

        // Hitung nilai V
        $nilaiV = [];
        foreach ($nilaiS as $id => $s) {
            $nilaiV[$id] = $s / $totalS;
        }

        // Urutkan berdasarkan nilai V tertinggi
        arsort($nilaiV);

        return view('panel.nilai-alternatif.hasil_wp', [
            'alternatifs' => $alternatifs->keyBy('id'),
            'kriterias' => $kriterias,
            'bobotPerbaikan' => $bobotPerbaikan,
            'nilaiS' => $nilaiS,
            'nilaiV' => $nilaiV,
            'totalS' => $totalS,
            'perhitunganS' => $perhitunganS,
        ]);
    }

    public function hitungTOPSIS()
    {
        $alternatifs = Alternatif::with('nilaiAlternatif.kriteria')->get();
        $kriterias = Kriteria::all();

        // 1. Buat matriks R (normalisasi)
        $matriksR = [];
        $pembagi = [];

        foreach ($kriterias as $kriteria) {
            $nilaiKriteria = NilaiAlternatif::where('kriteria_id', $kriteria->id)->pluck('nilai');
            $pembagi[$kriteria->id] = sqrt($nilaiKriteria->sum(function ($n) {
                return pow($n, 2);
            }));
        }

        foreach ($alternatifs as $alt) {
            $matriksR[$alt->id] = [];
            foreach ($alt->nilaiAlternatif as $na) {
                $kriteriaId = $na->kriteria_id;
                $nilai = $na->nilai / $pembagi[$kriteriaId];
                $matriksR[$alt->id][$kriteriaId] = $nilai;
            }
        }

        // 2. Matriks terbobot Yij = rij * wj
        $matriksY = [];
        foreach ($matriksR as $altId => $nilaiKriterias) {
            $matriksY[$altId] = [];
            foreach ($nilaiKriterias as $kriteriaId => $r) {
                $bobot = $kriterias->firstWhere('id', $kriteriaId)->bobot;
                $matriksY[$altId][$kriteriaId] = $r * $bobot;
            }
        }

        // 3. Tentukan solusi ideal positif dan negatif
        $solusiPositif = [];
        $solusiNegatif = [];

        foreach ($kriterias as $kriteria) {
            $kolomNilai = array_column($matriksY, $kriteria->id);
            if ($kriteria->jenis == 'benefit') {
                $solusiPositif[$kriteria->id] = max($kolomNilai);
                $solusiNegatif[$kriteria->id] = min($kolomNilai);
            } else {
                $solusiPositif[$kriteria->id] = min($kolomNilai);
                $solusiNegatif[$kriteria->id] = max($kolomNilai);
            }
        }

        // 4. Hitung jarak ke solusi ideal
        $jarakPositif = [];
        $jarakNegatif = [];

        foreach ($matriksY as $altId => $nilaiKriterias) {
            $sumDPlus = 0;
            $sumDMin = 0;

            foreach ($nilaiKriterias as $kriteriaId => $y) {
                $sumDPlus += pow($y - $solusiPositif[$kriteriaId], 2);
                $sumDMin += pow($y - $solusiNegatif[$kriteriaId], 2);
            }

            $jarakPositif[$altId] = sqrt($sumDPlus);
            $jarakNegatif[$altId] = sqrt($sumDMin);
        }

        // 5. Hitung nilai preferensi V = D- / (D+ + D-)
        $nilaiPreferensi = [];
        foreach ($alternatifs as $alt) {
            $id = $alt->id;
            $dPlus = $jarakPositif[$id];
            $dMin = $jarakNegatif[$id];
            $nilaiPreferensi[$id] = $dMin / ($dPlus + $dMin);
        }

        // 6. Urutkan hasil preferensi
        arsort($nilaiPreferensi);

        return view('panel.nilai-alternatif.hasil_topsis', [
            'alternatifs' => $alternatifs->keyBy('id'),
            'kriterias' => $kriterias,
            'matriksR' => $matriksR,
            'matriksY' => $matriksY,
            'solusiPositif' => $solusiPositif,
            'solusiNegatif' => $solusiNegatif,
            'jarakPositif' => $jarakPositif,
            'jarakNegatif' => $jarakNegatif,
            'nilaiPreferensi' => $nilaiPreferensi,
        ]);
    }

    public function destroy($id)
    {
        NilaiAlternatif::where('alternatif_id', $id)->delete();
        return redirect()->route('nilai-alternatif.index')->with('success', 'Data berhasil dihapus.');
    }
}
