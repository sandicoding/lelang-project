@extends('layouts.template')
@section('content')
<title>Data Penawaran | Lelang</title>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Penawaran Lelang</h6>
    </div>
    <div class="card-body">
    <form action="{{ route('filter-ikan') }}" method="GET" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="">Lelang</label>
             <select name="ikan_id" class="select2 form-control" style="width:100%" required>
                <option value="" disabled selected>Pilih Lelang</option>
                @foreach($lelang as $b)
                @if($b->status == 'dibuka')
                <option value="{{$b->id_lelang}}">{{$b->nama_ikan}} Tanggal Tutup {{ $b->tgl_tutup }}</option>
                @else
                <option value="" disabled>Tidak Ada Lelang di buka</option>
                @endif
                @endforeach

            </select>
        </div>


        <button type="submit" class="btn btn-primary">Otomatis Pengecekan Pemenang</button>
    </form>
    {{-- <a href="{{ route('penawaran') }}" class="btn btn-warning"> Reset Filter </a> --}}
    </div>
    <div class="card-body">
    @if( Session::get('masuk') !="")
            <div class='alert alert-success'><center><b>{{Session::get('masuk')}}</b></center></div>
            @endif
        <table class="table table-bordered"  id="dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Ikan</th>
                    <th>Pembeli</th>
                    <th>No Telp</th>
                    <th>Harga Penawaran</th>
                    <th>Tanggal Buka</th>
                    <th>Tanggal tutup</th>

                    <th>Status</th>
                    <th>Ubah Status</th>
                </tr>
            </thead>
            <tbody>
            {{-- @empty($data) --}}
            @foreach ($data as $i => $u)
                <tr>
                    <td>{{++$i}}</td>
                    <td>{{$u->nama_ikan}}</td>
                    <td>{{$u->name}}</td>
                    <td>{{$u->telp}}</td>
                    <td>@currency($u->penawaran_harga)</td>
                    <td>{{$u->tgl_lelang}}</td>
                    <td>{{$u->tgl_tutup}}</td>
                    <td>{{$u->status_lelang}}</td>
                    @if($u->status_lelang == 'tunda')
                    <td><a href="/penawaran/status/{{$u->id_history}}" class="btn btn-success btn-sm" onclick="return confirm('Apakah anda yakin ?')">Pilih Jadi Pemenang</a></td>
                    @elseif($u->status_lelang == 'tidak_dipilih')
                    <td>Tidak Dipilih</td>
                    @else
                    <td>Terpilih</td>
                    @endif
                </tr>
                @endforeach
                {{-- @else
                <tr>
                    <td>tidak ada</td>
                </tr>
                @endempty --}}
            </tbody>
        </table>
    </div>
</div>

@endsection
