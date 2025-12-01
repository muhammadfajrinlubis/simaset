<?php

namespace App\Http\Controllers\Barang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
     public function index(Request $request)
    {
        $search = $request->search;

        $barang = DB::table('barang')
            ->when($search, function ($query) use ($search) {
                $query->where('namaBarang', 'like', "%$search%")
                    ->orWhere('lokasi', 'like', "%$search%")
                    ->orWhere('kondisi', 'like', "%$search%");
            })
            ->orderBy('barang.id', 'DESC')
            ->get();

        return view('barang.index', compact('barang'));
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
            'fotoBarang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan foto
        $fotoPath = null;
        if ($request->hasFile('fotoBarang')) {
            $fotoPath = $request->file('fotoBarang')->store('barang', 'public');
        }

        // Ambil ID admin yang login
        // $adminId = Auth::user()->adminId;

        // Simpan data ke DB
        DB::table('barang')->insert([
            'namaBarang' => $request->namaBarang,
            'tahun'      => $request->tahun,
            'jenisBarang'=> $request->jenisBarang,
            'nomorNUP'   => $request->nomorNUP,
            'kondisi'    => $request->kondisi,
            'lokasi'     => $request->lokasi,
            'latitude'   => $request->latitude,
            'longitude'  => $request->longitude,
            // 'admin_id'   => $adminId,      // ⬅ simpan ID admin di sini
            'fotoBarang' => $fotoPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Data barang berhasil disimpan!');
    }
}
