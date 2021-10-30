<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$failed = get_flash_msg('failed');
$qb = new QueryBuilder();
$datas = $qb->select("KAYU_ULIN");

if(isset($_GET['filter'])){

    if($_GET['kayu-ulin']){
        $datas->where('THN_STATUS_KAYU_ULIN',$_GET['kayu-ulin']);
    }

}

$datas = $datas->orderBy('THN_STATUS_KAYU_ULIN','DESC')->get();