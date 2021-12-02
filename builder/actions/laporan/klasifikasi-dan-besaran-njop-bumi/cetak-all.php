<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

extract($_GET);

$query = "SELECT * FROM TEMP_BUMI ORDER BY BLOK, NM_JALAN ASC";

$kecamatan = $qb->select("REF_KECAMATAN")->where('KD_KECAMATAN',$KD_KECAMATAN)->first();
$kelurahan = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$KD_KECAMATAN)->where('KD_KELURAHAN',$KD_KELURAHAN)->first();

$datas = $qb->rawQuery($query)->get();

