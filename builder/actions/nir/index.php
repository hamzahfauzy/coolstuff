<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();
$qb1 = new QueryBuilder();
$qb2 = new QueryBuilder();
$qb3 = new QueryBuilder();
$qb4 = new QueryBuilder();

$msg = get_flash_msg('success');

if(isset($_GET['filter-kelurahan']) && isset($_GET['filter-kecamatan'])){
    $znts = $qb->select("DAT_PETA_ZNT")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->where('KD_KELURAHAN',$_GET['filter-kelurahan'])->get();

    echo json_encode($znts);
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
            ->select("DAT_NIR","TOP $limit DAT_NIR.*, kecamatan.NM_KECAMATAN, kelurahan.NM_KELURAHAN")
            ->leftJoin('REF_KECAMATAN as kecamatan','DAT_NIR.KD_KECAMATAN','kecamatan.KD_KECAMATAN')
            ->leftJoin('REF_KELURAHAN as kelurahan','DAT_NIR.KD_KECAMATAN','kelurahan.KD_KECAMATAN')
            ->andJoin('DAT_NIR.KD_KELURAHAN','kelurahan.KD_KELURAHAN');

$kelurahans = $qb1->select("REF_KELURAHAN");
$znts = $qb2->select("DAT_PETA_ZNT"); 
$limits = $qb3->select("DAT_NIR","count(*) as count");
$tahuns = $qb4->select("DAT_NIR","THN_NIR_ZNT");

if(isset($_GET['filter'])){

    if($_GET['kecamatan']){
        $datas->where('DAT_NIR.KD_KECAMATAN',$_GET['kecamatan']);
        
        $kelurahans->where('KD_KECAMATAN',$_GET['kecamatan']);
        $znts->where('KD_KECAMATAN',$_GET['kecamatan']);
        $limits->where('KD_KECAMATAN',$_GET['kecamatan']);
        $tahuns->where('KD_KECAMATAN',$_GET['kecamatan']);
    }
    
    if($_GET['kelurahan']){
        $datas->where('DAT_NIR.KD_KELURAHAN',$_GET['kelurahan']);
        $znts->where('KD_KELURAHAN',$_GET['kelurahan']);
        $limits->where('KD_KELURAHAN',$_GET['kelurahan']);
        $tahuns->where('KD_KELURAHAN',$_GET['kelurahan']);
    }
    
    if($_GET['znt']){
        $datas->where('DAT_NIR.KD_ZNT',$_GET['znt']);
        $limits->where('KD_ZNT',$_GET['znt']);
        $tahuns->where('KD_ZNT',$_GET['znt']);
    }

    if($_GET['tahun']){
        $datas->where('DAT_NIR.THN_NIR_ZNT',$_GET['tahun']);
        $limits->where('THN_NIR_ZNT',$_GET['tahun']);
    }
}


$datas = $datas->get();

$kecamatans = $qb->select("REF_KECAMATAN")->get();
$kelurahans = $kelurahans->get();
$znts = $znts->get();

$limits = $limits->first();
$tahuns = $tahuns->groupBy("THN_NIR_ZNT")->orderBy("THN_NIR_ZNT","DESC")->get();