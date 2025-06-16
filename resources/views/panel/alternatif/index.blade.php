@extends('panel.layouts.app')

@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Alternatif</h5>
                    <a href="{{ route('alternatif.create') }}" class="btn btn-primary">Tambah Alternatif</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($alternatifs as $alternatif)
                                <tr>
                                    <td>{{ $alternatif->kode }}</td>
                                    <td>{{ $alternatif->nama }}</td>
                                    <td>
                                        <a href="{{ route('alternatif.show', $alternatif->id) }}"
                                            class="btn btn-info btn-sm">Lihat</a>
                                        <a href="{{ route('alternatif.edit', $alternatif->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('alternatif.destroy', $alternatif->id) }}" method="POST"
                                            class="d-inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $alternatifs->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
