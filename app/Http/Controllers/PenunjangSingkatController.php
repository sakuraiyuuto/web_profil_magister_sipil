<?php

namespace App\Http\Controllers;

use App\Models\PenunjangSingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class PenunjangSingkatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $penunjangSingkat = PenunjangSingkat::all()->first();

        return view('admin/penunjang_singkat.index', compact('penunjangSingkat', 'session_user'));
    }

    public function update(Request $request, PenunjangSingkat $penunjangSingkat)
    {
        $validator = Validator::make($request->all(), [
            'teks' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/penunjang_singkat')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            PenunjangSingkat::where('id', $request->id)
                ->update([
                    'teks' => $request->teks,
                ]);
            return redirect('/admin/penunjang_singkat')->with('status', 'Profil Singkat Berhasil Diubah');
        }
    }
}
