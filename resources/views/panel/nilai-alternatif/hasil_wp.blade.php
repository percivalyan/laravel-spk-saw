@extends('panel.layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Hasil Perhitungan Metode Weighted Product (WP)</h5>
                </div>
                <div class="card-body">

                    {{-- 1. Perbaikan Bobot --}}
                    <h5 class="fw-bold mb-3">1. Perbaikan Bobot (Normalisasi)</h5>
                    <p><img src="https://latex.codecogs.com/png.image?\dpi{110}w_j'=\frac{w_j}{\sum w_j}" alt="LaTeX Rumus" />
                    </p>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Jenis</th>
                                    <th>Bobot Asli</th>
                                    <th>Bobot Normalisasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kriterias as $kriteria)
                                    <tr>
                                        <td>{{ $kriteria->kode }}</td>
                                        <td>{{ ucfirst($kriteria->jenis) }}</td>
                                        <td>{{ $kriteria->bobot }}</td>
                                        <td>{{ number_format($bobotPerbaikan[$kriteria->id], 4) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- 2. Menetapkan Vektor S --}}
                    <h5 class="fw-bold mb-3">2. Menetapkan Vektor S</h5>
                    <p><img src="https://latex.codecogs.com/png.image?\dpi{110}S_i=\prod x_{ij}^{w_j'}\quad(\text{cost}\rightarrow w_j'\text{ menjadi negatif})"
                            alt="Rumus Si" /></p>
                    @foreach ($perhitunganS as $alt_id => $details)
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">Alternatif: {{ $alternatifs[$alt_id]->nama }}</h6>
                            <ul class="mb-2">
                                @foreach ($details as $d)
                                    <li>
                                        ({{ $d['nilai'] }}<sup>{{ $d['jenis'] == 'benefit' ? number_format($d['w'], 4) : '-' . number_format($d['w'], 4) }}</sup>)
                                        = {{ number_format($d['hasil'], 6) }}
                                    </li>
                                @endforeach
                            </ul>
                            <strong>S{{ $alt_id }} = {{ number_format($nilaiS[$alt_id], 6) }}</strong>
                        </div>
                    @endforeach

                    {{-- 3. Total S --}}
                    <h5 class="fw-bold mb-3">3. Total Nilai S (ΣS)</h5>
                    <p><strong>ΣS = {{ number_format($totalS, 6) }}</strong></p>

                    {{-- 4. Menetapkan Vektor V --}}
                    <h5 class="fw-bold mb-3">4. Menetapkan Vektor V</h5>
                    <p><img src="https://latex.codecogs.com/png.image?\dpi{110}V_i=\frac{S_i}{\sum S_i}" alt="Rumus Vi" />
                    </p>
                    <ul class="mb-4">
                        @foreach ($nilaiV as $alt_id => $v)
                            <li>
                                V{{ $alt_id }} =
                                {{ number_format($nilaiS[$alt_id], 6) }} / {{ number_format($totalS, 6) }}
                                = <strong>{{ number_format($v, 9) }}</strong>
                            </li>
                        @endforeach
                    </ul>

                    {{-- 5. Ranking --}}
                    <h5 class="fw-bold mb-3">5. Ranking Alternatif</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Peringkat</th>
                                    <th>Alternatif</th>
                                    <th>Nilai V</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $rank = 1;
                                    $sorted = collect($nilaiV)->sortDesc();
                                @endphp
                                @foreach ($sorted as $id => $v)
                                    <tr>
                                        <td>{{ $rank++ }}</td>
                                        <td>{{ $alternatifs[$id]->nama }}</td>
                                        <td>{{ number_format($v, 9) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <a href="{{ route('nilai-alternatif.index') }}" class="btn btn-secondary mt-3">← Kembali ke Daftar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
