<?php

namespace App\Http\Controllers;

use App\Models\TugasAkhir;
use App\Models\HimpunanMahasiswa;
use App\Models\AplikasiIntegrasi;
use App\Models\Kontak;
use App\Models\InformasiTerbaru;
use App\Models\Laboratorium;
use App\Models\ProfilSingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TugasAkhirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $tugasAkhir = TugasAkhir::all()->first();

        return view('admin.tugas_akhir.index', compact('tugasAkhir', 'session_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, TugasAkhir $tugasAkhir)
    {
        $this->validate($request, [
            'id'     => 'required',
            'teks'     => 'required'
        ]);

        $tugasAkhir = TugasAkhir::all()
            ->where('id', $request->id)
            ->first();

        if ($request->nama_file == "") {
            $fileName = $tugasAkhir->nama_file;

            TugasAkhir::where('id', $request->id)
                ->update([
                    'teks' => $request->teks,
                    'nama_file' => $fileName,
                ]);
            return redirect('/admin/tugas_akhir')->with('status', 'Tugas Akhir Berhasil Diubah');
        } else {
            $file = $tugasAkhir->nama_file;
            if (file_exists($file)) {
                @unlink($file);
            }

            $path_url = 'files/tugas_akhir/';

            $originName = $request->nama_file->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->nama_file->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->nama_file->move(public_path($path_url), $fileName);

            TugasAkhir::where('id', $request->id)
                ->update([
                    'teks' => $request->teks,
                    'nama_file' => 'files/tugas_akhir/' . $fileName,
                ]);
            return redirect('/admin/tugas_akhir')->with('status', 'Tugas Akhir Berhasil Diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TugasAkhir  $tugasAkhir
     * @return \Illuminate\Http\Response
     */

    public function menuTugasAkhir()
    {
        $tugasAkhir = TugasAkhir::all()
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

        return view('portal.tugas_akhir.index',  compact('tugasAkhir', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
