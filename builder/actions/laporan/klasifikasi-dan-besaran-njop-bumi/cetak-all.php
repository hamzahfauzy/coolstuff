<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

extract($_GET);

$query = "SELECT * FROM TEMP_BUMI ORDER BY BLOK, NM_JALAN ASC";

if($KD_KECAMATAN != "Semua" && $KD_KELURAHAN != "Semua"){
    $kecamatan = $qb->select("REF_KECAMATAN")->where('KD_KECAMATAN',$KD_KECAMATAN)->first();
    $kelurahan = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$KD_KECAMATAN)->where('KD_KELURAHAN',$KD_KELURAHAN)->first();
}else{
    $kecamatan['KD_KECAMATAN'] = "00";
    $kecamatan['NM_KECAMATAN'] = "Semua";

    $kelurahan['KD_KELURAHAN'] = "00";
    $kelurahan['NM_KELURAHAN'] = "Semua";
}

$datas = $qb->rawQuery($query)->get();

