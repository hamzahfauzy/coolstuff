<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

extract($_GET);

$query = "
    SELECT REF_MAP.KD_MAP, REF_JNS_SEKTOR.NM_SEKTOR, SPPT.PROSES,
    [SPPT].[KD_PROPINSI]+'.'+[SPPT].[KD_DATI2]+'.'+[SPPT].[KD_KECAMATAN]+'.'+[SPPT].[KD_KELURAHAN]+'.'+[SPPT].[KD_BLOK]+'-'+[SPPT].[NO_URUT]+'.'+[SPPT].[KD_JNS_OP] AS NOPQ, 
    SPPT.KD_KECAMATAN, SPPT.KD_KELURAHAN, SPPT.THN_PAJAK_SPPT, SPPT.NM_WP_SPPT, 
    SPPT.JLN_WP_SPPT, SPPT.BLOK_KAV_NO_WP_SPPT, SPPT.RW_WP_SPPT, SPPT.RT_WP_SPPT, 
    SPPT.KELURAHAN_WP_SPPT, SPPT.KOTA_WP_SPPT, SPPT.KD_POS_WP_SPPT, SPPT.NPWP_SPPT, 
    SPPT.NO_PERSIL_SPPT, SPPT.KD_KLS_TANAH, SPPT.KD_KLS_BNG, SPPT.LUAS_BUMI_SPPT, 
    SPPT.LUAS_BNG_SPPT, SPPT.NJOP_BUMI_SPPT, SPPT.NJOP_BNG_SPPT, SPPT.NJOP_SPPT, 
    SPPT.NJOPTKP_SPPT, SPPT.NJKP_SPPT, SPPT.PBB_TERHUTANG_SPPT, SPPT.FAKTOR_PENGURANG_SPPT, 
    SPPT.PBB_YG_HARUS_DIBAYAR_SPPT, SPPT.TGL_JATUH_TEMPO_SPPT, SPPT.TGL_TERBIT_SPPT, 
    SPPT.TGL_CETAK_SPPT, TEMPAT_BAYAR.NM_TP, 
    QOBJEKPAJAK.NM_WP, 
    QOBJEKPAJAK.JALAN_WP, 
    QOBJEKPAJAK.KELURAHAN_WP, 
    QOBJEKPAJAK.KOTA_WP, 
    QOBJEKPAJAK.NPWP, 
    QOBJEKPAJAK.JALAN_OP, QOBJEKPAJAK.BLOK_KAV_NO_OP, 
    QOBJEKPAJAK.RW_OP, QOBJEKPAJAK.RT_OP, QOBJEKPAJAK.NM_KECAMATAN, QOBJEKPAJAK.NM_KELURAHAN, 
    QOBJEKPAJAK.TGL_PEREKAMAN_OP 
    FROM 
    QOBJEKPAJAK 
    INNER JOIN (
                (
                    (
                        SPPT INNER JOIN REF_KELURAHAN 
                        ON 
                            (SPPT.KD_KECAMATAN = REF_KELURAHAN.KD_KECAMATAN) AND 
                            (SPPT.KD_KELURAHAN = REF_KELURAHAN.KD_KELURAHAN)
                    ) 
                    INNER JOIN 
                        (
                            REF_JNS_SEKTOR INNER JOIN REF_MAP 
                            ON 
                                REF_JNS_SEKTOR.KD_SEKTOR = REF_MAP.KD_SEKTOR
                        ) 
                    ON REF_KELURAHAN.KD_SEKTOR = REF_MAP.KD_SEKTOR
                ) 
                INNER JOIN TEMPAT_BAYAR ON SPPT.KD_TP = TEMPAT_BAYAR.KD_TP
            ) 
            ON 
                (QOBJEKPAJAK.KD_JNS_OP = SPPT.KD_JNS_OP) AND 
                (QOBJEKPAJAK.NO_URUT = SPPT.NO_URUT) AND 
                (QOBJEKPAJAK.KD_BLOK = SPPT.KD_BLOK) AND 
                (QOBJEKPAJAK.KD_KELURAHAN = SPPT.KD_KELURAHAN) AND 
                (QOBJEKPAJAK.KD_Kecamatan = SPPT.KD_KECAMATAN) 
            WHERE 
                QOBJEKPAJAK.NOPQ='" .$NOP. "' AND 
                (((SPPT.THN_PAJAK_SPPT)='" .$tahun_pajak. "'))
    ORDER BY 
    SPPT.KD_KECAMATAN, 
    SPPT.KD_KELURAHAN, 
    SPPT.KD_BLOK, 
    SPPT.NO_URUT, 
    SPPT.KD_JNS_OP
";


$C_STR = "SELECT * FROM PEJABAT";
$pejabat = $qb->rawQuery($C_STR)->get();
foreach($pejabat as $pj)
{
    $xNIP = $pj['NIP'];
    $xNama = $pj['NAMA'];
    $xJabatan = $pj['JABATAN'];
}

$data = $qb->rawQuery($query)->first();

