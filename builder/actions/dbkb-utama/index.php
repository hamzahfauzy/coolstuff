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

$sqlJpb = "Select * From REF_JPB ORDER BY KD_JPB ASC";

$jpbs = $qb->rawQuery($sqlJpb)->get();

$sql = "SELECT DBKB_STANDARD.KD_PROPINSI, DBKB_STANDARD.KD_DATI2, DBKB_STANDARD.THN_DBKB_STANDARD, DBKB_STANDARD.KD_JPB, REF_JPB.NM_JPB, DBKB_STANDARD.TIPE_BNG, DBKB_STANDARD.KD_BNG_LANTAI, DBKB_STANDARD.NILAI_DBKB_STANDARD, TIPE_BANGUNAN.LUAS_MIN_TIPE_BNG, TIPE_BANGUNAN.LUAS_MAX_TIPE_BNG, BANGUNAN_LANTAI.LANTAI_MIN_BNG_LANTAI, BANGUNAN_LANTAI.LANTAI_MAX_BNG_LANTAI FROM ((DBKB_STANDARD INNER JOIN REF_JPB ON DBKB_STANDARD.KD_JPB = REF_JPB.KD_JPB) INNER JOIN TIPE_BANGUNAN ON DBKB_STANDARD.TIPE_BNG = TIPE_BANGUNAN.TIPE_BNG) INNER JOIN BANGUNAN_LANTAI ON (DBKB_STANDARD.KD_BNG_LANTAI = BANGUNAN_LANTAI.KD_BNG_LANTAI) AND (DBKB_STANDARD.TIPE_BNG = BANGUNAN_LANTAI.TIPE_BNG) AND (DBKB_STANDARD.KD_JPB = BANGUNAN_LANTAI.KD_JPB) where DBKB_STANDARD.THN_DBKB_STANDARD= '" .$year."'";

$datas = $qb->rawQuery($sql);

if(isset($_GET['filter'])){

    if($_GET['jpb']){
        $datas->where('DBKB_STANDARD.KD_JPB',$_GET['jpb']);
    }
}

$datas = $datas->orderBy('LANTAI_MIN_BNG_LANTAI')->get();