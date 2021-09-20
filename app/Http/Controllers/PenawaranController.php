<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Auth;
use Validator;
use File;

class PenawaranController extends Controller
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


    public function index(Request $request)
    {

        //     $data = DB::table('history_lelang')
        //         ->join('users',function($join){
        //             $join->on('history_lelang.user_id','=','users.id');
        //         })
        //         ->join('tb_masyarakat',function($join){
        //             $join->on('users.id','=','tb_masyarakat.id_masyarakat');
        //         })
        //         ->join('lelang',function($join){
        //             $join->on('history_lelang.lelang_id','=','lelang.id_lelang');
        //         })
        //         ->join('ikan',function($join){
        //             $join->on('lelang.ikan_id','=','ikan.id');
        //         })->where('status_lelang', '=', 'tunda' || 'id', '=', $request->id )->get();





        // return view('penawaran/index',compact('data'));


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


                $lelang = DB::table('lelang')
                ->join('tb_ikan',function($join){
                    $join->on('lelang.ikan_id','=','tb_ikan.id');
                })->get();






        return view('penawaran/index',compact(['data', 'lelang']));
    }

    public function filter(Request $request)
    {
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
                })->where('status_lelang', '=', 'tunda' )->where('lelang_id', $request->ikan_id)->get();

            $data_max = DB::table('history_lelang')
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
                })->where('status_lelang', '=', 'tunda' )->where('lelang_id', $request->ikan_id)->max('penawaran_harga');

                $lelang = DB::table('lelang')
                ->join('tb_ikan',function($join){
                    $join->on('lelang.ikan_id','=','tb_ikan.id');
                })->get();

                // dd($data[0]->status);



                if($data[0]->tgl_tutup === date("Y-m-d"))
                {
                    if(!$data_max == null){
                         DB::table('history_lelang')->where('penawaran_harga',$data_max)->update([
                            'status_lelang' =>'dipilih'
                        ]);

                        $cek = DB::table('history_lelang')->where('penawaran_harga',$data_max)->first();

                        $id_lelang = $cek->lelang_id;

                        DB::table('history_lelang')->where('lelang_id',$id_lelang)->where('status_lelang','tunda')->update([
                            'status_lelang' =>'tidak_dipilih'
                        ]);

                        $ceklagi=DB::table('history_lelang')->where('penawaran_harga',$data_max)->first();

                        DB::table('lelang')->where('id_lelang',$id_lelang)->update([
                            'harga_akhir'=>$ceklagi->penawaran_harga,
                            'lelang_masyarakat_id'=>$ceklagi->user_id,
                            'status'=>'ditutup'
                        ]);

                         return redirect()->back()->with('masuk','Pemilihan Otomatis Berhasil');
                    }

                    echo date("Y-m-d");
                }

                echo 'lewat kondisi';





        return view('penawaran/index',compact(['data', 'lelang']));
    }

    public function status($id)
    {

        DB::table('history_lelang')->where('id_history',$id)->update([
            'status_lelang' =>'dipilih'
        ]);

        $cek = DB::table('history_lelang')->where('id_history',$id)->first();

        $id_lelang = $cek->lelang_id;

        DB::table('history_lelang')->where('lelang_id',$id_lelang)->where('status_lelang','tunda')->update([
            'status_lelang' =>'tidak_dipilih'
        ]);

        $ceklagi=DB::table('history_lelang')->where('id_history',$id)->first();

        DB::table('lelang')->where('id_lelang',$id_lelang)->update([
            'harga_akhir'=>$ceklagi->penawaran_harga,
            'lelang_masyarakat_id'=>$ceklagi->user_id,
            'status'=>'ditutup'
        ]);

        return redirect()->back()->with('masuk','Data Berhasil Di Rubah');


    }

}
