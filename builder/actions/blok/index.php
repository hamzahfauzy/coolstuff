<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$qb1 = new QueryBuilder();
$qb2 = new QueryBuilder();

$msg = get_flash_msg('success');

if(isset($_GET['filter-kecamatan'])){
    $kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->orderby('KD_KELURAHAN')->get();

    echo json_encode($kelurahans);
    die;
}


$limit = 10;

if(isset($_GET['limit']) && $_GET['limit']){
    $limit = $_GET['limit'];
}

$datas = $qb
            ->select("DAT_PETA_BLOK","TOP $limit DAT_PETA_BLOK.*, kecamatan.NM_KECAMATAN, kelurahan.NM_KELURAHAN")
            ->leftJoin('REF_KECAMATAN as kecamatan','DAT_PETA_BLOK.KD_KECAMATAN','kecamatan.KD_KECAMATAN')
            ->leftJoin('REF_KELURAHAN as kelurahan','DAT_PETA_BLOK.KD_KECAMATAN','kelurahan.KD_KECAMATAN')
            ->andJoin('DAT_PETA_BLOK.KD_KELURAHAN','kelurahan.KD_KELURAHAN');

$kelurahans = $qb1->select("REF_KELURAHAN");   
$limits = $qb2->select("DAT_PETA_BLOK","count(*) as count");

if(isset($_GET['filter'])){

    if($_GET['kecamatan']){
        $datas->where('DAT_PETA_BLOK.KD_KECAMATAN',$_GET['kecamatan']);

        $kelurahans->where('KD_KECAMATAN',$_GET['kecamatan']);
        $limits->where('KD_KECAMATAN',$_GET['kecamatan']);
    }

    if($_GET['kelurahan']){
        $datas->where('DAT_PETA_BLOK.KD_KELURAHAN',$_GET['kelurahan']);
        $limits->where('KD_KELURAHAN',$_GET['kelurahan']);
    }
}

$datas = $datas->get();
$limits = $limits->first();

$kecamatans = $qb->select("REF_KECAMATAN")->get();
$kelurahans = $kelurahans->get();
