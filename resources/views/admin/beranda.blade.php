@extends('admin.master')

@section('title', 'Beranda')

@section('content-header')
<h1>
    Beranda
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-home"></i> Beranda</a></li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>
                    {{ Rupiah::create($pendapatan_sekarang) }}
                    {{-- @if($pendapatan_kemarin != 0)
                        @if($pendapatan_sekarang < $pendapatan_kemarin)
                            <small><i class="fa fa-arrow-down text-red"></i> <span class="text-white">{{ $pendapatan_sekarang / $pendapatan_kemarin * 100 - 100 }}%</span></small>
                        @elseif($pendapatan_sekarang > $pendapatan_kemarin)
                            <small><i class="fa fa-arrow-up text-green"></i> <span class="text-white">{{ $pendapatan_sekarang / $pendapatan_kemarin * 100 }}%</span></small>
                        @else
                            -
                        @endif
                    @endif --}}
                </h3>

                <p>Transaksi Masuk</p>
            </div>
            <div class="icon">
                <i class="fa fa-money"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>{{ Rupiah::create($pendapatan_kemarin) }}</h3>

                <p>Transaksi Keluar</p>
            </div>
            <div class="icon">
                <i class="fa fa-money"></i>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $stok_mentah }}</h3>
                <p>Stok Mentah</p>
            </div>
            <a href="{{ route('list_stok') }}" class="small-box-footer">
                selengkapnya <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $stok_setengah }}</h3>
                <p>Stok Setengah Jadi</p>
            </div>
            <a href="{{ route('list_stok') }}" class="small-box-footer">
            selengkapnya <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $stok_jadi }}</h3>
                <p>Stok Jadi</p>
            </div>
            <a href="{{ route('list_stok') }}" class="small-box-footer">
                selengkapnya <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $barang }}</h3>
                <p>Produk</p>
            </div>
            <a href="{{ route('list_produk') }}" class="small-box-footer">
                selengkapnya <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
            <div class="callout callout-info">
                <h4><i class="fa fa-bullhorn fa-fw"></i> Informasi!!</h4>
                <p>
                    Selamat Datang di Halaman Administrator {{ DB::table('tbl_website')->where('id', 1)->value('value') }}
                </p>
            </div>
    </div>
</div>
@endsection