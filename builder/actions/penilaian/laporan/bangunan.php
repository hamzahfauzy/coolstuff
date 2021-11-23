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
            DAT_OP_BANGUNAN.NO_BNG, DAT_OP_BANGUNAN.NO_FORMULIR_LSPOP, 
            DAT_OP_BANGUNAN.THN_DIBANGUN_BNG, DAT_OP_BANGUNAN.THN_RENOVASI_BNG, 
            DAT_OP_BANGUNAN.LUAS_BNG, DAT_OP_BANGUNAN.JML_LANTAI_BNG, 
            DAT_OP_BANGUNAN.KONDISI_BNG, DAT_OP_BANGUNAN.JNS_KONSTRUKSI_BNG, 
            DAT_OP_BANGUNAN.NILAI_SISTEM_BNG, DAT_OP_BANGUNAN.K_UTAMA, 
            DAT_OP_BANGUNAN.K_MATERIAL, DAT_OP_BANGUNAN.K_FASILITAS, 
            DAT_OP_BANGUNAN.J_SUSUT, DAT_OP_BANGUNAN.K_SUSUT, DAT_OP_BANGUNAN.K_NON_SUSUT, 
            DAT_OP_BANGUNAN.KD_JPB, QOBJEKPAJAK.SUBJEK_PAJAK_ID, QOBJEKPAJAK.NM_WP, 
            QOBJEKPAJAK.JALAN_WP, QOBJEKPAJAK.KELURAHAN_WP, QOBJEKPAJAK.KOTA_WP, 
            QOBJEKPAJAK.JALAN_OP, QOBJEKPAJAK.NM_KECAMATAN, QOBJEKPAJAK.NM_KELURAHAN, 
            QOBJEKPAJAK.NOPQ, REF_JPB.NM_JPB
        FROM 
            (DAT_OP_BANGUNAN 
            INNER JOIN REF_JPB 
                ON DAT_OP_BANGUNAN.KD_JPB = REF_JPB.KD_JPB) 
            INNER JOIN QOBJEKPAJAK 
                ON (DAT_OP_BANGUNAN.KD_JNS_OP = QOBJEKPAJAK.KD_JNS_OP) 
                AND (DAT_OP_BANGUNAN.NO_URUT = QOBJEKPAJAK.NO_URUT) 
                AND (DAT_OP_BANGUNAN.KD_BLOK = QOBJEKPAJAK.KD_BLOK) 
                AND (DAT_OP_BANGUNAN.KD_KELURAHAN = QOBJEKPAJAK.KD_KELURAHAN) 
                AND (DAT_OP_BANGUNAN.KD_KECAMATAN = QOBJEKPAJAK.KD_Kecamatan)
        WHERE
            DAT_OP_BANGUNAN.KD_KECAMATAN = '$_GET[kecamatan]' AND
            DAT_OP_BANGUNAN.KD_KELURAHAN = '$_GET[kelurahan]'
        
        ORDER BY
            QOBJEKPAJAK.NOPQ
        ";

    $datas = $qb->rawQuery($query)->get();
    $kelurahans->where('KD_KECAMATAN',$_GET['kecamatan']);
}

if(isset($_GET['cetak']))
{
    header("location:index.php?page=builder/penilaian/laporan/cetak-bangunan&tahun=$_GET[tahun]&kecamatan=$_GET[kecamatan]&kelurahan=$_GET[kelurahan]");
    die();
}


$kelurahans = $kelurahans->orderBy('KD_KELURAHAN')->get();