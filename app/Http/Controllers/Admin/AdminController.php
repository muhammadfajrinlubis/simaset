<?php
namespace App\Http\Controllers\Admin;

use Hash;
use App\Models\Admin;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        // Hitung data barang
        $totalBarang = Barang::count();
        $barangBerfungsi = Barang::where('kondisi', 'Berfungsi')->count();
        $barangRusak = Barang::where('kondisi', 'Rusak')->count();

        // Data untuk grafik (per tahun)
        $grafikTahun = Barang::selectRaw('tahun, COUNT(*) as total')
            ->whereNotNull('tahun') // Tambahkan ini untuk memastikan tahun tidak null
            ->groupBy('tahun')
            ->orderBy('tahun', 'ASC')
            ->get();

        // Debug: tambahkan dd() untuk melihat data
        // dd($grafikTahun);

        return view('dashboard', [
            'totalBarang' => $totalBarang,
            'barangBerfungsi' => $barangBerfungsi,
            'barangRusak' => $barangRusak,
            'grafikTahun' => $grafikTahun
        ]);
    }

   public function editPassword($id)
    {
        // Ambil admin yang login
        $authAdmin = auth()->user();

        // Jika mencoba akses ID admin lain → 404
        if ($authAdmin->id != $id) {
            abort(404);
        }

        // Jika id cocok → lanjut
        $admin = Admin::findOrFail($id);

        return view('auth.edit-password', compact('admin'));
    }

    public function updatePassword(Request $request, $id)
    {
        $authAdmin = auth()->user();

        if ($authAdmin->id != $id) {
            abort(404);
        }

        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6',
            'konfirmasi_password' => 'required|same:password_baru',
        ], [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min' => 'Password baru minimal 6 karakter.',
            'konfirmasi_password.required' => 'Konfirmasi password wajib diisi.',
            'konfirmasi_password.same' => 'Konfirmasi password tidak cocok.',
        ]);

        $admin = Admin::findOrFail($id);

        if (!Hash::check($request->password_lama, $admin->passwordHash)) {
            return back()
                ->withErrors(['password_lama' => 'Password lama yang Anda masukkan salah!'])
                ->with('error_swal', 'Password lama salah!');
        }

        $admin->passwordHash = Hash::make($request->password_baru);
        $admin->save();

        return redirect()
            ->route('admin.editPassword', $id)
            ->with('success', 'Password berhasil diperbarui!');
    }

}
