<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

extract($_GET);

if($KD_KECAMATAN == 'Semua')
{
    $query = "SELECT * FROM TEMP_DHKP ORDER BY WHERE THN_PAJAK='$tahun_pajak' THN_PAJAK,KD_KECAMATAN,KD_KELURAHAN,NOPQ ASC";
}
else
{
    if($KD_KELURAHAN == 'Semua')
    {
        $query = "SELECT * FROM TEMP_DHKP WHERE THN_PAJAK='$tahun_pajak' and KD_KECAMATAN='$KD_KECAMATAN' ORDER BY THN_PAJAK,KD_KECAMATAN,KD_KELURAHAN,NOPQ ASC";   
    }
    else
    {
        $query = "SELECT * FROM TEMP_DHKP WHERE THN_PAJAK='$tahun_pajak' and KD_KECAMATAN='$KD_KECAMATAN' AND KD_KELURAHAN='$KD_KELURAHAN' ORDER BY THN_PAJAK,KD_KECAMATAN,KD_KELURAHAN,NOPQ ASC";
    }
}

if(!$data)
{
    set_flash_msg(['failed'=>'Data tidak valid']);
    header("location:index.php?page=builder/penatausahaan/laporan-piutang/index");
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