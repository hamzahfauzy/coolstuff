<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();
$qb1 = new QueryBuilder();

$msg = get_flash_msg('success');

$limit = 10;

if(isset($_GET['limit']) && $_GET['limit']){
    $limit = $_GET['limit'];
}

$limits = $qb1->select("REF_KELURAHAN","count(*) as count");

$datas = $qb
            ->select("REF_KELURAHAN","TOP $limit REF_KELURAHAN.*, kecamatan.NM_KECAMATAN")
            ->leftJoin('REF_KECAMATAN as kecamatan','REF_KELURAHAN.KD_KECAMATAN','kecamatan.KD_KECAMATAN');

if(isset($_GET['filter'])){

    if($_GET['kecamatan']){
        $datas->where('REF_KELURAHAN.KD_KECAMATAN',$_GET['kecamatan']);
        $limits->where('KD_KECAMATAN',$_GET['kecamatan']);
    }

}

$datas = $datas->get();
$limits = $limits->first();

$kecamatans = $qb->select("REF_KECAMATAN")->get();