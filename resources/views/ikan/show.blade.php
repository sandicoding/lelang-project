@extends('layouts.template')
@section('content')
<title>Data Barang | Lelang</title>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detail</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <img src="{{url('data_file/'.$ikan->gambar_ikan)}}" style="width:300px;height:300px">
            </div>
            <div class="col-md-8">
                <table>
                    <tr>
                        <td>Nama Barang</td>
                        <td>:</td>
                        <td>{{$ikan->nama_ikan}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>{{$ikan->tgl}}</td>
                    </tr>
                    <tr>
                        <td>Harga Awal</td>
                        <td>:</td>
                        <td>{{$ikan->harga_awal}}</td>
                    </tr>
                    <tr>
                        <td>Deskripsi ikan</td>
                        <td>:</td>
                        <td>{{$ikan->deskripsi_ikan}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
