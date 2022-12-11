<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$qb = new QueryBuilder();

if(request() == 'POST'){
    
    if($_POST['DBKB_STANDARD'] == 'on'){
        $sql1 = "H_SATUAN '" . $_POST['YEAR'] . "' ";
        $insert1 = $qb->rawQuery($sql1)->exec();

        $sql2 = "H_KEGIATAN '" . $_POST['YEAR'] . "' ";
        $insert2 = $qb->rawQuery($sql2)->exec();

        $sql3 = "HITUNG_DBKB_STANDARD '" . $_POST['YEAR'] . "' ";
        $insert3 = $qb->rawQuery($sql3)->exec();

        $sql4 = "HITUNG_DBKB_FINAL '" . $_POST['YEAR'] . "' ";
        $insert4 = $qb->rawQuery($sql4)->exec();
    }

    if($_POST['DBKB_MATERIAL'] == 'on'){
        $sql5 = "DBKB_MAT_HARGA_SATUAN '" . $_POST['YEAR'] . "' ";
        $insert5 = $qb->rawQuery($sql5)->exec();

        $sql6 = "DBKB_MAT_SEBELUM_ADJUSTMENT '" . $_POST['YEAR'] . "' ";
        $insert6 = $qb->rawQuery($sql6)->exec();

        $sql7 = "DBKB_MAT_ADJUSTMENT '" . $_POST['YEAR'] . "' ";
        $insert7 = $qb->rawQuery($sql7)->exec();
    }

    if(($insert1 && $insert2 && $insert3 && $insert4) || ($insert5 && $insert6 && $insert7)){
        set_flash_msg(['success'=>'Data Saved']);
        header("location:index.php?page=builder/dbkb-utama-material/index");
        return;
    }

}

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

$year = date("Y");