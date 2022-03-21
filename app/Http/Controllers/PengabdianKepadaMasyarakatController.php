<?php

namespace App\Http\Controllers;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\PengabdianKepadaMasyarakat;
use App\Models\HimpunanMahasiswa;
use App\Models\Kontak;
use App\Models\Penunjang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;


class PengabdianKepadaMasyarakatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $pengabdianKepadaMasyarakats = PengabdianKepadaMasyarakat::withTrashed()->get()
            ->sortDesc();
        return view('admin/pengabdian_kepada_masyarakat.index', compact('pengabdianKepadaMasyarakats', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/pengabdian_kepada_masyarakat.create', compact('session_user'));
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
            'judul' => 'required',
            'author' => 'required',
            'tahun' => 'required',
            'thumbnail' => 'required|mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/pengabdian_kepada_masyarakat')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'images/pengabdian_kepada_masyarakat/';

            $originName = $request->thumbnail->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->thumbnail->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->thumbnail->move(public_path($path_url), $fileName);

            //Resize image here
            $thumbnailpath = public_path($path_url) . $fileName;
            $img = Image::make($thumbnailpath)->resize(720, 480, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($thumbnailpath);

            $slug = Str::slug($request->judul) . '_' . time();

            PengabdianKepadaMasyarakat::create([
                'thumbnail' => 'images/pengabdian_kepada_masyarakat/' . $fileName,
                'judul' => $request->judul,
                'author' => $request->author,
                'tahun' => $request->tahun,
                'teks' => $request->teks,
                'slug' => 'pengabdian_kepada_masyarakat/' . $slug,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/pengabdian_kepada_masyarakat')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PengabdianKepadaMasyarakat  $pengabdianKepadaMasyarakats
     * @return \Illuminate\Http\Response
     */
    public function show(PengabdianKepadaMasyarakat $pengabdianKepadaMasyarakats)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PengabdianKepadaMasyarakat  $pengabdianKepadaMasyarakats
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $session_user = Auth::user();
        $pengabdianKepadaMasyarakat = PengabdianKepadaMasyarakat::all()->firstWhere('id', $id);

        return view('admin.pengabdian_kepada_masyarakat.edit', compact('pengabdianKepadaMasyarakat', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PengabdianKepadaMasyarakat  $pengabdianKepadaMasyarakats
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'judul' => 'required',
            'author' => 'required',
            'tahun' => 'required',
            'thumbnail' => 'mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/pengabdian_kepada_masyarakat')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $pengabdianKepadaMasyarakats = PengabdianKepadaMasyarakat::all()
                ->where('id', $request->id)
                ->first();

            if ($request->thumbnail == "") {
                $fileName = $pengabdianKepadaMasyarakats->thumbnail;

                PengabdianKepadaMasyarakat::where('id', $request->id)
                    ->update([
                        'thumbnail' => $fileName,
                        'judul' => $request->judul,
                        'author' => $request->author,
                        'tahun' => $request->tahun,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/pengabdian_kepada_masyarakat')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Diubah');
            } else {
                $file = $pengabdianKepadaMasyarakats->thumbnail;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/pengabdian_kepada_masyarakat/';

                $originName = $request->thumbnail->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->thumbnail->getClientOriginalExtension();
                $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
                $request->thumbnail->move(public_path($path_url), $fileName);

                //Resize image here
                $thumbnailpath = public_path($path_url) . $fileName;
                $img = Image::make($thumbnailpath)->resize(720, 480, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($thumbnailpath);

                PengabdianKepadaMasyarakat::where('id', $request->id)
                    ->update([
                        'thumbnail' => 'images/pengabdian_kepada_masyarakat/' . $fileName,
                        'judul' => $request->judul,
                        'author' => $request->author,
                        'tahun' => $request->tahun,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/pengabdian_kepada_masyarakat')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PengabdianKepadaMasyarakat  $pengabdianKepadaMasyarakats
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PengabdianKepadaMasyarakat::destroy($id);
        return redirect('/admin/pengabdian_kepada_masyarakat')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Dihapus');
    }

    public function restore($id)
    {
        $pengabdianKepadaMasyarakat = PengabdianKepadaMasyarakat::withTrashed()
            ->where('id', $id)
            ->first();

        $pengabdianKepadaMasyarakat->restore();
        return redirect('/admin/pengabdian_kepada_masyarakat')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Direstore');
    }

    public function delete($id)
    {
        $pengabdianKepadaMasyarakat = PengabdianKepadaMasyarakat::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $pengabdianKepadaMasyarakat->thumbnail;

        if (file_exists($file)) {
            @unlink($file);
        }

        $pengabdianKepadaMasyarakat->forceDelete();
        return redirect('/admin/pengabdian_kepada_masyarakat')->with('status', 'Pengabdian Kepada Masyarakat Berhasil Dihapus Permanen');
    }

    public function menuPengabdianKepadaMasyarakat()
    {
        $pengabdianKepadaMasyarakats = PengabdianKepadaMasyarakat::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('tahun', 'DESC')
            ->get();

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

        return view('portal.pengabdian_kepada_masyarakat.index',  compact('pengabdianKepadaMasyarakats', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'penunjangHeaders'));
    }

    public function menuDetailPengabdianKepadaMasyarakat($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $pengabdianKepadaMasyarakat = PengabdianKepadaMasyarakat::where('slug', 'pengabdian_kepada_masyarakat/' . $slug)
            ->firstOrFail();

        $pengabdianKepadaMasyarakats = PengabdianKepadaMasyarakat::where('release_date', '<=', date('Y-m-d'))
            ->where('slug', '!=', 'pengabdian_kepada_masyarakat/' . $slug)
            ->take(2)
            ->orderBy('release_date', 'DESC');
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

        return view('portal.pengabdian_kepada_masyarakat.detail',  compact('pengabdianKepadaMasyarakat', 'pengabdianKepadaMasyarakats', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'penunjangHeaders'));
    }
}
