<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

if(isset($_GET['get-jalan']) && isset($_GET['filter-kelurahan']) && isset($_GET['filter-kecamatan']))
{
    $jalan = $qb->select("JALAN")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->where('KD_KELURAHAN',$_GET['filter-kelurahan'])->orderby('KD_ZNT')->get();
    echo json_encode($jalan);
    die();
}

if(isset($_GET['filter-blok']) && isset($_GET['filter-kelurahan']) && isset($_GET['filter-kecamatan'])){
    $znts = $qb->select("DAT_PETA_ZNT")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->where('KD_KELURAHAN',$_GET['filter-kelurahan'])->where('KD_BLOK',$_GET['filter-blok'])->orderby('KD_ZNT')->get();

    echo json_encode($znts);
    die;
}

if(isset($_GET['filter-kelurahan']) && isset($_GET['filter-kecamatan'])){
    $bloks = $qb->select("DAT_PETA_BLOK")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->where('KD_KELURAHAN',$_GET['filter-kelurahan'])->orderby('KD_BLOK')->get();

    echo json_encode($bloks);
    die;
}

if(isset($_GET['filter-kecamatan'])){
    $kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->orderby('KD_KELURAHAN')->get();

    echo json_encode($kelurahans);
    die;
}

if(isset($_GET['get-no-urut'])){
    $clauseBumi = "KD_PROPINSI + '.' + KD_DATI2 + '.' + KD_KECAMATAN + '.' + KD_KELURAHAN + '.' + KD_BLOK";
    $valBumi = "12.12.".$_GET['kecamatan'] . '.' . $_GET['kelurahan'] . '.' . $_GET['blok'];

    $cntsUrut = $qb->select("DAT_OP_BUMI")->where($clauseBumi,$valBumi)->orderBy('NO_URUT','DESC')->first();

    if($cntsUrut){
        echo json_encode("00" . strval($cntsUrut['NO_URUT']+1));
    }else{
        echo json_encode("001");
    }
    die;
}

// $clauseNOP = "KD_PROPINSI + '.' + KD_DATI2 + '.' + KD_KECAMATAN + '.' + KD_KELURAHAN + '.' + KD_BLOK + '-' + NO_URUT + '.' + KD_JNS_OP '";