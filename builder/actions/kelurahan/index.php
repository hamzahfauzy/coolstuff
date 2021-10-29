<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$datas = $qb
            ->select("REF_KELURAHAN","REF_KELURAHAN.*, kecamatan.NM_KECAMATAN")
            ->join('REF_KECAMATAN as kecamatan','REF_KELURAHAN.KD_KECAMATAN','kecamatan.KD_KECAMATAN');

if(isset($_GET['filter'])){

    if($_GET['kecamatan']){
        $datas->where('REF_KELURAHAN.KD_KECAMATAN',$_GET['kecamatan']);
    }

}

$datas = $datas->get();

$kecamatans = $qb->select("REF_KECAMATAN")->get();