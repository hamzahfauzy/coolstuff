<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$qb1 = new QueryBuilder();

$msg = get_flash_msg('success');

if(isset($_GET['filter-kecamatan'])){
    $kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->get();

    echo json_encode($kelurahans);
    die;
}

$datas = $qb
            ->select("DAT_PETA_BLOK","DAT_PETA_BLOK.*, kecamatan.NM_KECAMATAN, kelurahan.NM_KELURAHAN")
            ->join('REF_KECAMATAN as kecamatan','DAT_PETA_BLOK.KD_KECAMATAN','kecamatan.KD_KECAMATAN')
            ->join('REF_KELURAHAN as kelurahan','DAT_PETA_BLOK.KD_KECAMATAN','kelurahan.KD_KECAMATAN')
            ->andJoin('DAT_PETA_BLOK.KD_KELURAHAN','kelurahan.KD_KELURAHAN');

$kelurahans = $qb1->select("REF_KELURAHAN");   

if(isset($_GET['filter'])){

    if($_GET['kecamatan']){
        $datas->where('DAT_PETA_BLOK.KD_KECAMATAN',$_GET['kecamatan']);

        $kelurahans->where('KD_KECAMATAN',$_GET['kecamatan']);
    }

    if($_GET['kelurahan']){
        $datas->where('DAT_PETA_BLOK.KD_KELURAHAN',$_GET['kelurahan']);
    }
}

$datas = $datas->get();

$kecamatans = $qb->select("REF_KECAMATAN")->get();
$kelurahans = $kelurahans->get();
