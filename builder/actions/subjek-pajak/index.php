<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();
$qb1 = new QueryBuilder();
$qb2 = new QueryBuilder();
$qb3 = new QueryBuilder();

$msg = get_flash_msg('success');

if(isset($_GET['filter-kelurahan'])){
    $kels = explode("-",$_GET['filter-kelurahan']);
    $bloks = $qb->select("DAT_PETA_BLOK","KD_BLOK")->where('KD_KELURAHAN',$kels[0])->groupBy("KD_BLOK")->get();

    echo json_encode($bloks);
    die;
}

$limit = 10;

if(isset($_GET['limit']) && $_GET['limit']){
    $limit = $_GET['limit'];
}

$datas = $qb->select("DAT_SUBJEK_PAJAK","TOP $limit DAT_SUBJEK_PAJAK.*, REF_KELURAHAN.KD_KELURAHAN")
            ->leftJoin("REF_KELURAHAN","DAT_SUBJEK_PAJAK.KELURAHAN_WP","REF_KELURAHAN.NM_KELURAHAN");

$kelurahans = $qb1->select("REF_KELURAHAN");    
$bloks = $qb2->select("DAT_PETA_BLOK","KD_BLOK");
$limits = $qb3->select("DAT_SUBJEK_PAJAK","count(*) as count");

if(isset($_GET['filter'])){

    if($_GET['kelurahan']){

        $kels = explode("-",$_GET['kelurahan']);

        $datas->where('KD_KELURAHAN',trim($kels[0]))->where('NM_KELURAHAN',trim($kels[1]),'like');
        $bloks->where('KD_KELURAHAN',trim($kels[0]));
        $limits->where('KELURAHAN_WP',"%".trim($kels[1])."%",'like');
    }

    if($_GET['blok']){
        $datas->where('DAT_SUBJEK_PAJAK.BLOK_KAV_NO_WP',$_GET['blok']);
    }

    if($_GET['nama']){
        $datas->where('NM_WP',"%".$_GET['nama']."%",'like');
        $limits->where('NM_WP',"%".$_GET['nama']."%",'like');
    }

}

$datas = $datas->orderBy('NM_WP')->get();
$limits = $limits->first();

$kelurahans = $kelurahans->orderBy('KD_KELURAHAN')->get();
$bloks = $bloks->groupBy("KD_BLOK")->get();