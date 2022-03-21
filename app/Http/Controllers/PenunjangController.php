<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\LinkProdi;
use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\Penunjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class PenunjangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $penunjangs = Penunjang::withTrashed()->get()
            ->sortDesc();
        return view('admin/penunjang.index', compact('penunjangs', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/penunjang.create', compact('session_user'));
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
            'nama' => 'required',
            'thumbnail' => 'required|mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/penunjang')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'images/penunjang/';

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

            $slug = Str::slug($request->nama) . '_' . time();

            Penunjang::create([
                'thumbnail' => 'images/penunjang/' . $fileName,
                'nama' => $request->nama,
                'teks' => $request->teks,
                'slug' => 'penunjang/' . $slug,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/penunjang')->with('status', 'Penunjang Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penunjang  $penunjangs
     * @return \Illuminate\Http\Response
     */
    public function show(Penunjang $penunjangs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penunjang  $penunjangs
     * @return \Illuminate\Http\Response
     */
    public function edit(Penunjang $penunjang)
    {
        $session_user = Auth::user();
        $penunjang = Penunjang::all()->firstWhere('slug', $penunjang->slug);

        return view('admin.penunjang.edit', compact('penunjang', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penunjang  $penunjangs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nama' => 'required',
            'thumbnail' => 'mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/penunjang')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $penunjangs = Penunjang::all()
                ->where('id', $request->id)
                ->first();

            if ($request->thumbnail == "") {
                $fileName = $penunjangs->thumbnail;

                Penunjang::where('id', $request->id)
                    ->update([
                        'thumbnail' => $fileName,
                        'nama' => $request->nama,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/penunjang')->with('status', 'Penunjang Berhasil Diubah');
            } else {
                $file = $penunjangs->thumbnail;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/penunjang/';

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

                Penunjang::where('id', $request->id)
                    ->update([
                        'thumbnail' => 'images/penunjang/' . $fileName,
                        'nama' => $request->nama,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/penunjang')->with('status', 'Penunjang Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penunjang  $penunjangs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Penunjang::destroy($id);
        return redirect('/admin/penunjang')->with('status', 'Penunjang Berhasil Dihapus');
    }

    public function restore($id)
    {
        $penunjang = Penunjang::withTrashed()
            ->where('id', $id)
            ->first();

        $penunjang->restore();
        return redirect('/admin/penunjang')->with('status', 'Penunjang Berhasil Direstore');
    }

    public function delete($id)
    {
        $penunjang = Penunjang::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $penunjang->thumbnail;

        if (file_exists($file)) {
            @unlink($file);
        }

        $penunjang->forceDelete();
        return redirect('/admin/penunjang')->with('status', 'Penunjang Berhasil Dihapus Permanen');
    }

    public function menuPenunjang()
    {
        $kontak = Kontak::all()->first();
        $profilSingkat = ProfilSingkat::all()->first();
        $penunjangHeaders = Penunjang::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        $penunjangPaginates = Penunjang::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->paginate(6);
        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()->take(3)->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();

        return view('portal.penunjang.index',  compact('penunjangPaginates', 'penunjangHeaders', 'aplikasiIntegrasis', 'informasiTerbarus', 'linkProdis', 'profilSingkat', 'kontak'));
    }

    public function menuDetailPenunjang($slug)
    {
        $kontak = Kontak::all()->first();
        $profilSingkat = ProfilSingkat::all()->first();
        $penunjang = Penunjang::where('slug', 'penunjang/' . $slug)
            ->firstOrFail();
        $penunjangHeaders = Penunjang::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        $penunjangs = Penunjang::where('release_date', '<=', date('Y-m-d'))
            ->where('slug', '!=', 'penunjang/' . $slug)
            ->orderBy('release_date', 'DESC')
            ->take(2)
            ->get();
        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()->take(3)->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();

        return view('portal.penunjang.detail',  compact('penunjang', 'penunjangs', 'penunjangHeaders', 'aplikasiIntegrasis', 'informasiTerbarus', 'linkProdis', 'profilSingkat', 'kontak'));
    }
}
