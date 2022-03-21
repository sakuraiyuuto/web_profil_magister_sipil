<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\HimpunanMahasiswa;
use App\Models\Penunjang;
use App\Models\ProfilLulusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfilLulusanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $profilLulusan = ProfilLulusan::all()->first();
        return view('admin.profil_lulusan.index',  compact('profilLulusan', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProfilLulusan  $profilLulusan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProfilLulusan $profilLulusan)
    {
        $this->validate($request, [
            'teks'     => 'required'
        ]);

        ProfilLulusan::where('id', $profilLulusan->id)
            ->update([
                'teks' => $request->teks
            ]);

        return redirect('admin/profil_lulusan')->with('status', 'ProfilLulusan Berhasil Diubah!');
    }

    public function menuProfilLulusan()
    {
        $profilLulusan = ProfilLulusan::all()
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

        $penunjangHeaders = Penunjang::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        return view('portal.profil_lulusan.index',  compact('profilLulusan', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'penunjangHeaders'));
    }
}
