<?php

namespace App\Http\Controllers;

use App\Models\AplikasiIntegrasi;
use App\Models\Dosen;
use App\Models\Kontak;
use App\Models\InformasiTerbaru;

use App\Models\HimpunanMahasiswa;
use App\Models\KelompokKeahlianDosen;
use App\Models\Penunjang;
use App\Models\ProfilSingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $kelompokKeahlianDosens = KelompokKeahlianDosen::withTrashed()->get()->sortByDesc('id');
        $kelompokKeahlianDosenPilihans = KelompokKeahlianDosen::all()->sortByDesc('id');
        $dosens = Dosen::withTrashed()->with('kelompokKeahlianDosen')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.dosen.index', compact('dosens', 'kelompokKeahlianDosens', 'kelompokKeahlianDosenPilihans', 'session_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto' => 'required|mimes:jpg,jpeg,png,svg,gif',
            'nama' => 'required',
            'nip' => 'required',
            'pangkat_golongan' => 'required',
            'kelompok_keahlian_dosen_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/dosen')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'images/dosen/';

            $originName = $request->foto->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->foto->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->foto->move(public_path($path_url), $fileName);

            //Resize image here
            $thumbnailpath = public_path($path_url) . $fileName;
            $img = Image::make($thumbnailpath)->resize(720, 480, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($thumbnailpath);

            Dosen::create([
                'foto' => 'images/dosen/' . $fileName,
                'nama' => $request->nama,
                'nip' => $request->nip,
                'pangkat_golongan' => $request->pangkat_golongan,
                'sinta' => $request->sinta,
                'url' => $request->url,
                'kelompok_keahlian_dosen_id' => $request->kelompok_keahlian_dosen_id,
            ]);

            return redirect('/admin/dosen')->with('status', 'Data Berhasil Ditambah!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required',
            'pangkat_golongan' => 'required',
            'kelompok_keahlian_dosen_id' => 'required'
        ]);

        if ($request->foto != "") {
            $path_url = 'images/dosen/';

            $originName = $request->foto->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->foto->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->foto->move(public_path($path_url), $fileName);

            //Resize image here
            $thumbnailpath = public_path($path_url) . $fileName;
            $img = Image::make($thumbnailpath)->resize(720, 480, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($thumbnailpath);

            if (File::exists(public_path($request->old_thumbnail))) {
                File::delete(public_path($request->old_thumbnail));
            }

            Dosen::where('id', $request->id)
                ->update([
                    'foto' => 'images/dosen/' . $fileName,
                    'nama' => $request->nama,
                    'nip' => $request->nip,
                    'pangkat_golongan' => $request->pangkat_golongan,
                    'sinta' => $request->sinta,
                    'url' => $request->url,
                    'kelompok_keahlian_dosen_id' => $request->kelompok_keahlian_dosen_id,
                ]);
        } else {
            Dosen::where('id', $request->id)
                ->update([
                    'nama' => $request->nama,
                    'nip' => $request->nip,
                    'pangkat_golongan' => $request->pangkat_golongan,
                    'sinta' => $request->sinta,
                    'url' => $request->url,
                    'kelompok_keahlian_dosen_id' => $request->kelompok_keahlian_dosen_id,
                ]);
        }

        return redirect('/admin/dosen')->with('status', 'Data Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dosen $dosen)
    {
        Dosen::destroy($dosen->id);

        return redirect('/admin/dosen')->with('status', 'Data Berhasil Dihapus!');
    }

    public function restore($id)
    {
        $dosen = Dosen::withTrashed()
            ->where('id', $id)
            ->first();

        $dosen->restore();
        return redirect('/admin/dosen')->with('status', 'Dosen Berhasil Direstore');
    }

    public function delete($id)
    {
        $dosen = Dosen::withTrashed()
            ->where('id', $id)
            ->first();

        $dosen->forceDelete();
        return redirect('/admin/dosen')->with('status', 'Dosen Berhasil Dihapus Permanen');
    }

    public function menuDosen()
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $dosens = Dosen::orderBy('nama', 'ASC')
            ->get();

        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()
            ->take(3)
            ->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();

        $penunjangHeaders = Penunjang::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        return view('portal.dosen.index',  compact('dosens', 'kontak', 'informasiTerbarus', 'aplikasiIntegrasis',  'profilSingkat', 'penunjangHeaders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeKelompoKeahlianDosen(Request $request)
    {
        $request->validate([
            'kelompok_keahlian' => 'required',
        ]);

        KelompokKeahlianDosen::create($request->all());

        return redirect('/admin/dosen')->with('status', 'Kelompok Keahlian Dosen Berhasil Ditambah');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KelompokKeahlianDosen  $kelompokKeahlianDosen
     * @return \Illuminate\Http\Response
     */
    public function updateKelompoKeahlianDosen(Request $request, KelompokKeahlianDosen $kelompokKeahlianDosen)
    {
        $request->validate([
            'kelompok_keahlian' => 'required',
        ]);

        KelompokKeahlianDosen::where('id', $request->id)
            ->update([
                'kelompok_keahlian' => $request->kelompok_keahlian,
            ]);

        return redirect('/admin/dosen')->with('status', 'Kelompok Keahlian Dosen Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KelompokKeahlianDosen  $kelompokKeahlianDosen
     * @return \Illuminate\Http\Response
     */
    public function destroyKelompoKeahlianDosen(KelompokKeahlianDosen $kelompokKeahlianDosen)
    {
        KelompokKeahlianDosen::destroy($kelompokKeahlianDosen->id);

        return redirect('/admin/dosen')->with('status', 'Kelompok Keahlian Dosen Berhasil Dihapus');
    }

    public function restoreKelompoKeahlianDosen($id)
    {
        $kelompokKeahlianDosen = KelompokKeahlianDosen::withTrashed()
            ->where('id', $id)
            ->first();

        $kelompokKeahlianDosen->restore();
        return redirect('/admin/dosen')->with('status', 'Kelompok Keahlian Dosen Berhasil Direstore');
    }

    public function deleteKelompoKeahlianDosen($id)
    {
        $kelompokKeahlianDosen = KelompokKeahlianDosen::withTrashed()
            ->where('id', $id)
            ->first();

        $kelompokKeahlianDosen->forceDelete();
        return redirect('/admin/dosen')->with('status', 'Kelompok Keahlian Dosen Berhasil Dihapus Permanen');
    }
}
