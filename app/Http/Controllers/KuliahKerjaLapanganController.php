<?php

namespace App\Http\Controllers;

use App\Models\KuliahKerjaLapangan;
use App\Models\HimpunanMahasiswa;
use App\Models\AplikasiIntegrasi;
use App\Models\Kontak;
use App\Models\InformasiTerbaru;
use App\Models\Laboratorium;
use App\Models\ProfilSingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class KuliahKerjaLapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $kuliahKerjaLapangan = KuliahKerjaLapangan::all()->first();

        return view('admin.kuliah_kerja_lapangan.index', compact('kuliahKerjaLapangan', 'session_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, KuliahKerjaLapangan $kuliahKerjaLapangan)
    {
        $this->validate($request, [
            'id'     => 'required',
            'teks'     => 'required'
        ]);

        $kuliahKerjaLapangan = KuliahKerjaLapangan::all()
            ->where('id', $request->id)
            ->first();

        if ($request->nama_file == "") {
            $fileName = $kuliahKerjaLapangan->nama_file;

            KuliahKerjaLapangan::where('id', $request->id)
                ->update([
                    'teks' => $request->teks,
                    'nama_file' => $fileName,
                ]);
            return redirect('/admin/kuliah_kerja_lapangan')->with('status', 'Kerja Praktik Berhasil Diubah');
        } else {
            $file = $kuliahKerjaLapangan->nama_file;
            if (file_exists($file)) {
                @unlink($file);
            }

            $path_url = 'files/kuliah_kerja_lapangan/';

            $originName = $request->nama_file->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->nama_file->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->nama_file->move(public_path($path_url), $fileName);

            KuliahKerjaLapangan::where('id', $request->id)
                ->update([
                    'teks' => $request->teks,
                    'nama_file' => 'files/kuliah_kerja_lapangan/' . $fileName,
                ]);
            return redirect('/admin/kuliah_kerja_lapangan')->with('status', 'Kerja Praktik Berhasil Diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KuliahKerjaLapangan  $kuliahKerjaLapangan
     * @return \Illuminate\Http\Response
     */

    public function menuKuliahKerjaLapangan()
    {
        $kuliahKerjaLapangan = KuliahKerjaLapangan::all()
            ->first();

        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()
            ->take(3)
            ->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();
        $profilSingkat = ProfilSingkat::all()
            ->first();
        $kontak = Kontak::all()
            ->first();

        $laboratoriumHeaders = Laboratorium::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        return view('portal.kuliah_kerja_lapangan.index',  compact('kuliahKerjaLapangan', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
