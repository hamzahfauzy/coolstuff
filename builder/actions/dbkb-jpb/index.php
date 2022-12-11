<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$qb = new QueryBuilder();

if(request() == 'POST'){
    
    if($_POST['DBKB_STANDARD'] == 'on'){
        $sql1 = "HITUNG_HARGA_KEGIATAN_JPB8 '" . $_POST['YEAR'] . "' ";
        $insert1 = $qb->rawQuery($sql1)->exec();

        $sql2 = "HITUNG_DBKB_JPB8 '" . $_POST['YEAR'] . "' ";
        $insert2 = $qb->rawQuery($sql2)->exec();

        $sql3 = "HITUNG_DBKB_JPB8_STLH_ADJ '" . $_POST['YEAR'] . "' ";
        $insert3 = $qb->rawQuery($sql3)->exec();
    }

    if($_POST['DBKB_MATERIAL'] == 'on'){
        $sql5 = "HITUNG_DBKB_JPB3 '" . $_POST['YEAR'] . "' ";
        $insert5 = $qb->rawQuery($sql5)->exec();
    }

    if(($insert1 && $insert2 && $insert3) || ($insert5)){
        set_flash_msg(['success'=>'Data Saved']);
        header("location:index.php?page=builder/dbkb-jpb/index");
        return;
    }

}

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

$year = date("Y");