<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

extract($_GET);

$clause = "THN_PAJAK = '".$_GET['tahun_pajak']."'";
if(isset($_GET['KD_KECAMATAN']))
{
    $clause .= " AND KD_KECAMATAN  = '".$_GET['KD_KECAMATAN']."'";
}

if(isset($_GET['KD_KELURAHAN']))
{
    $clause .= " AND KD_KELURAHAN  = '".$_GET['KD_KELURAHAN']."'";
}

$query = "SELECT * FROM TEMP_DHKP where $clause ORDER BY THN_PAJAK,KD_KECAMATAN,KD_KELURAHAN,NOPQ ASC";

$datas = $qb->rawQuery($query)->get();

$C_STR = "SELECT * FROM PEJABAT";
$pejabat = $qb->rawQuery($C_STR)->get();
foreach($pejabat as $pj)
{
    $xNIP = $pj['NIP'];
    $xNama = $pj['NAMA'];
    $xJabatan = $pj['JABATAN'];
}