<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Auth;
use Validator;
use File;

class LelangController extends Controller
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

        $lelang = DB::table('lelang')
                ->join('tb_ikan',function($join){
                    $join->on('lelang.ikan_id','=','tb_ikan.id');
                })->get();

        $ikan = DB::table('tb_ikan')->get();

        $users=DB::table('users')->get();

        return view('lelang/index',compact('lelang','ikan','users'));
    }

    public function store(Request $request)
    {
        $cek = DB::table('lelang')->where('ikan_id',$request->ikan_id)->where('status','dibuka')
                ->join('tb_ikan',function($join){
                    $join->on('lelang.ikan_id','=','tb_ikan.id');
                })->get();
        $cek2=count($cek);

        if($cek2 == 1){
        return redirect()->back()->with('gagal','Data tersebut sudah di lelang');

        }else{

        DB::table('lelang')->insert([
            'ikan_id'=>$request->ikan_id,
            'tgl_lelang'=>$request->tgl_lelang,
            'tgl_tutup' => $request->tgl_tutup,
            'lelang_petugas_id'=>Auth::user()->id,
        ]);

        return redirect()->back()->with('masuk','Data Berhasil Di Input');
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

    public function show($id)
    {
        $lelang = DB::table('lelang')->where('id_lelang',$id)
            ->join('tb_ikan',function($join){
                $join->on('lelang.ikan_id','=','tb_ikan.id');
            })->first();

        $users=DB::table('users')->get();

        $data = DB::table('history_lelang')->where('lelang_id',$id)
                ->join('users',function($join){
                    $join->on('history_lelang.user_id','=','users.id');
                })
                ->join('tb_masyarakat',function($join){
                    $join->on('users.id','=','tb_masyarakat.id_masyarakat');
                })->get();

        return view('lelang/show',compact('lelang','users','data'));
    }

    public function update(Request $request)
    {
        DB::table('lelang')->where('id_lelang',$request->id_lelang)->update([
            'ikan_id'=>$request->ikan_id,
            'tgl_lelang'=>$request->tgl_lelang,
            'tgl_tutup'=>$request->tgl_tutup,
            'status'=>$request->status,
        ]);

        return redirect('lelang')->with('update','Data Berhasil Di Update');
    }

}
