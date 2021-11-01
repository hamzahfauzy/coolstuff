<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$qb = new QueryBuilder();
$qb1 = new QueryBuilder();

$limit = 10;

if(isset($_GET['limit']) && $_GET['limit']){
    $limit = $_GET['limit'];
}

$limits = $qb1->select("REF_KECAMATAN","count(*) as count");

$datas = $qb->select("REF_KECAMATAN","TOP $limit REF_KECAMATAN.*")->get();

$limits = $limits->first();
