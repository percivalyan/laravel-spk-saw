@extends('panel.layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5>Detail Kriteria</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Kode</th>
                            <td>{{ $kriteria->kode }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $kriteria->nama }}</td>
                        </tr>
                        <tr>
                            <th>Bobot</th>
                            <td>{{ $kriteria->bobot }}</td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td>{{ ucfirst($kriteria->jenis) }}</td>
                        </tr>
                    </table>
                    <a href="{{ route('kriteria.index') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
