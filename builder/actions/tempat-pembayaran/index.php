<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$qb = new QueryBuilder();
$qb1 = new QueryBuilder();

$limit = 10;

if(isset($_GET['limit']) && $_GET['limit']){
    $limit = $_GET['limit'];
}

$datas = $qb->select("TEMPAT_BAYAR","TOP $limit TEMPAT_BAYAR.*");
$limits = $qb1->select("TEMPAT_BAYAR","count(*) as count");

if(isset($_GET['filter'])){

    if($_GET['tempat-pembayaran']){
        $datas->where('NM_TP',"%".$_GET['tempat-pembayaran']."%",'like');
        $limits->where('NM_TP',"%".$_GET['tempat-pembayaran']."%",'like');
    }

}

$datas = $datas->get();
$limits = $limits->first();