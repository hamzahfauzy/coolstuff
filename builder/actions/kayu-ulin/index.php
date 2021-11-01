<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$failed = get_flash_msg('failed');
$qb = new QueryBuilder();
$qb1 = new QueryBuilder();

$limit = 10;

if(isset($_GET['limit']) && $_GET['limit']){
    $limit = $_GET['limit'];
}

$datas = $qb->select("KAYU_ULIN","TOP $limit KAYU_ULIN.*");
$limits = $qb1->select("KAYU_ULIN","count(*) as count");

if(isset($_GET['filter'])){

    if($_GET['kayu-ulin']){
        $datas->where('THN_STATUS_KAYU_ULIN',$_GET['kayu-ulin']);
        $limits->where('THN_STATUS_KAYU_ULIN',$_GET['kayu-ulin']);
    }

}

$datas = $datas->orderBy('THN_STATUS_KAYU_ULIN','DESC')->get();
$limits = $limits->first();