<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$datas = [];

$cari = false;

if(isset($_GET['subjek_pajak_id']))
{
    $cari = true;
    if($_GET['type'] == 'NOP')
        $query = "SELECT * FROM QOBJEKPAJAK WHERE NOPQ = '$_GET[subjek_pajak_id]'";
    else
        $query = "SELECT * FROM QOBJEKPAJAK WHERE SUBJEK_PAJAK_ID = '$_GET[subjek_pajak_id]'";
    $datas = $qb->rawQuery($query)->get();

    foreach($datas as $key => $data)
    {
        $query = "SELECT * FROM PEMBAYARAN_SPPT WHERE
          KD_PROPINSI = '$data[KD_PROPINSI]' AND
          KD_DATI2 = '$data[KD_DATI2]' AND
          KD_KECAMATAN = '$data[KD_KECAMATAN]' AND
          KD_KELURAHAN = '$data[KD_KELURAHAN]' AND
          KD_BLOK = '$data[KD_BLOK]' AND
          NO_URUT = '$data[NO_URUT]' AND
          KD_JNS_OP = '$data[KD_JNS_OP]'
        ORDER BY THN_PAJAK_SPPT DESC";
        $pembayaran = $qb->rawQuery($query)->get();
        $datas[$key]['riwayat'] = $pembayaran;
    }
}