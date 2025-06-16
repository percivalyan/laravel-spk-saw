@extends('panel.layouts.app')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <h5>Detail Alternatif</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Kode</th>
                        <td>{{ $alternatif->kode }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $alternatif->nama }}</td>
                    </tr>
                </table>
                <a href="{{ route('alternatif.index') }}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
