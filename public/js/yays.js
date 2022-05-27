//[ HALAMAN ADMIN ]--------------------------------------------------------------------------------------//

//** ADMIN BERANDA */////////////////////////////////////////////////////////////////////////

//** Implementasi pace terhadap ajax request */

$(document).ajaxStart(function () {
    Pace.restart()
})

//** Memberikan class active ke navbar sesuai url */

var url = window.location;

$('ul.sidebar-menu a').filter(function() {

     return this.href == url;

}).parent().addClass('active');

$('ul.treeview-menu a').filter(function() {

     return this.href == url;

}).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');


//** Sidebar value counter */

$(document).ready(function(){
    $.get('http://'+url.host+'/admin/sidebar_counter').done(function(data){
        var ids = ['produk', 'kategori', 'merk', 'pengguna', 'admin', 'pesanan', 'pembayaran', 'pengiriman'];
        for(var index = 0; index < ids.length; index++) {
            $('#jml_'+ids[index]).html(data[index])
        }
    })
})



//** ADMIN PRODUK *///////////////////////////////////////////////////////////////////////////

//** Edit Produk */

$('a.edit_produk').click(function(){
    let id = this.id
    $.get('http://'+url.host+'/admin/get_produk/'+$('#id_'+id).html())
    .done(function(data){
        $('h4.modal-title').html('Edit Produk - #'+data['id_barang'])
        $('form#form_edit_produk').attr('action','http://'+url.host+'/admin/edit_produk/'+data['id_barang'])
        $('input#inp_edit_nama_barang').val(data['nama_barang'])
        $('select#inp_edit_id_kategori option[value*="'+data['id_kategori']+'"]').attr('selected', 'selected')
        $('select#inp_edit_id_merk option[value*="'+data['id_merk']+'"]').attr('selected', 'selected')
        let foto_url = 'http://'+url.host+'/storage/produk/'
        $('img#foto_barang').attr('src', foto_url+data['foto_barang'])
        $('img#foto_barang').attr('alt', data['nama_barang'])
        $('input#inp_edit_berat_barang').val(data['berat_barang'])
        $('input#inp_edit_harga_satuan').val(data['harga_satuan'])
        $('input#inp_edit_stok_barang').val(data['stok_barang'])
        CKEDITOR.instances['inp_edit_deskripsi_barang'].setData(data['deskripsi_barang'])
    })
})

//** Hapus Produk */

$('a.hapus_produk').click(function(){
    $('form#form_hapus_produk').attr('action','http://'+url.host+'/admin/hapus_produk/'+$('#id_'+this.id).html())
})




//** ADMIN MERK *///////////////////////////////////////////////////////////////////////////

//** Check nama merk */

$('button#check_merk').click(function(){
    var value = $('input#inp_nama_merk').val()
    $('span.help-block').remove()
    if(value != '') {
        $.get('http://'+url.host+'/admin/check_merk', {nama_merk: value}, function(data) {
            console.log($.parseJSON(data))
            if ($.parseJSON(data) == false) {
                $('button#simpan').removeClass('disabled').attr('type', 'submit')
                $('input#inp_nama_merk').parent().removeClass().addClass('form-group has-success')
                $('input#inp_nama_merk').after('<span class="help-block">Merk Dapat Digunakan</span>')
            } else {
                $('#simpan').addClass('disabled').attr('type', 'button')
                $('input#inp_nama_merk').parent().removeClass().addClass('form-group has-warning')
                $('input#inp_nama_merk').after('<span class="help-block">Merk Tidak Dapat Digunakan Karna Telah Tersedia</span>')
            }
        })
    } else {
        $('button#simpan').addClass('disabled').attr('type', 'button')
        $('input#inp_nama_merk').parent().removeClass().addClass('form-group has-error')
        $('input#inp_nama_merk').after('<span class="help-block">Value Belum Di Isi</span>')
    }
})

//** Edit merk */

$('a.edit_merk').click(function(){
    $('h4.modal-title').html('Edit Merk - #'+$('#id_'+this.id).html())
    $('form#form_edit_merk').attr('action','http://'+url.host+'/admin/edit_merk/'+$('td#id_'+this.id).html())
    $('input.id_merk').val($('td#id_'+this.id).html())
    $('input.nama_merk').val($('td#nama_'+this.id).html())
})

