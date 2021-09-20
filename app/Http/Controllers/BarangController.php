<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

use Validator;
use File;

class BarangController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {

        $ikan = DB::table('tb_ikan')->get();
        return view('ikan/index',compact('ikan'));
    }

    public function store(Request $request)
    {
        $cekgambar_ikan = Validator::make($request->all(), [
            'gambar_ikan' => 'required|file|image|mimes:jpeg,png,jpg|max:10000',
        ]);

        if ($cekgambar_ikan->fails()) {
            return redirect()->back()->with('gagal', 'Gagal Upload, File harus berbentuk jpg/png/jpeg ');
        }

        $gambar_ikan = $request->file('gambar_ikan');
        $size = $gambar_ikan->getSize();
        $nama_gambar_ikan = time() . "_" . $gambar_ikan->getClientOriginalName();
        $tujuan_upload_gambar_ikan = 'data_file';
        $gambar_ikan->move($tujuan_upload_gambar_ikan, $nama_gambar_ikan);

        DB::table('tb_ikan')->insert([
            'nama_ikan'=>$request->nama_ikan,
            'tgl'=>$request->tgl,
            'harga_awal'=>$request->harga_awal,
            'gambar_ikan'=>$nama_gambar_ikan,
            'deskripsi_ikan'=>$request->deskripsi_ikan
        ]);

        return redirect()->back()->with('masuk','Data Berhasil Di Input');
    }

    public function edit($id)
    {
        $ikan = DB::table('tb_ikan')->where('id',$id)->first();
        return view('ikan/edit',compact('ikan'));
    }

    public function show($id)
    {
        $ikan = DB::table('tb_ikan')->where('id',$id)->first();
        return view('ikan/show',compact('ikan'));
    }

    public function update(Request $request)
    {
        if($request->gambar_ikan == null){
            DB::table('tb_ikan')->where('id',$request->id)->update([
                'nama_ikan'=>$request->nama_ikan,
                'tgl'=>$request->tgl,
                'harga_awal'=>$request->harga_awal,
                'deskripsi_ikan'=>$request->deskripsi_ikan
            ]);
        }
        else
        {

            $cekgambar_ikan = Validator::make($request->all(), [
                'gambar_ikan' => 'required|file|image|mimes:jpeg,png,jpg|max:10000',
            ]);

            if ($cekgambar_ikan->fails()) {
                return redirect()->back()->with('gagal', 'Gagal Upload, File harus berbentuk jpg/png/jpeg ');
            }

            $gambar_ikan = $request->file('gambar_ikan');
            $size = $gambar_ikan->getSize();
            $nama_gambar_ikan = time() . "_" . $gambar_ikan->getClientOriginalName();
            $tujuan_upload_gambar_ikan = 'data_file';
            $gambar_ikan->move($tujuan_upload_gambar_ikan, $nama_gambar_ikan);

        DB::table('tb_ikan')->where('id',$request->id)->update([
            'nama_ikan'=>$request->nama_ikan,
            'tgl'=>$request->tgl,
            'harga_awal'=>$request->harga_awal,
            'gambar_ikan'=>$nama_gambar_ikan,
            'deskripsi_ikan'=>$request->deskripsi_ikan
        ]);
    }

        return redirect('ikan')->with('update','Data Berhasil Di Update');
    }


    public function delete($id)
    {
        $ikan = DB::table('tb_ikan')->where('id',$id)->delete();
        return redirect('ikan')->with('gagal','Data Berhasil Di delete');
    }


}
