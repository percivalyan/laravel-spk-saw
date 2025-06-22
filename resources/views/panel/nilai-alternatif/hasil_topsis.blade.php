@extends('panel.layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Hasil Perhitungan Metode TOPSIS</h5>
                </div>
                <div class="card-body">

                    <h5 class="fw-bold mb-3">1. Bobot & Jenis Kriteria</h5>
                    <ul class="list-group mb-4">
                        @foreach ($kriterias as $kriteria)
                            <li class="list-group-item">
                                <strong>{{ $kriteria->kode }}</strong> ({{ ucfirst($kriteria->jenis) }}) —
                                Bobot: <strong>{{ $kriteria->bobot }}</strong>
                            </li>
                        @endforeach
                    </ul>

                    <h5 class="fw-bold">2. Matriks Normalisasi</h5>
                    <p><img src="https://latex.codecogs.com/png.image?\dpi{120}r_{ij}=\frac{x_{ij}}{\sqrt{\sum_{i=1}^{m}x_{ij}^2}}"
                            alt="Persamaan Normalisasi" /></p>

                    @foreach ($matriksR as $alt_id => $nilai)
                        <p><strong>{{ $alternatifs[$alt_id]->nama ?? 'A' . $alt_id }}:</strong></p>
                        <ul>
                            @foreach ($kriterias as $kriteria)
                                @php
                                    $x_ij = $matriksR[$alt_id][$kriteria->id] * ($pembagi[$kriteria->id] ?? 1);
                                    $sum_x2 = ($pembagi[$kriteria->id] ?? 1) ** 2;
                                    $sqrt_sum = sqrt($sum_x2);
                                    $rij = $sqrt_sum != 0 ? $x_ij / $sqrt_sum : 0;
                                @endphp
                                <li>
                                    \( r_{{ $alt_id + 1 }}{{ $kriteria->kode }} = \frac{ {{ $x_ij }} }{ \sqrt{
                                    {{ number_format($sum_x2, 4) }} } } = \frac{ {{ $x_ij }} }{
                                    {{ number_format($sqrt_sum, 4) }} } = {{ number_format($rij, 4) }} \)
                                </li>
                            @endforeach
                        </ul>
                    @endforeach

                    <h5 class="fw-bold">3. Matriks Terbobot</h5>
                    <p><img src="https://latex.codecogs.com/png.image?\dpi{120}Y_{ij}=r_{ij} \times w_{j}"
                            alt="Persamaan Matriks Terbobot" /></p>

                    @foreach ($matriksY as $alt_id => $nilai)
                        <p><strong>{{ $alternatifs[$alt_id]->nama ?? 'A' . $alt_id }}:</strong></p>
                        <ul>
                            @foreach ($kriterias as $kriteria)
                                @php
                                    $rij = $matriksR[$alt_id][$kriteria->id] ?? 0;
                                    $w = $kriteria->bobot;
                                    $yij = $rij * $w;
                                @endphp
                                <li>
                                    \( Y_{{ $alt_id + 1 }}{{ $kriteria->kode }} = {{ number_format($rij, 4) }} \times
                                    {{ $w }} = {{ number_format($yij, 4) }} \)
                                </li>
                            @endforeach
                        </ul>
                    @endforeach

                    <h5 class="fw-bold">4. Solusi Ideal Positif & Negatif</h5>
                    <p>
                        <img src="https://latex.codecogs.com/png.image?\dpi{120}A^+ = \left\{ \max(Y_{ij}) \text{ if benefit, } \min(Y_{ij}) \text{ if cost} \right\}"
                            alt="Solusi Ideal Positif" /><br>
                        <img src="https://latex.codecogs.com/png.image?\dpi{120}A^- = \left\{ \min(Y_{ij}) \text{ if benefit, } \max(Y_{ij}) \text{ if cost} \right\}"
                            alt="Solusi Ideal Negatif" />
                    </p>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Kriteria</th>
                                    <th>A<sup>+</sup> (Ideal Positif)</th>
                                    <th>A<sup>-</sup> (Ideal Negatif)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kriterias as $kriteria)
                                    <tr>
                                        <td>{{ $kriteria->kode }}</td>
                                        <td>{{ number_format($solusiPositif[$kriteria->id], 4) }}</td>
                                        <td>{{ number_format($solusiNegatif[$kriteria->id], 4) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h5 class="fw-bold">5. Jarak ke Solusi Ideal</h5>
                    <p>
                        <img src="https://latex.codecogs.com/png.image?\dpi{120}D_i^+ = \sqrt{\sum_{j=1}^{n}(Y_{ij}-Y_j^+)^2}"
                            alt="Jarak ke Ideal Positif" /><br>
                        <img src="https://latex.codecogs.com/png.image?\dpi{120}D_i^- = \sqrt{\sum_{j=1}^{n}(Y_{ij}-Y_j^-)^2}"
                            alt="Jarak ke Ideal Negatif" />
                    </p>

                    @foreach ($alternatifs as $alt)
                        @php
                            $dPlus = 0;
                            $dMinus = 0;
                        @endphp
                        <p><strong>{{ $alt->nama }}</strong></p>
                        <ul>
                            @foreach ($kriterias as $kriteria)
                                @php
                                    $yij = $matriksY[$alt->id][$kriteria->id] ?? 0;
                                    $aPlus = $solusiPositif[$kriteria->id];
                                    $aMinus = $solusiNegatif[$kriteria->id];
                                    $dPlus += pow($yij - $aPlus, 2);
                                    $dMinus += pow($yij - $aMinus, 2);
                                @endphp
                                <li>
                                    \( ({{ number_format($yij, 4) }} - {{ number_format($aPlus, 4) }})^2 =
                                    {{ number_format(pow($yij - $aPlus, 2), 4) }} \)
                                    &nbsp;&nbsp;
                                    \( ({{ number_format($yij, 4) }} - {{ number_format($aMinus, 4) }})^2 =
                                    {{ number_format(pow($yij - $aMinus, 2), 4) }} \)
                                </li>
                            @endforeach
                            <li>
                                \( D^+ = \sqrt{ {{ number_format($dPlus, 4) }} } = {{ number_format(sqrt($dPlus), 4) }} \)
                            </li>
                            <li>
                                \( D^- = \sqrt{ {{ number_format($dMinus, 4) }} } = {{ number_format(sqrt($dMinus), 4) }}
                                \)
                            </li>
                        </ul>
                    @endforeach

                    <h5 class="fw-bold">6. Nilai Preferensi</h5>
                    <p>
                        <img src="https://latex.codecogs.com/png.image?\dpi{120}V_i = \frac{D_i^-}{D_i^+ + D_i^-}"
                            alt="Nilai Preferensi" />
                    </p>

                    @foreach ($nilaiPreferensi as $alt_id => $nilai)
                        <p>
                            \( V_{{ $loop->iteration }} = \frac{ {{ number_format($jarakNegatif[$alt_id], 4) }} }{
                            {{ number_format($jarakPositif[$alt_id], 4) }} +
                            {{ number_format($jarakNegatif[$alt_id], 4) }} } = {{ number_format($nilai, 4) }} \)
                        </p>
                    @endforeach

                    <h5 class="fw-bold">7. Hasil Akhir (Ranking)</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Ranking</th>
                                    <th>Alternatif</th>
                                    <th>Nilai Preferensi (V<sub>i</sub>)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $rank = 1; @endphp
                                @foreach ($nilaiPreferensi as $alt_id => $nilai)
                                    <tr>
                                        <td>{{ $rank++ }}</td>
                                        <td>{{ $alternatifs[$alt_id]->nama ?? 'A' . $alt_id }}</td>
                                        <td>{{ number_format($nilai, 4) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <a href="{{ route('nilai-alternatif.index') }}" class="btn btn-secondary">← Kembali ke Daftar</a>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
@endsection
