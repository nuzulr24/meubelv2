@extends('admin.master')

@section('title', 'Pengaturan')

@section('extra_css')

{{ Html::style('admin_assets/component/datatables.net-bs/css/dataTables.bootstrap.min.css') }}

@endsection

@section('content-header')
<h1>
    Pengaturan
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li><i class="fa fa-cubes fa-fw"></i> Pengaturan</li>
    <li class="active"><i class="fa fa-clipboard fa-fw"></i> Website</li>
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
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-info-circle">&nbsp;</i> Umum</a></li>
                <li><a href="#tab_2" data-toggle="tab"><i class="fa fa-credit-card">&nbsp;</i> Pembayaran</a></li>
                <li><a href="#tab_3" data-toggle="tab"><i class="fa fa fa-truck">&nbsp;</i> Kurir</a></li>
                <li><a href="#tab_5" data-toggle="tab"><i class="fa fa fa-list">&nbsp;</i> Rekening</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                {!! Form::open(['route' => 'edit_pengaturan', 'files' => true]) !!}
                    @csrf
                    <input type="hidden" name="tipe" value="1"/>
                    <div class="form-group">
                        <label class="mb-2" for="exampleEmail1">Nama Toko</label>
                        <input type="text" class="form-control" name="title" required placeholder="Nama Toko"
                            value="{{ $detail['title'] }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-2" for="exampleEmail1">Meta Description</label>
                                <textarea rows="4" required style="resize: none"
                                    class="form-control" name="meta_description"
                                    placeholder="Meta Description">{{ $detail['meta_description'] }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-2" for="exampleEmail1">Meta Keyword</label>
                                <textarea rows="4" required style="resize: none"
                                    class="form-control" name="meta_keywords"
                                    placeholder="Meta Keywords">{{ $detail['meta_keywords'] }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="mb-2" for="exampleEmail1">Kota (pengiriman)</label>
                        <select class="form-control" name="kota" required>
                            <?php foreach($detail['list_kota'] as $kabupaten) { 
                                $selected = $kabupaten->id == $detail['kota'] ? 'selected' : '';
                            ?>
                            <option value="<?= $kabupaten->id ?>" <?= $selected ?>><?= $kabupaten->nama ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-2" for="exampleEmail1">Nomer Telepon</label>
                                <input type="telp" class="form-control" name="phone" required placeholder="Nomer Telepon"
                                    value="{{ $detail['phone'] }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-2" for="exampleEmail1">Alamat Toko</label>
                                <input type="text" class="form-control" name="address" required placeholder="Alamat Toko"
                                    value="{{ $detail['address'] }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-2" for="exampleEmail1">Facebook</label>
                                <input type="text" class="form-control" name="facebook" required placeholder="Link Facebook"
                                    value="{{ $detail['facebook'] }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-2" for="exampleEmail1">Alamat Email</label>
                                <input type="email" class="form-control" name="email" required placeholder="Alamat Toko"
                                    value="{{ $detail['email'] }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            {!! Form::label('exampleFoto', 'Logo Website') !!}
                            {!! Form::file('logo_image', ['id' => 'logo_image', 'class' => 'form-control' , 'style' => 'border: none;', 'accept' => '.jpg, .jpeg, .png']) !!}
                            </div>
                            <?php if(empty($detail['logo'])) { ?>
                                <p class="small" style="margin-bottom: 0.76rem">tidak ditemukan logo</p>
                            <?php } else { ?>
                                <p class="small"><a style="color: black" href='<?= Storage::url("images/" . $detail['logo']) ?>'>klik gambar disini</a></p>
                            <?php } ?>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            {!! Form::label('exampleFoto', 'Favicon') !!}
                            {!! Form::file('favicon_image', ['id' => 'favicon_image', 'class' => 'form-control' , 'style' => 'border: none;', 'accept' => '.jpg, .jpeg, .png']) !!}
                            </div>
                            <?php if(empty($detail['favicon'])) { ?>
                                <p class="small" style="margin-bottom: 0.76rem">tidak ditemukan favicon</p>
                            <?php } else { ?>
                                <p class="small"><a style="color: black" href='<?= Storage::url("images/" . $detail['favicon']) ?>'>klik gambar disini</a></p>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-2" for="exampleEmail1">Ringkasan Singkat</label>
                                <textarea rows="4" style="resize: none" class="form-control" name="short_description"
                                    placeholder="Short Description">{{ $detail['short_description'] }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                                <label class="mb-2" for="exampleEmail1">Jam Kerja</label>
                                <textarea rows="4" style="resize: none" class="form-control" name="jam_kerja"
                                    placeholder="Jam Kerja">{{ $detail['jam_kerja'] }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="mb-2" for="exampleEmail1">Tentang Toko</label>
                        <textarea rows="4" required id="about" class="form-control" name="about"
                            placeholder="Tentang Toko">{{ $detail['about'] }}</textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-primary">Perbarui</button>
                    </div>
                {!! Form::close() !!}
                </div>

                <div class="tab-pane" id="tab_2">
                    <div style="margin-bottom: 1.5rem; margin-top: 1.5rem;">
                        <span class="fa fa-info-circle fs-20 text-primary"></span> &nbsp;untuk mengaktifkan atau menonaktifkan metode pembayaran, klik tombol dibawahnya
                    </div>
                    <style rel="stylesheet">
                        .op5{-webkit-filter: grayscale(100%);filter: grayscale(100%);}
                        .kurir:hover .imgk{
                            border-color:#00cc00;
                            -webkit-filter: none;
                            filter: none;
                        }
                        .imgk{
                            border-radius: 4px;
                        }
                        .bgijo{
                            background:#27ae60;
                        }
                        .bg1{
                            background:#2980b9;
                        }
                        .bg2{
                            background:#89c9eb;
                        }
                    </style>
                    <div class="p-tb-10">
                        <div class="row m-lr-0 m-b-30">
                            <div class="col-md-3 col-6 p-lr-5 m-b-30">
                                <div class="imgk p-all-20 bgijo">
                                    <img class="img-responsive" src="<?= Storage::url('payment/transfer.png') ?>" />
                                </div>
                                <div class="btn-group g-transfer col-12" style="margin-top: 10px" role="group">
                                    <?php 
                                        $setaktif = ($payment_options['status_transfer'] == 1) ? "btn-success" : "btn-light";
                                        $setnonaktif = ($payment_options['status_transfer'] == 0) ? "btn-danger" : "btn-light";
                                    ?>
                                    <button id="aktifnotif" onclick="saveManual(1)" type="button" style="border: 1px solid #bbb;" class="col-6 btn btn-sm <?=$setaktif?>"><b>AKTIF</b></button>
                                    <button id="matinotif" onclick="saveManual(0)" type="button" style="border: 1px solid #bbb;" class="col-6 btn btn-sm <?=$setnonaktif?>"><b>NON AKTIF</b></button>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 p-lr-5 m-b-30">
                                <div class="imgk p-all-20 bg2">
                                    <img class="img-responsive" src="<?= Storage::url('payment/midtrans.png') ?>" />
                                </div>
                                <div class="btn-group g-midtrans col-12" style="margin-top: 10px" role="group">
                                    <?php 
                                        $setaktif = ($payment_options['status_midtrans'] == 1) ? "btn-success" : "btn-light";
                                        $setnonaktif = ($payment_options['status_midtrans'] == 0) ? "btn-danger" : "btn-light";
                                    ?>
                                    <button id="aktifnotifm" onclick="saveMidtrans(1)" type="button" style="border: 1px solid #bbb;" class="col-6 btn btn-sm <?=$setaktif?>"><b>AKTIF</b></button>
                                    <button id="matinotifm" onclick="saveMidtrans(0)" type="button" style="border: 1px solid #bbb;" class="col-6 btn btn-sm <?=$setnonaktif?>"><b>NON AKTIF</b></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 40px">
                        <div style="margin-bottom: 10px">
                            <b style="font-weight: bold; margin-top: 10px">Payment Gateway API</b><br/>
                            <small>
                                untuk mengatur konfigurasi pembayaran otomatis midtrans
                            </small>
                        </div>
                        <hr>
                        {!! Form::open(['route' => 'edit_pengaturan', 'files' => true]) !!}
                        <div class="form-group" style="margin-bottom: 1rem">
                            <label>Midtrans Server Key</label>
                            <input type="hidden" name="tipe" value="2"/>
                            <input type="text" class="form-control" required value="<?= $payment_options['midtrans_server'] ?>" name="midtrans_server" />
                        </div>
                        <div class="form-group" style="margin-bottom: 1rem">
                            <label>Midtrans Client Key</label>
                            <input type="text" class="form-control" required value="<?= $payment_options['midtrans_client'] ?>" name="midtrans_client" />
                        </div>
                        <div class="form-group" style="margin-bottom: 1rem">
                            <label>Midtrans Snap</label>
                            <input type="text" class="form-control" required value="<?= $payment_options['midtrans_snap']?>" name="midtrans_snap" />
                        </div>
                        <div class="form-group m-b-30">
                            <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> &nbsp;Simpan</button>
                        </div>
                    {!! Form::close() !!}
                    </div>
                </div>

                <div class="tab-pane" id="tab_3">
                    {!! Form::open(['route' => 'edit_pengaturan', 'files' => true]) !!}
                        <div class="form-group" style="margin-bottom: 1rem">
                            <label>Biaya COD</label>
                            <input type="hidden" name="tipe" value="3"/>
                            <input type="number" class="form-control" required value="<?= $detail['biaya_cod'] ?>" name="biaya_kurir" />
                        </div>
                        <div class="form-group m-b-30">
                            <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> &nbsp;Simpan</button>
                        </div>
                    {!! Form::close() !!}
                    <b style="font-weight: bold; margin-top: 10px">KURIR PENGIRIMAN</b><br/>
                    <small>
                        untuk mengaktifkan atau menonaktifkan klik kurir dibawah
                    </small>
                    <style rel="stylesheet">
                        .op5{-webkit-filter: grayscale(100%);filter: grayscale(100%);}
                        .kurir:hover .imgk{
                            border-color:#00cc00;
                            -webkit-filter: none;
                            filter: none;
                        }
                        .imgk{
                            border-left: 1px dashed #00cc00;
                            border-top: 1px dashed #00cc00;
                            border-right: 1px dashed #00cc00;
                        }
                        .bgijo{
                            background:#00cc00;
                        }
                        .bgabu{
                            background:#ccc;
                        }
                        .kurir:hover .statk{
                            background:#00cc00;
                        }
                    </style>
                    <div style="margin-top: 10px;">
                        <div class="row">
                            <?php
                                $from = DB::table('tbl_website')->where('id', 19)->value('value');
                                $kurir = explode("|", $from);
                                $data = DB::table('tbl_kurir')->get();
                                foreach($data as $kur){
                                    $bor = (in_array($kur->id,$kurir)) ? "border-color:#00cc00;" : "";
                                    $bg = (in_array($kur->id,$kurir)) ? " bgijo" : " bgabu";
                                    $op = (in_array($kur->id,$kurir)) ? "" : " op5";
                                    $aktif = (in_array($kur->id,$kurir)) ? "<b>AKTIF</b>" : "<b>NON AKTIF</b>";
                                    $aktiv = (in_array($kur->id,$kurir)) ? "yes" : "no";
                            ?>
                                    <div class="col-md-3 kurir" style="margin-bottom: 1rem" data-push="<?php echo $kur->id; ?>" data-aktif="<?php echo $aktiv; ?>">
                                        <div class="imgk pointer<?php echo $op; ?>" style="<?php echo $bor; ?>">
                                            <img class="img-responsive" style="padding: 1.50rem;" src="<?= Storage::url("kurir/".$kur->rajaongkir.".png"); ?>" />
                                        </div>
                                        <div class="statk text-center <?php echo $bg; ?>" style="color:#fff; padding: 0.30rem 0 0.30rem 0"><?php echo $aktif; ?></div>
                                    </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="tab_5">
                    <div class="box box-primary collapsed-box">
                        <div class="box-header">
                            <h3 class="box-title">
                                Tambah Rekening
                            </h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                        {!! Form::open(['route' => 'pengaturan']) !!}
                            @csrf
                            <div class="form-group has-feedback">
                                <input type="hidden" name="tipe" value="4">
                                {!! Form::label('exampleEmail1', 'Atas Nama') !!}
                                {!! Form::text('atas_nama',  null, ['id' => 'atas_nama', 'class' => 'form-control']) !!}
                                <span class="help-block"><small>Masukan atas nama tanpa karakter khusus dan angka</small></span>
                            </div>
                            <div class="form-group has-feedback">
                                {!! Form::label('exampleEmail1', 'Nomor Rekening') !!}
                                {!! Form::text('nomer_rekening',  null, ['id' => 'nomer_rekening', 'class' => 'form-control']) !!}
                                <span class="help-block"><small>Masukan nomer rekening tanpa karakter khusus</small></span>
                            </div>
                            <div class="form-group has-feedback">
                                {!! Form::label('exampleEmail1', 'Pilih Kategori Bank') !!}
                                <select name="id_bank" id="id_bank" class="form-control">
                                    <option value="">=== PILIH BANK ===</option>
                                    @foreach($payment_options['list_bank'] as $items)
                                        <option value="{{ $items->id }}">{{ $items->nama }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"><small>Silahkan pilih kategori bank yang sesuai</small></span>
                            </div>
                            <div class="form-group has-feedback">
                                <button type="submit" class="btn btn-primary btn-flat">Tambah</button>
                                <button type="reset" class="btn btn-danger btn-flat">Batal</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        Tabel Rekening
                                    </h3>
                                </div>
                                <div class="box-body">
                                    <table class="table table-bordered table-hover" id="table_rekening">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Kode Bank</th>
                                                <th>Atas Nama</th>
                                                <th>Nomer Rekening</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $counter = 1; foreach($payment_options['list_rekening'] as $item) { ?>
                                            <?php 
                                                $detail = DB::table('tbl_rekeningbank')->where('id', $item->id_bank)->value('nama');
                                            ?>
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $detail }}</td>
                                                    <td>{{ $item->atas_nama }}</td>
                                                    <td>{{ $item->nomer_rekening }}</td>
                                                    <td>
                                                        @if($item->is_active == 1)
                                                            <span class="label bg-green"><i class="fa fa-check fa-fw"></i> Aktif</span>
                                                        @else
                                                            <span class="label bg-red"><i class="fa fa-close fa-fw"></i> Tidak Aktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                Action <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a href="{{ route('edit_rekening', $item->id) }}">
                                                                        <i class="fa fa-edit fa-fw"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" id="hapus_rekening" data-toggle="modal" data-target="#modal_hapus" data-id="{{ $item->id }}">
                                                                        <i class="fa fa-trash fa-fw"></i> Hapus
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php $counter++; ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('modal')
<div class="modal modal-default fade" id="modal_hapus">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Anda Yakin Ingin Lanjutkan ?</h4>
            </div>
            <div class="modal-body">
                <p class="text-muted">Apakah anda yakin untuk menghapus data tersebut?</p>
            </div>
            {!! Form::open(['route' => 'hapus_rekening', 'id' => 'hapus_rekening', 'method' => 'DELETE']) !!}
                <div class="modal-footer">
                    @csrf
                    <input type="hidden" name="id" class="id_rekening" value="">
                    <button type="button" class="btn" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection

@section('extra_js')

{{ Html::script('admin_assets/component/datatables.net/js/jquery.dataTables.min.js') }}
{{ Html::script('admin_assets/component/datatables.net-bs/js/dataTables.bootstrap.min.js') }}
{{ Html::script('admin_assets/component/ckeditor/ckeditor.js') }}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#table_rekening').DataTable({
            'lengthChange': false,
            'length': 10,
            'searching': false
        })

        CKEDITOR.replace('about')

        $("#hapus_rekening").click(function() {
            $('.id_rekening').val($('#hapus_rekening').data('id'))
            $('#modal_hapus').show();
        })

        $(".kurir").each(function(){
			$(this).click(function(){
				var kurir = $(this);
				if($(this).data("aktif") === "no"){
					$.post("aktifkan_kurir",{"push":$(this).data("push"),"_token": '{{csrf_token()}}'},function(msg){
						if(msg.success == true){
							swal.fire("Berhasil!","kurir telah diaktifkan","success");
							kurir.data("aktif","yes");
							kurir.find(".imgk").removeClass("op5");
							kurir.find(".statk").removeClass("bgabu");
							kurir.find(".statk").addClass("bgijo");
							kurir.find(".statk").html("<b>AKTIF</b>");
							kurir.find(".imgk").css("border-color","#00cc00");
						}else{
							swal.fire("Gagal!","Terjadi kendala saat mengaktifkan kurir ini, coba ulangi beberapa saat lagi","error");
						}
					});
				}else{
					if(hitungJumlah() > 1){
						$.post("nonaktifkan_kurir",{"push":$(this).data("push"),"_token": '{{csrf_token()}}'},function(msg){
                            if(msg.success == true){
                                swal.fire("Berhasil!","kurir telah dinonaktifkan","success");
                                kurir.data("aktif","no");
                                kurir.find(".imgk").addClass("op5");
								kurir.find(".statk").addClass("bgabu");
								kurir.find(".statk").removeClass("bgijo");
                                kurir.find(".statk").html("<b>NON AKTIF</b>");
								kurir.find(".imgk").css("border-color","#ccc");
                            }else{
                                swal.fire("Gagal!","Terjadi kendala saat mengaktifkan kurir ini, coba ulangi beberapa saat lagi","error");
                            }
                        });
					}else{
						swal.fire("Error!","Tidak dapat menonaktifkan kurir ini, Anda harus mengaktifkan minimal 1 kurir pengiriman untuk toko Anda","error");
					}
				}
			});
		});
    })

    function saveManual(val){
		$(".g-transfer button").removeClass("btn-success");
		$(".g-transfer button").removeClass("btn-danger");
		$(".g-transfer button").removeClass("btn-light");
		$.post("update_payment",{"payment_transfer":val, "tipe": '1', "_token": '{{csrf_token()}}'},function(ev){
			if(val == 1){
				$("#aktifnotif").addClass("btn-success");
				$("#matinotif").addClass("btn-light");
			}else{
				$("#aktifnotif").addClass("btn-light");
				$("#matinotif").addClass("btn-danger");
			}
		});
	}

	function saveMidtrans(val){
		$(".g-midtrans button").removeClass("btn-success");
		$(".g-midtrans button").removeClass("btn-danger");
		$(".g-midtrans button").removeClass("btn-light");
		$.post("update_payment",{"payment_midtrans":val, "tipe": '2', "_token": '{{csrf_token()}}'},function(ev){
			if(val == 1){
				$("#aktifnotifm").addClass("btn-success");
				$("#matinotifm").addClass("btn-light");
			}else{
				$("#aktifnotifm").addClass("btn-light");
				$("#matinotifm").addClass("btn-danger");
			}
		});
	}

    function hitungJumlah(){
		var aktifan = 0;
		$('.kurir').each(function(){
			var aktif = $(this).data('aktif');
		  if (aktif === "yes") {
		  	aktifan += 1;
		  }
		});
		return aktifan;
	}

</script>

@endsection