//** Hapus merk */
$('a.hapus_merk').click(function(){
    $('form#form_hapus_merk').attr('action','http://'+url.host+'/admin/hapus_merk/'+$('td#id_'+this.id).html())
})




//** ADMIN KATEGORI *///////////////////////////////////////////////////////////////////////////

//** Check nama kategori */

$('button#check_kategori').click(function(){
    var value = $('input#inp_nama_kategori').val()
    $('span.help-block').remove()
    if(value != '') {
        $.get('http://'+url.host+'/admin/check_kategori/'+value, function(data) {
            // console.log($.parseJSON(data))
            if ($.parseJSON(data) == false) {
                $('button#simpan').removeClass('disabled').attr('type', 'submit')
                $('input#inp_nama_kategori').parent().removeClass().addClass('form-group has-success')
                $('input#inp_nama_kategori').after('<span class="help-block">kategori Dapat Digunakan</span>')
            } else {
                $('button#simpan').addClass('disabled').attr('type', 'button')
                $('input#inp_nama_kategori').parent().removeClass().addClass('form-group has-warning')
                $('input#inp_nama_kategori').after('<span class="help-block">kategori Tidak Dapat Digunakan Karna Telah Tersedia</span>')
            }
        })
    } else {
        $('button#simpan').addClass('disabled').attr('type', 'button')
        $('input#inp_nama_kategori').parent().removeClass().addClass('form-group has-error')
        $('input#inp_nama_kategori').after('<span class="help-block">Value Belum Di Isi</span>')
    }
})

//** Edit kategori */

$('a.edit_kategori').click(function(){
    $('h4.modal-title').html('Edit Kategori - #'+$('#id_'+this.id).html())
    $('form#form_edit_kategori').attr('action','http://'+url.host+'/admin/edit_kategori/'+$('#id_'+this.id).html())
    $('input.id_kategori').val($('#id_'+this.id).html())
    $('input.nama_kategori').val($('#nama_'+this.id).html())
})

//** Hapus kategori */

$('a.hapus_kategori').click(function(){
    $('form#form_hapus_kategori').attr('action','http://'+url.host+'/admin/hapus_kategori/'+$('#id_'+this.id).html())
})




//** SUPERADMIN : ADMIN *///////////////////////////////////////////////////////////////////////////

//** Edit Status Admin */

$('a.ubah_status_admin').click(function(){
    $('form#form_edit_status_admin').attr('action','http://'+url.host+'/admin/superadmin/ubah_status_admin/'+$('#id_'+this.id).html())
    let id_admin = $('td#id_'+this.id).html()
    $.get('http://'+url.host+'/admin/superadmin/get_admin/'+id_admin).done(function(data){
        $('select#inp_edit_status_admin option[value*="'+data['superadmin']+'"]').attr('selected', 'selected')
    })
})

//** Hapus Admin */

$('a.hapus_admin').click(function(){
    $('form#form_hapus_admin').attr('action','http://'+url.host+'/admin/superadmin/hapus_admin/'+$('#id_'+this.id).html())
})

//** Profile Admin */

$('a.detail_admin').click(function(){
    let id_admin = $('td#id_'+this.id).html()
    $.get('http://'+url.host+'/admin/superadmin/get_admin/'+id_admin).done(function(data){
        $('h4.modal-title').html('Detail Akun '+data['nama_lengkap'])
        $('img#foto').attr('src', 'http://'+url.host+'/storage/avatars/admin/'+data['foto'])
        $('img#foto').attr('alt', data['nama_lengkap'])
        $('p#nama_lengkap').html(data['nama_lengkap'])
        $('p#email').html(data['email'])
        $('p#tanggal').html(data['tanggal_bergabung'])
        if(data['diblokir']){
            $('span#blokir').addClass('bg-green').html(
                '<i class="fa fa-check fa-fw"></i> Ya'
            )
        } else {
            $('span#blokir').addClass('bg-red').html(
                '<i class="fa fa-close fa-fw"></i> Tidak'
            )
        }
        if(data['superadmin']){
            $('span#superadmin').addClass('bg-green').html(
                '<i class="fa fa-check fa-fw"></i> Superadmin'
            )
        } else {
            $('span#superadmin').addClass('bg-red').html(
                '<i class="fa fa-close fa-fw"></i> Bukan Superadmin'
            )
        }

    })
})



