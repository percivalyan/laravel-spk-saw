@extends('panel.layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5>Edit Nilai - {{ $alternatif->kode }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('nilai-alternatif.update', $alternatif->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row">
                            @foreach ($kriterias as $kriteria)
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ $kriteria->kode }}</label>
                                    <input type="number" step="0.01" name="nilai[{{ $kriteria->id }}]"
                                        class="form-control" value="{{ $nilaiAlternatif[$kriteria->id]->nilai ?? '' }}"
                                        required>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary">Update</button>
                            <a href="{{ route('nilai-alternatif.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
