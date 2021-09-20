@extends('layouts.template')
@section('content')
<title>Data Barang | Lelang</title>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
    </div>
    <div class="card-body">
        <form action="/ikan/update" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="">Nama</label>
                <input type="hidden" value="{{$ikan->id}}" name="id">
                <input type="text" name="nama_ikan" value="{{$ikan->nama_ikan}}" class="form-control"  required>
            </div>
            <div class="form-group">
                <label for="">Tanggal</label>
                <input type="date" name="tgl" class="form-control"  value="{{$ikan->tgl}}"  required>
            </div>
            <div class="form-group">
                <label for="">Harga Awal</label>
                <input type="number" name="harga_awal" class="form-control"  value="{{$ikan->harga_awal}}"  required>
            </div>
            <div class="form-group">
                <label for="">Gambar</label>
                <br>
                <img src="{{url('data_file/'.$ikan->gambar_ikan)}}" style="width:200px;height:200px">
                <br>
                <br>

                <input type="file" name="gambar_ikan" class="form-control" >
            </div>
            <div class="form-group">
                <label for="">Deskripsi</label>
                <input type="text" name="deskripsi_ikan" class="form-control"  value="{{$ikan->deskripsi_ikan}}" required>
            </div>
            <input type="submit" value="Update" class="btn btn-warning">
        </form>
    </div>
</div>


@endsection
