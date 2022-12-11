<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$qb = new QueryBuilder();
$qb1 = new QueryBuilder();

$limit = 10;

if(isset($_GET['limit']) && $_GET['limit']){
    $limit = $_GET['limit'];
}

$datas = $qb->select("PEJABAT","TOP $limit PEJABAT.*");
$limits = $qb1->select("PEJABAT","count(*) as count");


if(isset($_GET['filter'])){

    if($_GET['pejabat']){
        $datas->where('NAMA',"%".$_GET['pejabat']."%",'like');
        $limits->where('NAMA',"%".$_GET['pejabat']."%",'like');
    }

}

$datas = $datas->get();
$limits = $limits->first();
