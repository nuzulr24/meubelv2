@extends('pengguna.master')

@section('title', 'Checkout')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade-up" data-aos-delay="100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="mx-2 mb-0">/</span>
                <a href="{{ route('keranjang') }}">Keranjang</a>
                <span class="mx-2 mb-0">/</span>
                <strong class="text-black">Checkout</strong>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="site-section">
    <div class="container">
        <div class="col-md-12">
            @if ($errors->any())

                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="icon-ban"></i> ERROR!!</strong><br>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            @elseif(session()->has('success'))

                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><i class="fa fa-ban fa-fw"></i> SUCCESS!!</strong> {{ session('success') }} <br>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            @endif
        </div>
        {{ Form::open(['route' => 'save_checkout', 'class' => 'row']) }}
            <div class="col-md-12 mb-4"><a href="{{ route('keranjang') }}" class="btn btn-outline-info">Kembali</a></div>
            <div class="col-md-6 mb-5 mb-md-0">
                <h2 class="h3 mb-3 text-black">Detail Pengiriman</h2>
                <div class="p-3 p-lg-5 border">

                    <div class="form-group row">
                        <div class="col-md-12">
                            <h5 class="text-black">Informasi Penerima</h5>
                        </div>
                        <div class="col-md-12">
                            <label for="inp_nama_penerima" class="text-black">Nama Lengkap <span class="text-danger">*</span></label>
                            {{ Form::text('nama_penerima', !empty($default) ?  $default->nama_lengkap : null, [
                                'class'         => 'form-control',
                                'id'            => 'inp_nama_penerima',
                                'placeholder'   => 'Nama Penerima'
                            ]) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="inp_no_telepon" class="text-black">No Telepon <span class="text-danger">*</span></label>
                            {{ Form::text('no_telepon', !empty($default) ?  $default->no_telepon : null, [
                                'class'         => 'form-control',
                                'id'            => 'inp_no_telepon',
                                'placeholder'   => 'No. Telepon Penerima'
                            ]) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="inp_alamat_tujuan" class="text-black">Alamat <span class="text-danger">*</span></label>
                            {{ Form::textarea('alamat_tujuan', !empty($default) ?  $default->alamat_rumah : null, [
                                'class'         => 'form-control',
                                'id'            => 'inp_alamat_tujuan',
                                'rows'          => '5',
                                'placeholder'   => 'Tulis Alamat Tujuan'
                            ]) }}
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-md-12">
                            <h5 class="text-black">Pilih Tujuan Pengiriman</h5>
                        </div>
                        <div class="col-md-6">
                            <label for="inp_provinsi" class="text-black">Provinsi</label>
                            <select class="form-control" name="provinsi" id="inp_provinsi"></select>
                        </div>
                        <div class="col-md-6">
                            <label for="inp_kota" class="text-black">Kota</label>
                            <select class="form-control" name="kota" id="inp_kota"></select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="inp_layanan" class="text-black">Service</label>
                            <select class="form-control" name="layanan" id="inp_layanan"></select>
                            <input type="hidden" name="service">
                            <input type="hidden" name="destinasi">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <h5 class="text-black">Informasi Transfer Bank</h5>
                        </div>
                        <div class="col-md-4">
                            <label for="inp_bank" class="text-black">Nama Bank</label>
                            <select class="form-control" name="bank" id="bank">
                                <option value>Pilih Bank...</option>
                                <option value="Mandiri">Mandiri</option>
                                <option value="BCA">BCA</option>
                                <option value="MEGA">MEGA</option>
                                <option value="BNI">BNI</option>
                                <option value="BRI">BRI</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="inp_atas_nama" class="text-black">Atas Nama</label>
                            <input type="text" name="atas_nama" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="inp_atas_nama" class="text-black">No. Rekening</label>
                            <input type="text" name="no_rekening" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inp_keterangan" class="text-black">Catatan Pengiriman ( Optional )</label>
                        <input type="text" name="keterangan" class="form-control">
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="row mb-5">
                    <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black">Detail Tagihan</h2>
                        <div class="p-3 p-lg-5 border">
                            <table class="table site-block-order-table mb-5">
                                <thead>
                                    <th>Product</th>
                                    <th>Total</th>
                                </thead>
                                <tbody id="detail_pesanan">
                                    <?php $biaya = 0; $berat = 0; $total_berat = 0;?>
                                    @foreach ($data_checkout as $item)
                                    <?php $total_berat = $item->berat_barang * $item->jumlah_beli; ?>
                                        <tr>
                                            <td>
                                                {{ $item->nama_barang }} <strong class="mx-2">x</strong> {{ $item->jumlah_beli }}<br>
                                                <small>Berat : {!! $item->berat_barang.'gram - <strong>Total Berat : '.$total_berat.'gram</strong>' !!}</small>
                                            </td>
                                            <td>{{ Rupiah::create($item->subtotal_biaya) }}</td>
                                        </tr>
                                        <?php $biaya += $item->subtotal_biaya; $berat += $total_berat; ?>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Subtotal Berat</th>
                                        <th id="berat">{{ $berat.'gram' }}</th>
                                    </tr>
                                    <tr>
                                        <th>Subtotal Biaya</th>
                                        <th data-biaya="{{ $biaya }}" id="biaya">{{ Rupiah::create($biaya) }}</th>
                                    </tr>
                                    <tr>
                                        <th>Ongkos Kirim</th>
                                        <th id="ongkir"></th>
                                    </tr>
                                </tfoot>
                            </table>

                            <div class="border p-3 mb-3">
                                <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsebank" role="button" aria-expanded="false" aria-controls="collapsebank">Transfer Bank</a></h3>

                                <div class="collapse show" id="collapsebank">
                                    <div class="py-2">
                                        <p class="mb-0 text-black">
                                            Silahkan Transfer Ke Rekening Di Bawah :<br>
                                            {{ Html::image(asset('user_assets/images/mandiri_logo.jpg')) }} 12345678910 a/n nanda nurjanah<br><br>
                                            <small>
                                                Untuk saat ini kami hanya menggunakan rekening yang tertera di atas, <br>
                                                jika anda transfer pembayaran selain menggunakan rekening di atas kami tidak bertanggung jawab.
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" id="simpan" name="simpan" value="true" class="btn btn-primary btn-lg py-3 btn-block">Proses Pesanan</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        {{ Form::close() }}
        <!-- </form> -->
     </div>
</div>
@endsection

@section('custom_js')
<script type="text/javascript">
    $(document).ready(function(){
        var url = 'http://'+window.location.host
        $.get(url+'/get_provinsi').done(function(result){
            if($.parseJSON(result)['rajaongkir']['status']['code'] == 200) {
                var data = $.parseJSON(result)['rajaongkir']['results']
                var elemen = '<option value>Pilih Provinsi...</option>'
                for(var value of data){
                    elemen += '<option value="'+value['province_id']+'">'+value['province']+'</option>'
                }
                $('select#inp_provinsi').append(elemen)
            } else {
                alert('Terjadi Kesalahan Saat Menghubungi Server')
            }
        })
        $('#inp_provinsi').click(() => {
            var results = $('#inp_provinsi').find(':selected').val()
            $.get(url+'/get_kota?provinsi', {'provinsi': results}).done(function(result){
                if($.parseJSON(result)['rajaongkir']['status']['code'] == 200) {
                    var data = $.parseJSON(result)['rajaongkir']['results']
                    var elemen = '<option value>Pilih Kota...</option>'
                    $('#inp_kota').html(' ')
                    for(var value of data){
                        if(value['type'] == "Kota") {
                            elemen += '<option value="'+value['city_id']+'">Kota. '+value['city_name']+'</option>'
                        } else {
                            elemen += '<option value="'+value['city_id']+'">Kab. '+value['city_name']+'</option>'
                        }
                    }
                    $('select#inp_kota').append(elemen)
                } else {
                    alert('Terjadi Kesalahan Saat Menghubungi Server')
                }
            })
        })
        $('#inp_kota').click(() => {
            var kota = $('#inp_kota').find(':selected').val()
            var berat = {{ $berat }}
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $.post(url+'/get_cost', {'kota': kota, 'berat': berat}).done(function(result){
                if($.parseJSON(result)['rajaongkir']['status']['code'] == 200) {
                    var data = $.parseJSON(result)['rajaongkir']['results'][0]['costs']
                    var elemen = '<option value>Pilih Service...</option>'
                    $('#inp_layanan').html(' ')
                    for(var value of data){
                        elemen += '<option data-layanan="'+value['service']+'" value="'+value['cost'][0]['value']+'">'+value['service']+' '+value['cost'][0]['etd']+' hari Rp. '+value['cost'][0]['value']+'</option>'
                    }
                    $('select#inp_layanan').append(elemen)
                } else {
                    alert('Terjadi Kesalahan Saat Menghubungi Server')
                }
            })
        })
        $('#inp_layanan').click(() => {
            $('th#ongkir').html('Rp. '+$('#inp_layanan').find(':selected').val())
            $('input[name="service"]').val($('#inp_layanan').find(':selected').attr('data-layanan'))
            $('input[name="destinasi"]').val(
                $('#inp_kota').find(':selected').html()+", "+$('#inp_provinsi').find(':selected').html()
            )
        })
    })
</script>
@endsection