//** SUPERADMIN : PENGGUNA *///////////////////////////////////////////////////////////////////////////

//** Hapus Pengguna */

$('a.hapus_pengguna').click(function(){
    $('form#form_hapus_pengguna').attr('action','http://'+url.host+'/admin/superadmin/hapus_pengguna/'+$('#id_'+this.id).html())
})

//** Profile Pengguna */

$('a.detail_pengguna').click(function(){
    let id_admin = $('td#id_'+this.id).html()
    $.get('http://'+url.host+'/admin/superadmin/get_pengguna/'+id_admin).done(function(data){
        $('p#id_pengguna').html(data['id_pengguna'])
        $('p#nama_lengkap').html(data['nama_lengkap'])
        $('p#jenis_kelamin').html(data['jenis_kelamin'])
        $('p#email').html(data['email'])
        $('p#tanggal').html(data['tanggal_bergabung'])
        $('p#no_telepon').html(data['no_telepon'])
        $('p#alamat_rumah').html(data['alamat_rumah'])
    })
})



//** ADMIN PEMBAYARAN *///////////////////////////////////////////////////////////////////////////

//** Proses Pembayaran */

$('button.proses_pembayaran').click(function(){
    $('form#form_proses_pembayaran').attr('action','http://'+url.host+'/admin/transaksi/pembayaran/status/'+$('td#id_'+this.id).html())
})

//** Lihat Bukti Pembayaran */

$('button.lihat_foto').click(function(){
    $('img#foto_bukti').attr('src', 'http://'+url.host+'/storage/pembayaran/'+$('td#id_'+this.id).html()+'.jpg')
})



//** ADMIN PESANAN *///////////////////////////////////////////////////////////////////////////

//** Proses Pesanan */

$('a.proses_pesanan').click(function(){
    $('form#form_proses_pesanan').attr('action','http://'+url.host+'/admin/transaksi/proses_pesanan/'+$('td#id_'+this.id).html())
})

//** Rubah Infomasi Penerima */
$('a.edit_pesanan').click(function() {
    $('form#form_edit_pesanan').attr('action','http://'+url.host+'/admin/transaksi/edit_pesanan/'+$('td#id_'+this.id).html())
    $.get('http://'+url.host+'/admin/transaksi/get_penerima/'+$('td#id_'+this.id).html())
    .done(function(data){
        $('input#inp_nama_penerima').val(data.nama_penerima)
        $('textarea#inp_alamat_tujuan').val(data.alamat_tujuan)
        $('input#inp_no_telepon').val(data.no_telepon)
    })
})

//** Kirim Pesanan */

$('a.kirim_pesanan').click(function(){
    $('form#form_kirim_pesanan').attr('action','http://'+url.host+'/admin/transaksi/kirim_pesanan/'+$('td#id_'+this.id).html())
})

//** Batalkan Pesanan */

$('a.batalkan_pesanan').click(function(){
    $('form#form_batalkan_pesanan').attr('action','http://'+url.host+'/admin/transaksi/batalkan_pesanan/'+$('td#id_'+this.id).html())

})

//** Hapus Pesanan */

$('a.hapus_pesanan').click(function(){
    $('form#form_hapus_pesanan').attr('action','http://'+url.host+'/admin/transaksi/hapus_pesanan/'+$('td#id_'+this.id).html())

})

//** Lihat Bukti Pembayaran */

$('button.lihat_foto').click(function(){
    $('img#foto_bukti').attr('src', 'http://'+url.host+'/storage/pembayaran/'+$('td#id_'+this.id).html()+'.jpg')
})



//** ADMIN PENGIRIMAN *///////////////////////////////////////////////////////////////////////////

//** Pesanan Selesai */

$('button.pesanan_selesai').click(function(){
    $('form#form_pesanan_selesai').attr('action','http://'+url.host+'/admin/transaksi/selesai/'+$('td#id_'+this.id).html())
})
