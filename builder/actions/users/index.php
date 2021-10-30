<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$qb = new QueryBuilder();
$datas = $qb->select("USERS","USERS.*, WEWENANG.NM_WEWENANG")
    ->join('WEWENANG','WEWENANG.KD_WEWENANG','USERS.WEWENANG');


if(isset($_GET['filter'])){

    if($_GET['users']){
        $datas->where('USERNAME',"%".$_GET['users']."%",'like');
    }

}

$datas = $datas->get();
