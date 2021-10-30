<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$qb = new QueryBuilder();
$datas = $qb->select("TEMPAT_BAYAR");

if(isset($_GET['filter'])){

    if($_GET['tempat-pembayaran']){
        $datas->where('NM_TP',"%".$_GET['tempat-pembayaran']."%",'like');
    }

}

$datas = $datas->get();