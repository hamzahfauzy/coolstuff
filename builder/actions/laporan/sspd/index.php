<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$kecamatans = $qb->select('REF_KECAMATAN')->orderBy('KD_KECAMATAN')->get();

if(isset($_GET['get-kelurahan']))
{
    $kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$_GET['KD_KECAMATAN'])->orderBy('KD_KELURAHAN')->get();

    echo json_encode($kelurahans);
    die;
}

if(isset($_GET['get-jumlah-sppt']))
{
    $sppt = $qb->select('QOBJEKPAJAK');

    if($_GET['KD_KECAMATAN'] != 'Semua')
        $sppt = $sppt->where('KD_KECAMATAN',$_GET['KD_KECAMATAN']);
    if($_GET['KD_KELURAHAN'] != 'Semua')
        $sppt = $sppt->where('KD_KELURAHAN',$_GET['KD_KELURAHAN']);
    
    $sppt = $sppt->orderBy('NO_URUT')->first();

    echo $sppt['NO_URUT'];
    die();
}