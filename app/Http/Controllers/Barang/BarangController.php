<?php

namespace App\Http\Controllers\Barang;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Exports\BarangExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

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
            'namaBarang'   => 'required',
            'tahun'        => 'required|numeric',
            'jenisBarang'  => 'required',
            'nomorNUP'     => 'required|unique:barang,nomorNUP',
            'kondisi'      => 'required',
            'lokasi'       => 'required|string|max:500',
            'keterangan'   => 'nullable|string',
            'fotoBarang'   => 'required|array|size:4', // HARUS array dengan 4 elemen
            'fotoBarang.*' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'nomorNUP.unique'      => 'Nomor NUP sudah digunakan!',
            'fotoBarang.required'  => 'Anda wajib mengupload 4 foto!',
            'fotoBarang.size'      => 'Anda wajib mengupload tepat 4 foto!',
            'fotoBarang.*.required'=> 'Semua foto wajib diisi!',
            'fotoBarang.*.image'   => 'File harus berupa gambar!',
            'fotoBarang.*.mimes'   => 'Format foto harus jpeg, jpg, atau png!',
            'fotoBarang.*.max'     => 'Ukuran foto maksimal 2 MB!',
        ]);

        // Simpan foto-foto
        $fotoPaths = [];
        foreach ($request->file('fotoBarang') as $foto) {
            $path = $foto->store('barang', 'public');
            $fotoPaths[] = $path;
        }

        // Simpan data barang
        Barang::create([
            'namaBarang'  => $request->namaBarang,
            'tahun'       => $request->tahun,
            'jenisBarang' => $request->jenisBarang,
            'nomorNUP'    => $request->nomorNUP,
            'kondisi'     => $request->kondisi,
            'lokasi'      => $request->lokasi,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'keterangan'  => $request->keterangan,
            'admin_id'    => Auth::id(),
            'fotoBarang'  => json_encode($fotoPaths),
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

        // Ambil foto lama
        $fotoLama = json_decode($barang->fotoBarang, true);

        // Foto lama yang dihapus (array dari JS)
        $deletedPhotos = json_decode($request->hapus_foto, true) ?? [];

        // Hapus foto lama yang dipilih user
        $fotoLamaSetelahHapus = [];
        foreach ($fotoLama as $foto) {
            if (in_array($foto, $deletedPhotos)) {
                // hapus file dari storage
                Storage::disk('public')->delete($foto);
            } else {
                $fotoLamaSetelahHapus[] = $foto;
            }
        }

        // Foto baru yang diupload
        $fotoBaru = $request->file('fotoBarang') ?? [];

        // VALIDASI WAJIB TEPAT 4 FOTO
        $totalFotoFinal = count($fotoLamaSetelahHapus) + count($fotoBaru);

        if ($totalFotoFinal !== 4) {
            return back()
                ->with('error', "Total foto harus tepat 4! Saat ini: $totalFotoFinal foto.")
                ->withInput();
        }

        // Validasi lainnya
        $request->validate([
            'namaBarang'   => 'required',
            'tahun'        => 'required|numeric',
            'jenisBarang'  => 'required',
            'nomorNUP'     => "required|unique:barang,nomorNUP,{$barang->id}",
            'kondisi'      => 'required',
            'lokasi'       => 'required|string|max:500',
            'keterangan'   => 'nullable|string',

            // foto baru boleh kosong tapi kalau ada harus valid
            'fotoBarang.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'nomorNUP.unique'      => 'Nomor NUP sudah digunakan!',
            'fotoBarang.*.image'   => 'File harus berupa gambar!',
            'fotoBarang.*.mimes'   => 'Format foto harus jpeg, jpg, atau png!',
            'fotoBarang.*.max'     => 'Ukuran foto maksimal 2 MB!',
        ]);

        // Simpan foto baru
        $fotoBaruPaths = [];
        foreach ($fotoBaru as $foto) {
            $path = $foto->store('barang', 'public');
            $fotoBaruPaths[] = $path;
        }

        // Gabungkan foto lama + foto baru (hasil final)
        $finalFoto = array_merge($fotoLamaSetelahHapus, $fotoBaruPaths);

        // Update database
        $barang->update([
            'namaBarang'  => $request->namaBarang,
            'tahun'       => $request->tahun,
            'jenisBarang' => $request->jenisBarang,
            'nomorNUP'    => $request->nomorNUP,
            'kondisi'     => $request->kondisi,
            'lokasi'      => $request->lokasi,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'keterangan'  => $request->keterangan,
            'fotoBarang'  => json_encode($finalFoto),
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

