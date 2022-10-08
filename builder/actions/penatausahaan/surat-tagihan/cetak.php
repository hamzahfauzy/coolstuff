<?php

require '../helpers/QueryBuilder.php';
$qb = new QueryBuilder();
$builder = new Builder;
$installation = $builder->get_installation();

if(isset($_POST['NOP']))
    $query = "SELECT NOPQ,SUBJEK_PAJAK_ID,NM_WP,JALAN_WP,KELURAHAN_WP,KOTA_WP FROM QOBJEKPAJAK WHERE NOPQ = '$_POST[NOP]'";
else
    $query = "SELECT DAT_SUBJEK_PAJAK.* FROM DAT_SUBJEK_PAJAK WHERE SUBJEK_PAJAK_ID IN (SELECT SUBJEK_PAJAK_ID FROM QOBJEKPAJAK WHERE KD_KECAMATAN = '$_POST[KD_KECAMATAN]' AND KD_KELURAHAN = '$_POST[KD_KELURAHAN]' GROUP BY SUBJEK_PAJAK_ID)";
    // $query = "SELECT SUBJEK_PAJAK_ID FROM QOBJEKPAJAK WHERE KD_KECAMATAN = '$_POST[KD_KECAMATAN]' AND KD_KELURAHAN = '$_POST[KD_KELURAHAN]' GROUP BY SUBJEK_PAJAK_ID";
$datas = $qb->rawQuery($query)->get();

if(isset($_GET['check']))
{
    echo json_encode(['count'=>count($datas)]);
    die();
}


$C_STR = "SELECT * FROM PEJABAT";
$pejabat = $qb->rawQuery($C_STR)->get();
foreach($pejabat as $pj)
{
    $xNIP = $pj['NIP'];
    $xNama = $pj['NAMA'];
    $xJabatan = $pj['JABATAN'];
}
