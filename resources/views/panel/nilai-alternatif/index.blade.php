@extends('panel.layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Nilai Alternatif</h5>
                    <a href="{{ route('nilai-alternatif.create') }}" class="btn btn-primary">Input Nilai Baru</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <a href="{{ route('nilai-alternatif.hitung_saw') }}" class="btn btn-primary mb-3">Hitung Normalisasi SAW</a>
                    <a href="{{ route('nilai-alternatif.hitung_wp') }}" class="btn btn-success mb-3">Hitung Normalisasi WP</a>
                    <a href="{{ route('nilai-alternatif.hitung_topsis') }}" class="btn btn-secondary mb-3">Hitung Normalisasi TOPSIS</a>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Alternatif</th>
                                    @foreach ($kriterias as $kriteria)
                                        <th>{{ $kriteria->kode }}</th>
                                    @endforeach
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($alternatifs as $alt)
                                    <tr>
                                        <td>{{ $alt->kode }}</td>
                                        @foreach ($kriterias as $kriteria)
                                            <td>{{ optional($alt->nilaiAlternatif->firstWhere('kriteria_id', $kriteria->id))->nilai ?? '-' }}
                                            </td>
                                        @endforeach
                                        <td>
                                            <a href="{{ route('nilai-alternatif.show', $alt->id) }}"
                                                class="btn btn-sm btn-info">Lihat</a>
                                            <a href="{{ route('nilai-alternatif.edit', $alt->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('nilai-alternatif.destroy', $alt->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ count($kriterias) + 2 }}" class="text-center">Tidak ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
