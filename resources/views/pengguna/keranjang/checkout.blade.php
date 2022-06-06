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
                    <div class="mb-4">
                        <h5 class="text-black mb-3">Pilih Alamat Pengiriman</h5>
                        <select class="form-control" name="alamat" id="select_alamat">
                            <option value="">Pilih Alamat</option>
                            <option value="1">Gunakan Alamat Pribadi</option>
                            <option value="2">+ Atur Alamat Baru</option>
                        </select>
                    </div>
                    <div id="personal_form" class="mt-3 d-none">
                        <?php
                            $akun_pengguna = DB::table('tbl_detail_pengguna')->where('id_pengguna', session('id_pengguna'))->first();
                            if(empty($akun_pengguna->id_kecamatan) || empty($akun_pengguna->alamat_rumah || empty($akun_pengguna->no_telepon))) {
                        ?>
                            <div class="alert alert-warning">
                                <b>Maaf!</b> Anda belum mengatur informasi dibawah ini antara lain <br>
                                - Alamat Rumah<br>
                                - Alamat Tambahan (Kecamatan)<br>
                                - No Telepon<br>
                            </div>
                        <?php } else {
                                $get_kecamatan = DB::table('tbl_kecamatan')->where('id', $personal->id_kecamatan)->first();
                                $get_kabupaten = DB::table('tbl_kabupaten')->where('id', $get_kecamatan->idkab)->first();
                                $get_provinsi = DB::table('tbl_provinsi')->where('id', $get_kabupaten->idprov)->first();

                                $name_kab = $get_kabupaten->tipe === "Kabupaten" ? 'Kabupaten ' . $get_kabupaten->nama : 'Kota ' . $get_kabupaten->nama;
                                $name_prov = 'Prov. ' . $get_provinsi->nama;
                                $name_kec = $get_kecamatan->nama;
                        ?>
                            <div class="alert alert-primary">
                                - Nama Lengkap : {{ $personal->nama_lengkap }}<br>
                                - Alamat Lengkap : {{ $personal->alamat_rumah }}<br>
                                - Nomer Telepon : {{ $personal->no_telepon }}<br>
                                - Tambahan : {{ 'Kec. ' . $name_kec . ', ' . $name_kab . ', ' . $name_prov}}<br>
                            </div>
                        <?php } ?>
                    </div>
                    <div id="manual_form" class="mt-3 d-none">
                        <div class="form-group row">
                            <div class="col-md-12 mb-2">
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
                            <div class="col-md-12 mb-2">
                                <h5 class="text-black">Pilih Tujuan Pengiriman</h5>
                            </div>
                            <div class="col-md-4">
                                <label for="inp_provinsi" class="text-black">Provinsi</label>
                                <select class="form-control" name="provinsi" id="provinsi"></select>
                            </div>
                            <div class="col-md-4">
                                <label for="inp_kota" class="text-black">Kota</label>
                                <select class="form-control" name="kabupaten" id="kabupaten"></select>
                            </div>
                            <div class="col-md-4">
                                <label for="inp_provinsi" class="text-black">Kecamatan</label>
                                <select class="form-control" name="kecamatan" id="kecamatan"></select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12 mb-2">
                            <h5 class="text-black">Atur Jasa Pengiriman</h5>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" name="kurir" id="kurir"></select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" name="layanan" id="layanan"></select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inp_keterangan" class="text-black">Catatan Pengiriman ( Optional )</label>
                        <textarea type="text" rows="4" name="keterangan" class="form-control"></textarea>
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

                            <div class="row">
                                <?php if(getSetting()['status_transfer'] == 1){ ?>
                                <div class="col-md-6">
                                    <div class="alert text-center text-white align-items-center alert-success bg-success manual" onclick="bayarManual()">
                                        <i class="cek fa fa-check-circle fs-24"></i>
                                        <img class="icon" style="width: 150px" src="<?= Storage::url('payment/transfer.png')?>" /><br/>
                                        Transfer Manual
                                    </div>
                                </div>
                                <?php } if(getSetting()['status_midtrans'] == 1){ ?>
                                <div class="col-md-6">
                                    <div class="alert text-center alert-primary bg-primary text-white align-items-center midtrans" onclick="bayarMidtrans()">
                                        <i class="cek fa fa-check-circle fs-24"></i>
                                        <img class="icon" style="width: 150px" src="<?= Storage::url('payment/midtrans.png')?>" /><br/>
                                        Virtual Account, E-Wallet, Minimarket, dll
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="border p-3 mb-3 payment-manual d-none">
                                <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsebank" role="button" aria-expanded="false" aria-controls="collapsebank">Transfer Bank</a></h3>

                                <div class="collapse show" id="collapsebank">
                                    <div class="py-2">
                                        <p class="mb-0 text-black">
                                            Silahkan Transfer Ke Rekening Di Bawah :<br>
                                            <?php
                                                foreach(DB::table('tbl_rekening')->where('is_active', 1)->get() as $rekening) {
                                                $detail_rek = DB::table('tbl_rekeningbank')->where('id', $rekening->id_bank)->first();
                                            ?>
                                                <div class="my-3 text-black alert alert-info mb-0">
                                                    <h6><?= $detail_rek->nama ?></h6>
                                                    <p style="margin-bottom: 0px">
                                                        - Atas Nama : <?= $rekening->atas_nama ?> <br>
                                                        - Nomer Rekening : <?= $rekening->nomer_rekening ?> <br>
                                                        - Kode Bank : <?= $detail_rek->kodebank ?> <br>
                                                    </p>
                                                </div>
                                            <?php } ?>
                                            <small>
                                                Untuk saat ini kami hanya menggunakan rekening yang tertera di atas, <br>
                                                jika anda transfer pembayaran selain menggunakan rekening di atas kami tidak bertanggung jawab.
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group d-none btn-transfer">
                                <input type="hidden" name="id_kec" id="id_kec" value="{{ !empty($get_kecamatan->id) ? $get_kecamatan->id : '' }}">
                                <input type="hidden" name="alamat" id="opsi_alamat">
                                <input type="hidden" name="ongkir" id="ongkos_kirim">
                                <input type="hidden" name="metode_pembayaran" id="metode">
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

        $('#select_alamat').change(function() {
            let opt = this.value;
            if(opt == 1) {
                $('#personal_form').removeClass('d-none');
                $('#manual_form').addClass('d-none');
                $('#opsi_alamat').val(1)

                $.get(url+'/get_kurir').done(function(result){
                    $('#kurir').html(result)
                })

                $('#kurir').change(function() {
                    let kurir = this.value;
                    if(kurir === "cod") {
                        $('#ongkir').html('Rp. <?= DB::table('tbl_website')->where('id', 17)->value('value') ?>')
                        $('#ongkos_kirim').val(<?= DB::table('tbl_website')->where('id', 17)->value('value') ?>)
                        $('#layanan').html('<option value="">-- tidak ditemukan layanan</option>')
                    } else {
                        $.get(url+'/get_layanan', {'id_kurir': kurir, 'berat': {{ $berat }}, 'id_kec': $('#id_kec').val()}).done(function(result){
                            if($.parseJSON(result)['rajaongkir']['status']['code'] == 200) {
                                var data = $.parseJSON(result)['rajaongkir']['results'][0]['costs']
                                var elemen = '<option value>Pilih Layanan...</option>'
                                for(var value of data){
                                    elemen += '<option value="'+value['cost'][0]['value']+','+value['service']+'">'+value['service']+' '+value['cost'][0]['etd']+' hari Rp. '+value['cost'][0]['value']+'</option>'
                                }
                                $('#layanan').html(elemen)

                                $('#layanan').change(function() {
                                    let values = this.value;
                                    let extract = values.split(',');
                                    let ongkirs = extract[0];
                                    $('#ongkir').html(`Rp. ${ongkirs}`)
                                    $('#ongkos_kirim').val(ongkirs)
                                });

                            } else {
                                alert('Terjadi Kesalahan Saat Menghubungi Server')
                            }
                        })
                    }
                })

            } else if(opt == 2) {
                $('#personal_form').addClass('d-none');
                $('#manual_form').removeClass('d-none');
                $('#opsi_alamat').val(2)

                $('#kurir').html('');

                $.get(url+'/get_prov').done(function(result){
                    $('select#provinsi').html(result)

                    $('#provinsi').change(function() {
                        let id_prov = this.value;
                        $.get(url+'/get_city?provinsi', {'provinsi': id_prov}).done(function(result){
                            $('select#kabupaten').html(result)

                            $('#kabupaten').change(function() {
                                let id_kab = this.value;
                                $.get(url+'/get_kec?kecamatan', {'kecamatan': id_kab}).done(function(result){
                                    $('select#kecamatan').html(result)

                                    $('#kecamatan').change(function() {
                                        let id_kec = this.value;
                                        $('#id_kec').val(id_kec);

                                        $.get(url+'/get_kurir').done(function(result){
                                            $('#kurir').html(result)

                                            $('#kurir').change(function() {
                                            let kurir = this.value;
                                            if(kurir === "cod") {
                                                $('#ongkir').html('Rp. <?= DB::table('tbl_website')->where('id', 17)->value('value') ?>')
                                                $('#ongkos_kirim').val(<?= DB::table('tbl_website')->where('id', 17)->value('value') ?>)
                                                $('#layanan').html('<option value="">-- tidak ditemukan layanan</option>')
                                            } else {
                                                $.get(url+'/get_layanan', {'id_kurir': kurir, 'berat': {{ $berat }}, 'id_kec': $('#id_kec').val()}).done(function(result){
                                                    if($.parseJSON(result)['rajaongkir']['status']['code'] == 200) {
                                                        var data = $.parseJSON(result)['rajaongkir']['results'][0]['costs']
                                                        var elemen = '<option value>Pilih Layanan...</option>'
                                                        for(var value of data){
                                                            elemen += '<option value="'+value['cost'][0]['value']+','+value['service']+'">'+value['service']+' '+value['cost'][0]['etd']+' hari Rp. '+value['cost'][0]['value']+'</option>'
                                                        }
                                                        $('#layanan').html(elemen)

                                                        $('#layanan').change(function() {
                                                            let values = this.value;
                                                            let extract = values.split(',');
                                                            let ongkirs = extract[0];
                                                            $('#ongkir').html(`Rp. ${ongkirs}`)
                                                            $('#ongkos_kirim').val(ongkirs)
                                                        });

                                                    } else {
                                                        alert('Terjadi Kesalahan Saat Menghubungi Server')
                                                    }
                                                })
                                            }
                                        })

                                        })

                                    })
                                })
                            })
                        })
                    })
                })

            }
        })
        $('#inp_provinsi').click(() => {
            var results = $('#inp_provinsi').find(':selected').val()
            $.get(url+'/get_kota?provinsi', {'provinsi': results}).done(function(result){
                if($.parseJSON(result)['rajaongkir']['status']['code'] == 200) {
                    var data = $.parseJSON(result)['rajaongkir']['results']
                    var elemen = '<option value>Pilih Kota...</option>'
                    $('#inp_kota').html('')
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

    function bayarManual()
    {
        $('.btn-transfer').removeClass('d-none');
        $('#metode').val(1)
    }
</script>
@endsection
