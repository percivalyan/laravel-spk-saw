<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    public function index()
    {
        $alternatifs = Alternatif::orderBy('created_at', 'desc')->paginate(10);
        return view('panel.alternatif.index', compact('alternatifs'));
    }

    public function create()
    {
        return view('panel.alternatif.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:alternatifs,kode',
            'nama' => 'required|string|max:255',
        ]);

        Alternatif::create($request->all());

        return redirect()->route('alternatif.index')->with('success', 'Alternatif berhasil ditambahkan.');
    }

    public function edit(Alternatif $alternatif)
    {
        return view('panel.alternatif.edit', compact('alternatif'));
    }

    public function update(Request $request, Alternatif $alternatif)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:alternatifs,kode,' . $alternatif->id,
            'nama' => 'required|string|max:255',
        ]);

        $alternatif->update($request->all());

        return redirect()->route('alternatif.index')->with('success', 'Alternatif berhasil diperbarui.');
    }

    public function destroy(Alternatif $alternatif)
    {
        $alternatif->delete();
        return redirect()->route('alternatif.index')->with('success', 'Alternatif berhasil dihapus.');
    }

    public function show(Alternatif $alternatif)
    {
        return view('panel.alternatif.show', compact('alternatif'));
    }
}
