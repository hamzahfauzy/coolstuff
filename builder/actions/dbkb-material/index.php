<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$qb = new QueryBuilder();
$qb1 = new QueryBuilder();

if(request() == 'POST'){

}

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

$year = date("Y");

if(isset($_GET['year']) && $_GET['year']){
    $year = $_GET['year'];
}

$sqlPekerjaan = "Select * From PEKERJAAN where KD_PEKERJAAN BETWEEN 21 AND 24 ORDER BY KD_PEKERJAAN ASC ";
$pekerjaans = $qb->rawQuery($sqlPekerjaan)->get();

$sql = "SELECT DBKB_MATERIAL.KD_PROPINSI, DBKB_MATERIAL.KD_DATI2, DBKB_MATERIAL.THN_DBKB_MATERIAL, DBKB_MATERIAL.KD_PEKERJAAN, PEKERJAAN.NM_PEKERJAAN, DBKB_MATERIAL.KD_KEGIATAN, PEKERJAAN_KEGIATAN.NM_KEGIATAN, DBKB_MATERIAL.NILAI_DBKB_MATERIAL FROM (PEKERJAAN INNER JOIN PEKERJAAN_KEGIATAN ON PEKERJAAN.KD_PEKERJAAN = PEKERJAAN_KEGIATAN.KD_PEKERJAAN) INNER JOIN DBKB_MATERIAL ON (PEKERJAAN.KD_PEKERJAAN = DBKB_MATERIAL.KD_PEKERJAAN) AND (PEKERJAAN_KEGIATAN.KD_KEGIATAN = DBKB_MATERIAL.KD_KEGIATAN) where DBKB_MATERIAL.THN_DBKB_MATERIAL= '" .$year. "'";

$datas = $qb->rawQuery($sql);

if(isset($_GET['filter'])){

    if($_GET['material']){
        $datas->where('DBKB_MATERIAL.KD_PEKERJAAN',$_GET['material']);
    }
}

$datas = $datas->orderBy('DBKB_MATERIAL.KD_PEKERJAAN')->get();