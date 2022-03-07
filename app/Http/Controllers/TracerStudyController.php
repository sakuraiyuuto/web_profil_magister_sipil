<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\Kontak;
use App\Models\Laboratorium;
use Illuminate\Support\Facades\Http;

class TracerStudyController extends Controller
{
    public function menuDetailTracerstudy()
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();

        $response = Http::get('http://tracerstudyalumni.untan.ac.id/API/getDataJumlah/219');

        $tracerStudy = $response->json($key = null);
        $status = $tracerStudy["status"];
        $jumlahPengisi = $tracerStudy["jumlahPengisi"];
        $jumlahPengisiValidasi = $tracerStudy["jumlahPengisiValidasi"];
        $jumlahPengisihariini = $tracerStudy["jumlahPengisihariini"];

        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()
            ->take(3)
            ->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();

        $laboratoriumHeaders = Laboratorium::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        return view('portal.berita.detail',  compact('status', 'jumlahPengisi', 'jumlahPengisiValidasi', 'jumlahPengisihariini', 'berita', 'beritas', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
