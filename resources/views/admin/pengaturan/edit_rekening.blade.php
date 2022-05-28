@extends('admin.master')

@section('title', 'Edit Rekening')

@section('extra_css')

    {{ Html::style('admin_assets/component/datatables.net-bs/css/dataTables.bootstrap.min.css') }}

@endsection

@section('content-header')
<h1>
    Edit Rekening
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li><i class="fa fa-cubes fa-fw"></i> Rekening</li>
    <li class="active"><i class="fa fa-tags fa-fw"></i> Edit Rekening</li>
</ol>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> ERROR!</h4>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </div>
        @elseif (session()->has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">
                    Edit
                </h3>
            </div>
            <div class="box-body">
            {!! Form::open(['route' => 'pengaturan']) !!}
            @csrf
            <div class="form-group has-feedback">
                {!! Form::label('exampleEmail1', 'Atas Nama') !!}
                {!! Form::hidden('tipe', 5) !!}
                {!! Form::hidden('id_rekening', $detail->id) !!}
                {!! Form::text('atas_nama',  $detail->atas_nama, ['id' => 'atas_nama', 'class' => 'form-control']) !!}
                <span class="help-block"><small>Masukan atas nama tanpa karakter khusus</small></span>
            </div>
            <div class="form-group has-feedback">
                {!! Form::label('exampleEmail1', 'Nomor Rekening') !!}
                {!! Form::text('nomer_rekening',  $detail->nomer_rekening, ['id' => 'nomer_rekening', 'class' => 'form-control']) !!}
                <span class="help-block"><small>Masukan nomer rekening tanpa karakter khusus</small></span>
            </div>
            <div class="form-group has-feedback">
                {!! Form::label('exampleEmail1', 'Pilih Kategori Bank') !!}
                <select name="id_bank" id="id_bank" class="form-control">
                    <option value="">=== PILIH BANK ===</option>
                    <?php foreach($rekening as $items) { 
                        $select = $items->id == $detail->id_bank ? 'selected' : '';    
                        $selected = $items->id == $detail->id_bank ? '(selected)' : '';    
                    ?>
                        <option value="{{ $items->id }}" {{ $select }}>{{ $items->nama }} {{ $selected }}</option>
                    <?php } ?>
                </select>
                <span class="help-block"><small>Silahkan pilih kategori bank yang sesuai</small></span>
            </div>
            <div class="form-group has-feedback">
                {!! Form::label('exampleEmail1', 'Status Aktif') !!}
                <select name="is_active" id="is_active" class="form-control">
                    <option value="">=== STATUS ===</option>
                    <?php $lists = [0,1]; foreach($lists as $item) { 
                        $select = $item == $detail->is_active ? 'selected' : '';    
                        $selected = $item == $detail->is_active ? '(selected)' : '';
                        $names = $item == 1 ? 'Aktif' : 'Tidak Aktif';
                    ?>
                        <option value="{{ $item }}" {{ $select }}>{{ $names }} {{ $selected }}</option>
                    <?php } ?>
                </select>
                <span class="help-block"><small>Silahkan pilih status</small></span>
            </div>
            <div class="form-group has-feedback">
                <button type="submit" name="simpan" value="true" class="btn btn-primary btn-flat">Edit</button>
                <button class="btn btn-danger btn-flat">Kembali</button>
            </div>
        </div>
        {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_js')

    {{ Html::script('admin_assets/component/datatables.net/js/jquery.dataTables.min.js') }}
    {{ Html::script('admin_assets/component/datatables.net-bs/js/dataTables.bootstrap.min.js') }}

    <script>
        $(document).ready(function() {
            $('#table_merk').DataTable({
                'lengthChange': false,
                'length': 10,
                'searching': false
            })
        })
    </script>

@endsection