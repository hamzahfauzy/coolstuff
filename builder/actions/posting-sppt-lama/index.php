<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$failed = get_flash_msg('failed');
$qb = new QueryBuilder();

if(request() == 'POST'){

    $dl_str = "Delete From SPPT_1 where THN_PAJAK_SPPT='" . $_POST['YEAR'] . "'";
    $bc_STR = "INSERT INTO SPPT_1 SELECT * FROM SPPT WHERE SPPT.THN_PAJAK_SPPT='" . $_POST['YEAR'] . "'";

    $dl = $qb->rawQuery($dl_strl)->exec();
    $bc = $qb->rawQuery($bc_STR)->exec();

    if($dl && $bc){
        set_flash_msg(['success'=>'Data Saved']);
        header("location:index.php?page=builder/posting-sppt-lama/index");
        return;
    }

}

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

$year = date("Y");