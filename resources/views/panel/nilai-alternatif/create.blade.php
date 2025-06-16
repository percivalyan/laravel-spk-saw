@extends('panel.layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h5>Input Nilai Alternatif</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('nilai-alternatif.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Alternatif</label>
                            <select name="alternatif_id" class="form-control" required>
                                @foreach ($alternatifs as $alt)
                                    <option value="{{ $alt->id }}">{{ $alt->kode }} - {{ $alt->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            @foreach ($kriterias as $kriteria)
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{ $kriteria->kode }}</label>
                                    <input type="number" step="0.01" name="nilai[{{ $kriteria->id }}]"
                                        class="form-control" required>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-success">Simpan</button>
                            <a href="{{ route('nilai-alternatif.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
