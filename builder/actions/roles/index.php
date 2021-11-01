<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$qb = new QueryBuilder();
$qb1 = new QueryBuilder();

$limit = 10;

if(isset($_GET['limit']) && $_GET['limit']){
    $limit = $_GET['limit'];
}

$datas = $qb->select("WEWENANG","TOP $limit WEWENANG.*");
$limits = $qb1->select("WEWENANG","count(*) as count");

if(isset($_GET['filter'])){

    if($_GET['roles']){
        $datas->where('NM_WEWENANG',"%".$_GET['roles']."%",'like');
        $limits->where('NM_WEWENANG',"%".$_GET['roles']."%",'like');
    }

}

$datas = $datas->get();
$limits = $limits->first();
