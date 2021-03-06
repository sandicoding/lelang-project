<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Auth;
use Validator;
use File;

class MenawarController extends Controller
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


    public function show($id)
    {

        $lelang = DB::table('lelang')->where('id_lelang',$id)
                ->join('tb_ikan',function($join){
                    $join->on('lelang.ikan_id','=','tb_ikan.id');
                })->first();

                $users= DB::table('users')->get();

        $penawaran = DB::table('history_lelang')->where('lelang_id',$id)->where('user_id',Auth::user()->id)->first();

        $data = DB::table('history_lelang')->where('lelang_id',$id)
                ->join('users',function($join){
                    $join->on('history_lelang.user_id','=','users.id');
                })
                ->join('tb_masyarakat',function($join){
                    $join->on('users.id','=','tb_masyarakat.id_masyarakat');
                })->get();

        return view('menawar/show',compact('lelang','users','penawaran','data'));
    }

    public function data()
    {

        $data = DB::table('history_lelang')->where('user_id',Auth::user()->id)
                ->join('users',function($join){
                    $join->on('history_lelang.user_id','=','users.id');
                })
                ->join('tb_masyarakat',function($join){
                    $join->on('users.id','=','tb_masyarakat.id_masyarakat');
                })
                ->join('lelang',function($join){
                    $join->on('history_lelang.lelang_id','=','lelang.id_lelang');
                })
                ->join('tb_ikan',function($join){
                    $join->on('lelang.ikan_id','=','tb_ikan.id');
                })->get();

        return view('menawar/data',compact('data'));
    }

    public function store(Request $request)
    {
        $cek = DB::table('lelang')->where('id_lelang',$request->lelang_id)
                ->join('tb_ikan',function($join){
                    $join->on('lelang.ikan_id','=','tb_ikan.id');
                })->first();

        if($request->penawaran_harga < $cek->harga_awal) {
            return redirect()->back()->with('gagal','Harga tidak boleh kurang dari harga awal');
        }else {
        DB::table('history_lelang')->insert([
            'lelang_id'=>$request->lelang_id,
            'user_id'=>Auth::user()->id,
            'penawaran_harga'=>$request->penawaran_harga,
            'status_lelang'=>'tunda'
        ]);

        return redirect()->back()->with('masuk','Data Berhasil Di Input');
        }
    }

    public function updateMenawar(Request $request, $id)
    {
        $cek = DB::table('lelang')->where('id_lelang',$request->lelang_id)
                ->join('tb_ikan',function($join){
                    $join->on('lelang.ikan_id','=','tb_ikan.id');
                })->first();

        if($request->penawaran_harga < $cek->harga_awal) {
            return redirect()->back()->with('gagal','Harga tidak boleh kurang dari harga awal');
        }else{
        DB::table('history_lelang')->where('id_history',$id)->update([
            'penawaran_harga'=>$request->penawaran_harga,
            'status_lelang'=>'tunda'
        ]);

        return redirect()->back()->with('masuk','Penawaran Berhasil diupdate !');
        }
    }



    public function edit($id)
    {

        $lelang = DB::table('lelang')->where('id_lelang',$id)
                ->join('tb_ikan',function($join){
                    $join->on('lelang.ikan_id','=','tb_ikan.id');
                })->first();

        $ikan = DB::table('tb_ikan')->get();

        return view('lelang/edit',compact('ikan','lelang'));
    }



    public function update(Request $request)
    {
        DB::table('lelang')->where('id_lelang',$request->id_lelang)->update([
            'ikan_id'=>$request->ikan_id,
            'tgl_lelang'=>$request->tgl_lelang,
            'status'=>$request->status,
        ]);

        return redirect('lelang')->with('update','Data Berhasil Di Update');
    }

}
