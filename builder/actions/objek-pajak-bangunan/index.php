<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();
$qb1 = new QueryBuilder();
$qb2 = new QueryBuilder();
$qb3 = new QueryBuilder();
$qb4 = new QueryBuilder();

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
            ->select("DAT_OP_BANGUNAN","TOP $limit DAT_OP_BANGUNAN.*, jpb.NM_JPB_JPT, kecamatan.NM_KECAMATAN, kelurahan.NM_KELURAHAN")
            ->leftJoin('REF_KECAMATAN as kecamatan','DAT_OP_BANGUNAN.KD_KECAMATAN','kecamatan.KD_KECAMATAN')
            ->leftJoin('JPB_JPT as jpb','DAT_OP_BANGUNAN.KD_JPB','jpb.KD_JPB_JPT')
            ->leftJoin('REF_KELURAHAN as kelurahan','DAT_OP_BANGUNAN.KD_KECAMATAN','kelurahan.KD_KECAMATAN')
            ->andJoin('DAT_OP_BANGUNAN.KD_KELURAHAN','kelurahan.KD_KELURAHAN');

$kelurahans = $qb1->select("REF_KELURAHAN");   
$bloks = $qb2->select("DAT_PETA_BLOK"); 
$limits = $qb4->select("DAT_OP_BANGUNAN","count(*) as count");

$kondisi = ["01-Sangat Baik","02-Baik","03-Sedang","04-Jelek"];
$konstruksi = ["01-Baja","02-Beton","03-Batu Bata","04-Kayu"];
$atap = ["01-Decrabon/Beton/Gtg Glazur","02-Gtg Beton/Aluminium","03-Gtg Biasa/Sirap","04-Asbes","05-Seng"];
$dinding = ["01-Kaca/Aluminium","02-Beton","03-Batu Bata/Conblok","04-Kayu","05-Seng","06-Spandex"];
$lantai = ["01-Marmer","02-Keramik","03-Teraso","04-Ubin PC/Papan","05-Semen"];
$langit = ["01-Akuistik/Jati","02-Triplek/Asbes/Bambu","30-Tidak Ada"];

if(isset($_GET['filter'])){

    if($_GET['kecamatan']){
        $datas->where('DAT_OP_BANGUNAN.KD_KECAMATAN',$_GET['kecamatan']);

        $kelurahans->where('KD_KECAMATAN',$_GET['kecamatan']);
        $bloks->where('KD_KECAMATAN',$_GET['kecamatan']);
        $limits->where('KD_KECAMATAN',$_GET['kecamatan']);
    }

    if($_GET['kelurahan']){
        $datas->where('DAT_OP_BANGUNAN.KD_KELURAHAN',$_GET['kelurahan']);
        $bloks->where('KD_KELURAHAN',$_GET['kelurahan']);
        $limits->where('KD_KELURAHAN',$_GET['kelurahan']);
    }
    
    if($_GET['blok']){
        $datas->where('DAT_OP_BANGUNAN.KD_BLOK',$_GET['blok']);
        $limits->where('KD_BLOK',$_GET['blok']);
    }
}


$datas = $datas->orderBy("NO_URUT","DESC")->get();

$kecamatans = $qb->select("REF_KECAMATAN")->get();
$kelurahans = $kelurahans->get();
$bloks = $bloks->get();
$limits = $limits->first();