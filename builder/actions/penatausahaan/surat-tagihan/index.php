<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$failed = get_flash_msg('failed');
$qb = new QueryBuilder();

if(isset($_GET['filter-kecamatan'])){
    $kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->orderby('KD_KELURAHAN')->get();

    echo json_encode($kelurahans);
    die;
}

$kecamatans = $qb->select("REF_KECAMATAN")->orderby('KD_KECAMATAN')->get();

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

$year = date("Y");