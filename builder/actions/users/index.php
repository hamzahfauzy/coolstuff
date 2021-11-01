<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$qb = new QueryBuilder();
$qb1 = new QueryBuilder();

$limit = 10;

if(isset($_GET['limit']) && $_GET['limit']){
    $limit = $_GET['limit'];
}

$datas = $qb->select("USERS","TOP $limit USERS.*, WEWENANG.NM_WEWENANG")
    ->leftJoin('WEWENANG','WEWENANG.KD_WEWENANG','USERS.WEWENANG');

$limits = $qb1->select("USERS","count(*) as count");

if(isset($_GET['filter'])){

    if($_GET['users']){
        $datas->where('USERNAME',"%".$_GET['users']."%",'like');
        $limits->where('USERNAME',"%".$_GET['users']."%",'like');
    }

}

$datas = $datas->get();
$limits = $limits->first();
