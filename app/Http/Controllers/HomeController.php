<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
class HomeController extends Controller
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
        if(Auth::user()->level == 'masyarakat'){

        $lelang = DB::table('lelang')->where('status','dibuka')
                ->join('tb_ikan',function($join){
                    $join->on('lelang.ikan_id','=','tb_ikan.id');
                })->get();

        return view('home2',compact('lelang'));
    }
    else{

        $jumlah_petugas=DB::table('tb_petugas')->count();
        $jumlah_ikan=DB::table('tb_ikan')->count();
        $jumlah_lelang=DB::table('lelang')->count();
        $jumlah_penawar=DB::table('history_lelang')->count();

        $data = DB::table('history_lelang')
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


        return view('home',compact('jumlah_petugas','jumlah_ikan','jumlah_lelang','jumlah_penawar','data'));
    }
    }
}
