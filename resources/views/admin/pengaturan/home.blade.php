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
                        <button type="submit" class="btn btn-md btn-primary">Perbarui</button>
                    </div>
                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

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
