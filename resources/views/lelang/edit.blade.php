@extends('layouts.template')
@section('content')
<title>Data Lelang | Lelang</title>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('lelang-update')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="">Barang</label>
                <input type="hidden" name="id_lelang" value="{{$lelang->id_lelang}}">
                <select name="ikan_id" class="select2 form-control" style="width:100%" required>
                    <option value="" disabled selected>Pilih Barang</option>
                    @foreach($ikan as $b)
                    @if($lelang->ikan_id == $b->id)
                    <option value="{{$b->id}}" selected>{{$b->nama_ikan}}</option>
                    @else
                    <option value="{{$b->id}}">{{$b->nama_ikan}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">Tanggal Lelang</label>
                <input type="date" name="tgl_lelang" class="form-control" value="{{$lelang->tgl_lelang}}" required>
            </div>
            <div class="form-group">
                <label for="">Tanggal Tutup</label>
                <input type="date" name="tgl_tutup" class="form-control" value="{{$lelang->tgl_tutup}}" required>
            </div>
            <div class="form-group">
                <label for="">Status</label>
                <select name="status" class="form-control">
                    @if($lelang->status == 'dibuka')
                    <option value="{{$lelang->status}}" selected>Dibuka</option>
                    <option value="ditutup" >Ditutup</option>
                    @else
                    <option value="{{$lelang->status}}" >Dibuka</option>
                    <option value="ditutup" selected>Ditutup</option>
                    @endif
                </select>
            </div>
            <input type="submit" value="Update" class="btn btn-warning">
        </form>
    </div>
</div>


@endsection
