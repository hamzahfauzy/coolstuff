<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();
$qb1 = new QueryBuilder();
$qb2 = new QueryBuilder();
$qb3 = new QueryBuilder();
$qb4 = new QueryBuilder();

$msg = get_flash_msg('success');

if(isset($_GET['filter-blok']) && isset($_GET['filter-kelurahan']) && isset($_GET['filter-kecamatan'])){
    $znts = $qb->select("DAT_PETA_ZNT")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->where('KD_KELURAHAN',$_GET['filter-kelurahan'])->where('KD_BLOK',$_GET['filter-blok'])->get();

    echo json_encode($znts);
    die;
}

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
            ->select("DAT_OP_BUMI","TOP $limit DAT_OP_BUMI.*, kecamatan.NM_KECAMATAN, kelurahan.NM_KELURAHAN")
            ->leftJoin('REF_KECAMATAN as kecamatan','DAT_OP_BUMI.KD_KECAMATAN','kecamatan.KD_KECAMATAN')
            ->leftJoin('REF_KELURAHAN as kelurahan','DAT_OP_BUMI.KD_KECAMATAN','kelurahan.KD_KECAMATAN')
            ->andJoin('DAT_OP_BUMI.KD_KELURAHAN','kelurahan.KD_KELURAHAN');

$kelurahans = $qb1->select("REF_KELURAHAN");   
$bloks = $qb2->select("DAT_PETA_BLOK"); 
$znts = $qb3->select("DAT_PETA_ZNT"); 
$limits = $qb4->select("DAT_OP_BUMI","count(*) as count");

$jenisBumi = ["01-TANAH DAN BANGUNAN","02-KAVLING SIAP BANGUN","03-TANAH KOSONG","04-FASILITAS UMUM"];

if(isset($_GET['filter'])){

    if($_GET['kecamatan']){
        $datas->where('DAT_OP_BUMI.KD_KECAMATAN',$_GET['kecamatan']);

        $kelurahans->where('KD_KECAMATAN',$_GET['kecamatan']);
        $bloks->where('KD_KECAMATAN',$_GET['kecamatan']);
        $znts->where('KD_KECAMATAN',$_GET['kecamatan']);
        $limits->where('KD_KECAMATAN',$_GET['kecamatan']);
    }

    if($_GET['kelurahan']){
        $datas->where('DAT_OP_BUMI.KD_KELURAHAN',$_GET['kelurahan']);
        $bloks->where('KD_KELURAHAN',$_GET['kelurahan']);
        $znts->where('KD_KELURAHAN',$_GET['kelurahan']);
        $limits->where('KD_KELURAHAN',$_GET['kelurahan']);
    }
    
    if($_GET['blok']){
        $datas->where('DAT_OP_BUMI.KD_BLOK',$_GET['blok']);
        $znts->where('KD_BLOK',$_GET['blok']);
        $limits->where('KD_BLOK',$_GET['blok']);
    }

    if($_GET['znt']){
        $datas->where('DAT_OP_BUMI.KD_ZNT',$_GET['znt']);
        $limits->where('KD_ZNT',$_GET['znt']);
    }
}


$datas = $datas->orderBy("NO_URUT","DESC")->get();

$kecamatans = $qb->select("REF_KECAMATAN")->get();
$kelurahans = $kelurahans->get();
$bloks = $bloks->get();
$znts = $znts->get();

$limits = $limits->first();