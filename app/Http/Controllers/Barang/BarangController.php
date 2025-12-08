<?php

namespace App\Http\Controllers\Barang;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\BarangExport;
use Maatwebsite\Excel\Facades\Excel;

class BarangController extends Controller
{
     public function index(Request $request)
    {
        $search = $request->search;

        // Ambil nilai pagination dari query, default 5
        $perPage = $request->input('per_page', 5);

        $barang = Barang::with('admin')
            ->when($search, function ($query) use ($search) {
                $query->where('namaBarang', 'like', "%{$search}%")
                    ->orWhere('tahun', 'like', "%{$search}%")
                    ->orWhere('jenisBarang', 'like', "%{$search}%")
                    ->orWhere('nomorNUP', 'like', "%{$search}%")
                    ->orWhere('kondisi', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('barang.index', compact('barang', 'perPage'));
    }

    public function create(){
        return view('barang.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'namaBarang' => 'required',
            'tahun'      => 'required|numeric',
            'jenisBarang'=> 'required',
            'nomorNUP'   => 'required|unique:barang,nomorNUP',
            'kondisi'    => 'required',
            'lokasi'     => 'required|string|max:500',
            'keterangan'   => 'nullable|string',
            'fotoBarang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nomorNUP.unique' => 'Nomor NUP sudah digunakan!',
        ]);

        // Upload File
        $fotoPath = $request->file('fotoBarang')
                    ? $request->file('fotoBarang')->store('barang', 'public')
                    : null;

        Barang::create([
            'namaBarang' => $request->namaBarang,
            'tahun'      => $request->tahun,
            'jenisBarang'=> $request->jenisBarang,
            'nomorNUP'   => $request->nomorNUP,
            'kondisi'    => $request->kondisi,
            'lokasi'     => $request->lokasi,
            'latitude'   => $request->latitude,
            'longitude'  => $request->longitude,
            'keterangan'  => $request->keterangan,
            'admin_id'   => Auth::id(),
            'fotoBarang' => $fotoPath,
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan!');
    }


    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'namaBarang' => 'required',
            'tahun'      => 'required|numeric',
            'jenisBarang'=> 'required',
            'nomorNUP'   => "required|unique:barang,nomorNUP,$id,id",
            'kondisi'    => 'required',
            'fotoBarang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
             'keterangan'   => 'nullable|string'
        ]);

        // Upload foto baru (jika ada)
        if ($request->hasFile('fotoBarang')) {

            // Hapus foto lama jika ada
            if ($barang->fotoBarang && file_exists(storage_path("app/public/" . $barang->fotoBarang))) {
                unlink(storage_path("app/public/" . $barang->fotoBarang));
            }

            $fotoPath = $request->file('fotoBarang')->store('barang', 'public');
        } else {
            $fotoPath = $barang->fotoBarang; // tetap pakai foto lama
        }

        // Update data barang
        $barang->update([
            'namaBarang' => $request->namaBarang,
            'tahun'      => $request->tahun,
            'jenisBarang'=> $request->jenisBarang,
            'nomorNUP'   => $request->nomorNUP,
            'kondisi'    => $request->kondisi,
            'lokasi'     => $request->lokasi,
            'latitude'   => $request->latitude,
            'longitude'  => $request->longitude,
            'keterangan'  => $request->keterangan,
            'fotoBarang' => $fotoPath,
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil diperbarui!');
    }
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        // Hapus foto jika ada
        if ($barang->fotoBarang && file_exists(storage_path("app/public/" . $barang->fotoBarang))) {
            unlink(storage_path("app/public/" . $barang->fotoBarang));
        }

        // Hapus data dari database
        $barang->delete();

        return redirect('/barang')->with('success', 'Data barang berhasil dihapus!');
    }

    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.show', compact('barang'));
    }
        public function exportExcel()
    {
        return Excel::download(new BarangExport, 'data-barang.xlsx');
    }

}

