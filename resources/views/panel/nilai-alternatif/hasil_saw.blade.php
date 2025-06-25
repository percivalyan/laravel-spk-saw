@extends('panel.layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Hasil Perhitungan Metode SAW</h5>
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

                    <h5 class="fw-bold">2. Perhitungan Normalisasi <code>r<sub>ij</sub></code></h5>
                    <div class="mb-3">
                        <strong>Rumus:</strong>
                        <ul>
                            <li>
                                <img src="https://latex.codecogs.com/png.image?\dpi{110}&space;r_{ij}=\frac{x_{ij}}{\max&space;x_j}"
                                    alt="Rumus benefit" style="height: 30px;">
                                &nbsp; untuk kriteria <strong class="text-success">Benefit</strong>
                            </li>
                            <li>
                                <img src="https://latex.codecogs.com/png.image?\dpi{110}&space;r_{ij}=\frac{\min&space;x_j}{x_{ij}}"
                                    alt="Rumus cost" style="height: 30px;">
                                &nbsp; untuk kriteria <strong class="text-danger">Cost</strong>
                            </li>
                        </ul>
                    </div>

                    @foreach ($normalisasi as $alt_id => $nilaiKriteria)
                        <div class="mb-3">
                            <h6 class="fw-bold">Alternatif: {{ $alternatifs[$alt_id]->nama }}</h6>
                            <ul>
                                @foreach ($kriterias as $kriteria)
                                    @php
                                        $xij =
                                            $alternatifs[$alt_id]->nilaiAlternatif
                                                ->where('kriteria_id', $kriteria->id)
                                                ->first()?->nilai ?? 0;
                                        $normal = $nilaiKriteria[$kriteria->id];
                                        $max =
                                            $kriterias->firstWhere('id', $kriteria->id)->jenis == 'benefit'
                                                ? $alternatifs
                                                    ->map(
                                                        fn($a) => $a->nilaiAlternatif
                                                            ->where('kriteria_id', $kriteria->id)
                                                            ->first()?->nilai,
                                                    )
                                                    ->max()
                                                : $alternatifs
                                                    ->map(
                                                        fn($a) => $a->nilaiAlternatif
                                                            ->where('kriteria_id', $kriteria->id)
                                                            ->first()?->nilai,
                                                    )
                                                    ->min();
                                    @endphp
                                    <li>
                                        <code>r<sub>{{ $alt_id }}{{ $kriteria->id }}</sub></code> =
                                        @if ($kriteria->jenis == 'benefit')
                                            {{ $xij }} / {{ $max }} =
                                            <strong>{{ number_format($normal, 3) }}</strong>
                                        @else
                                            {{ $max }} / {{ $xij }} =
                                            <strong>{{ number_format($normal, 3) }}</strong>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach

                    <h5 class="fw-bold mt-5">3. Matriks Normalisasi (Tabel)</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Alternatif</th>
                                    @foreach ($kriterias as $kriteria)
                                        <th>{{ $kriteria->kode }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($normalisasi as $alt_id => $nilai)
                                    <tr>
                                        <td>{{ $alternatifs[$alt_id]->nama ?? 'A' . $alt_id }}</td>
                                        @foreach ($kriterias as $kriteria)
                                            <td>{{ number_format($nilai[$kriteria->id], 3) }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h5 class="fw-bold">3b. Matriks Normalisasi (Tampilan Matriks Seperti Gambar)</h5>
                    <div class="mb-4">
                        <pre class="bg-light p-3 rounded border" style="font-family: monospace; overflow-x: auto;">
@php
    $output = "[\n";
    foreach ($normalisasi as $alt_id => $nilai) {
        $output .= '  [';
        $values = [];
        foreach ($kriterias as $kriteria) {
            $values[] = str_pad(number_format($nilai[$kriteria->id], 3), 5, '0', STR_PAD_RIGHT);
        }
        $output .= implode('  ', $values) . "],\n";
    }
    $output .= ']';
    echo $output;
@endphp
    </pre>
                    </div>

                    <h5 class="fw-bold">4. Perhitungan Nilai Akhir Setiap Alternatif</h5>
                    <ul class="mb-4">
                        @foreach ($hasilSAW as $alt_id => $nilai)
                            <li>
                                V{{ $loop->iteration }} =
                                @php
                                    $parts = [];
                                    foreach ($kriterias as $kriteria) {
                                        $val = $normalisasi[$alt_id][$kriteria->id];
                                        $bobot = $kriteria->bobot;
                                        $parts[] = "($bobot × " . number_format($val, 3) . ')';
                                    }
                                @endphp
                                {!! implode(' + ', $parts) !!}
                                = <strong>{{ number_format($nilai, 4) }}</strong>
                            </li>
                        @endforeach
                    </ul>

                    <h5 class="fw-bold">5. Hasil Akhir (Ranking)</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-striped table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Ranking</th>
                                    <th>Alternatif</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $rank = 1; @endphp
                                @foreach ($hasilSAW as $alt_id => $nilai)
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
@endsection
