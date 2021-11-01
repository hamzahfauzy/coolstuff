<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();
$qb1 = new QueryBuilder();
$qb2 = new QueryBuilder();
$qb3 = new QueryBuilder();

$msg = get_flash_msg('success');

if(isset($_GET['filter-kelurahan']) && isset($_GET['filter-kecamatan'])){
    $bloks = $qb->select("DAT_PETA_BLOK")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->where('KD_KELURAHAN',$_GET['filter-kelurahan'])->get();

    echo json_encode($bloks);
    die;
}

if(isset($_GET['filter-kecamatan'])){
    $kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->get();

    echo json_encode($kelurahans);
    die;
}

$limit = 10;

if(isset($_GET['limit']) && $_GET['limit']){
    $limit = $_GET['limit'];
}

$datas = $qb
            ->select("DAT_PETA_ZNT","TOP $limit DAT_PETA_ZNT.*, kecamatan.NM_KECAMATAN, kelurahan.NM_KELURAHAN")
            ->leftJoin('REF_KECAMATAN as kecamatan','DAT_PETA_ZNT.KD_KECAMATAN','kecamatan.KD_KECAMATAN')
            ->leftJoin('REF_KELURAHAN as kelurahan','DAT_PETA_ZNT.KD_KECAMATAN','kelurahan.KD_KECAMATAN')
            ->andJoin('DAT_PETA_ZNT.KD_KELURAHAN','kelurahan.KD_KELURAHAN');

$kelurahans = $qb1->select("REF_KELURAHAN");   
$bloks = $qb2->select("DAT_PETA_BLOK");   
$limits = $qb3->select("DAT_PETA_ZNT","count(*) as count");

if(isset($_GET['filter'])){

    if($_GET['kecamatan']){
        $datas->where('DAT_PETA_ZNT.KD_KECAMATAN',$_GET['kecamatan']);

        $kelurahans->where('KD_KECAMATAN',$_GET['kecamatan']);
        $bloks->where('KD_KECAMATAN',$_GET['kecamatan']);
        $limits->where('KD_KECAMATAN',$_GET['kecamatan']);
    }
    
    if($_GET['kelurahan']){
        $datas->where('DAT_PETA_ZNT.KD_KELURAHAN',$_GET['kelurahan']);
        $bloks->where('KD_KELURAHAN',$_GET['kelurahan']);
        $limits->where('KD_KELURAHAN',$_GET['kelurahan']);
    }

    if($_GET['blok']){
        $datas->where('DAT_PETA_ZNT.KD_BLOK',$_GET['blok']);
        $limits->where('KD_BLOK',$_GET['blok']);
    }
}

$datas = $datas->get();
$limits = $limits->first();

$kecamatans = $qb->select("REF_KECAMATAN")->get();
$kelurahans = $kelurahans->get();
$bloks = $bloks->get();
