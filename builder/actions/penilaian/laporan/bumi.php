<?php
require '../helpers/QueryBuilder.php';
$qb = new QueryBuilder;
$qb1 = new QueryBuilder;
if(isset($_GET['filter-kecamatan'])){
    $kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->orderBy('KD_KELURAHAN')->get();

    echo json_encode($kelurahans);
    die;
}

$kelurahans = $qb1->select("REF_KELURAHAN");
$kecamatans = $qb->select("REF_KECAMATAN")->orderBy('KD_KECAMATAN')->get();
$datas = [];

if(isset($_GET['filter']))
{
    $query = "
    SELECT 
        DAT_NIR.THN_NIR_ZNT, DAT_NIR.NIR, QOBJEKPAJAK.JALAN_OP, QOBJEKPAJAK.TOTAL_LUAS_BUMI, 
        QOBJEKPAJAK.NJOP_BUMI, QOBJEKPAJAK.NM_KECAMATAN, QOBJEKPAJAK.NM_KELURAHAN, 
        QOBJEKPAJAK.NOPQ, QOBJEKPAJAK.NM_WP, QOBJEKPAJAK.JALAN_WP, QOBJEKPAJAK.KD_ZNT, 
        QOBJEKPAJAK.NILAI_SISTEM_BUMI, QOBJEKPAJAK.JNS_BUMI
    FROM 
        QOBJEKPAJAK 
    INNER JOIN 
        DAT_NIR 
        ON 
            (QOBJEKPAJAK.KD_Kecamatan = DAT_NIR.KD_KECAMATAN) AND 
            (QOBJEKPAJAK.KD_KELURAHAN = DAT_NIR.KD_KELURAHAN) AND 
            (QOBJEKPAJAK.KD_ZNT = DAT_NIR.KD_ZNT)
    WHERE 
        (((DAT_NIR.THN_NIR_ZNT)='$_GET[tahun]')) AND
        (DAT_NIR.KD_KECAMATAN = '$_GET[kecamatan]') AND
        (DAT_NIR.KD_KELURAHAN = '$_GET[kelurahan]')
        ";

    $datas = $qb->rawQuery($query)->get();
    $kelurahans->where('KD_KECAMATAN',$_GET['kecamatan']);
}

$kelurahans = $kelurahans->orderBy('KD_KELURAHAN')->get();