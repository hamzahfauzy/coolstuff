<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder;

$kecamatan = $qb->select('REF_KECAMATAN')->get();
$tempo = $qb->rawQuery("SELECT TGL_JATUH_TEMPO_SPPT FROM SPPT WHERE THN_PAJAK_SPPT = '$_POST[tahun_pajak]'")->first();
$last_year = $_POST['tahun_pajak']-1;
$first_year = 2009;
$in_year = [];
for($i=$first_year;$i<=$last_year;$i++)
{
    $in_year[] = $i;
}
$in_year = implode(",",$in_year);