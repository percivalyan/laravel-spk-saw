@extends('panel.layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5>Detail Nilai - {{ $alternatif->kode }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Kriteria</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alternatif->nilaiAlternatif as $nilai)
                                <tr>
                                    <td>{{ $nilai->kriteria->kode }}</td>
                                    <td>{{ $nilai->nilai }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('nilai-alternatif.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
