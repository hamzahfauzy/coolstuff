<?php

require '../helpers/QueryBuilder.php';

$mysql = new QueryBuilder("mysql");
$mysql2 = new QueryBuilder("mysql");
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

$datas = $mysql->select("subjek_pajak");

$kelurahans = $qb1->select("REF_KELURAHAN");    
$bloks = $qb2->select("DAT_PETA_BLOK","KD_BLOK");
$limits = $mysql2->select("subjek_pajak","count(*) as count");

if(isset($_GET['filter'])){

    if($_GET['kelurahan']){
        $datas->where('KELURAHAN_WP','%'.$_GET['kelurahan'].'%', 'like');
        $bloks->where('KD_KELURAHAN',trim($kels[0]));
        $limits->where('KELURAHAN_WP',"%".trim($kels[1])."%",'like');
    }

    if($_GET['blok']){
        $datas->where('BLOK_KAV_NO_WP',$_GET['blok']);
    }

    if($_GET['nama']){
        $datas->where('NM_WP',"%".$_GET['nama']."%",'like');
        $limits->where('NM_WP',"%".$_GET['nama']."%",'like');
    }

}

$pekerjaans = [
    '1' => 'PNS',
    '2' => 'TNI/Polri',
    '3' => 'Pensiunan',
    '4' => 'Badan',
    '5' => 'Lainnya'
];

$datas = $datas->orderBy('NM_WP')->limit($limit)->get();
$datas = array_map(function($d) use ($pekerjaans){
    $d['STATUS_PEKERJAAN_WP'] = isset($pekerjaans[$d['STATUS_PEKERJAAN_WP']]) ? $pekerjaans[$d['STATUS_PEKERJAAN_WP']] : $d['STATUS_PEKERJAAN_WP'];
    return $d;
}, $datas);

$limits = $limits->first();

$kelurahans = $kelurahans->orderBy('KD_KELURAHAN')->get();
$bloks = $bloks->groupBy("KD_BLOK")->get();