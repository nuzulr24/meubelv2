<?php
    // dd($detail_resi);
    if(!empty($detail_resi['error']) == true) {
?>
    <div class="alert alert-info"><?= $detail_resi['message'] ?></div>
<?php } else { foreach($detail_resi as $rows) { 
?>
<?php
    // dd($rows['detail']);
    $detail = $rows['detail'];
    $find = DB::table('tbl_pesanan')->where('id_pesanan', $invoice)->first();
    $origins = DB::table('tbl_website')->where('id', 18)->value('value');
    $kabupaten = DB::table('tbl_kabupaten')->where('id', $origins)->value('nama');
?>
<div class="alert alert-success">
    Resi Ditemukan! Berikut adalah detail pengiriman barang anda.
</div>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Status</th>
                <th style="font-weight: normal"><?= ucfirst($detail['status']) ?></th>
            </tr>
            <tr>
                <th>Layanan</th>
                <th style="font-weight: normal"><?= empty($detail['service']) ? strtoupper($find->kurir) : strtoupper($detail['service'])  ?></th>
            </tr>
            <tr>
                <th>Asal</th>
                <th style="font-weight: normal"><?= empty($detail['origin']) ? strtoupper($kabupaten) : $detail['origin'] ?></th>
            </tr>
            <tr>
                <th>Tujuan</th>
                <th style="font-weight: normal"><?= empty($detail['destination']) ? '-' : $detail['destination'] ?></th>
            </tr>
            <tr>
                <th>Posisi Terakhir</th>
                <th style="font-weight: normal"><?= $detail['current_position'] ?></th>
            </tr>
            <?php if(!empty($detail['receiver'])) { ?>
            <tr>
                <th>Diterima oleh</th>
                <th style="font-weight: normal"><?= $detail['receiver'] ?></th>
            </tr>
            <?php } ?>
        </thead>
    </table>
</div>
<p class="mb-2">Riwayat</p>
<div style="max-height: 250px; overflow-y: auto">
    <div class="list-group">
      <?php
        $i = 0;
        foreach($detail['history'] as $item) {
            if($i++ == 0) {
      ?>
              <a href="#" class="list-group-item disabled" style="background-color: var(--primary) !important; color: white">
                <span class="small text-white"><?= date('j F Y H:i:s', strtotime($detail['history'][0]['time'])) ?></span>
                <h5 style="margin-top: 5px; margin-bottom: 5px;"><?= $detail['history'][0]['position'] ?></h5>
                <p style="margin-bottom: 0px; font-size: 0.8rem"><?= $detail['history'][0]['desc'] ?></p>
              </a>
            <?php } else { ?>
              <a href="#" class="list-group-item">
                <span class="small text-secondary"><?= date('j F Y H:i:s', strtotime($item['time'])) ?></span>
                <h6 style="margin-top: 5px; margin-bottom: 5px;"><?= $item['position'] ?></h6>
                <p style="margin-bottom: 0px; font-size: 0.8rem"><?= $item['desc'] ?></p>
              </a>
            <?php } ?>
      <?php } ?>
    </div>
</div>
<?php } ?>
<?php } ?>