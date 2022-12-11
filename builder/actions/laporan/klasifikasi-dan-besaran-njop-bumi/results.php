<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

extract($_GET);

$C_STR = "";

if($KD_KECAMATAN == 'Semua' && $KD_KELURAHAN == 'Semua')
{
    $C_STR = "SELECT JALAN.*, DAT_NIR.THN_NIR_ZNT, DAT_NIR.[NIR], REF_KECAMATAN.NM_KECAMATAN, REF_KELURAHAN.NM_KELURAHAN FROM (JALAN INNER JOIN DAT_NIR ON (JALAN.KD_ZNT = DAT_NIR.KD_ZNT) AND (JALAN.KD_KELURAHAN = DAT_NIR.KD_KELURAHAN) AND (JALAN.KD_KECAMATAN = DAT_NIR.KD_KECAMATAN)) INNER JOIN (REF_KELURAHAN INNER JOIN REF_KECAMATAN ON (REF_KELURAHAN.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN) AND (REF_KELURAHAN.KD_DATI2 = REF_KECAMATAN.KD_DATI2) AND (REF_KELURAHAN.KD_PROPINSI = REF_KECAMATAN.KD_PROPINSI)) ON (JALAN.KD_KELURAHAN = REF_KELURAHAN.KD_KELURAHAN) AND (JALAN.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN) WHERE DAT_NIR.THN_NIR_ZNT='" . $tahun_pajak . "'";

}
elseif($KD_KECAMATAN != 'Semua' && $KD_KELURAHAN == 'Semua')
{
    $C_STR = "SELECT JALAN.*, DAT_NIR.THN_NIR_ZNT, DAT_NIR.[NIR], REF_KECAMATAN.NM_KECAMATAN, REF_KELURAHAN.NM_KELURAHAN FROM (JALAN INNER JOIN DAT_NIR ON (JALAN.KD_ZNT = DAT_NIR.KD_ZNT) AND (JALAN.KD_KELURAHAN = DAT_NIR.KD_KELURAHAN) AND (JALAN.KD_KECAMATAN = DAT_NIR.KD_KECAMATAN)) INNER JOIN (REF_KELURAHAN INNER JOIN REF_KECAMATAN ON (REF_KELURAHAN.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN) AND (REF_KELURAHAN.KD_DATI2 = REF_KECAMATAN.KD_DATI2) AND (REF_KELURAHAN.KD_PROPINSI = REF_KECAMATAN.KD_PROPINSI)) ON (JALAN.KD_KELURAHAN = REF_KELURAHAN.KD_KELURAHAN) AND (JALAN.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN) WHERE DAT_NIR.THN_NIR_ZNT='" . $tahun_pajak . "' AND JALAN.KD_KECAMATAN='" . $KD_KECAMATAN . "'";
        
}else{
    $C_STR = "SELECT JALAN.*, DAT_NIR.THN_NIR_ZNT, DAT_NIR.[NIR], REF_KECAMATAN.NM_KECAMATAN, REF_KELURAHAN.NM_KELURAHAN FROM (JALAN INNER JOIN DAT_NIR ON (JALAN.KD_ZNT = DAT_NIR.KD_ZNT) AND (JALAN.KD_KELURAHAN = DAT_NIR.KD_KELURAHAN) AND (JALAN.KD_KECAMATAN = DAT_NIR.KD_KECAMATAN)) INNER JOIN (REF_KELURAHAN INNER JOIN REF_KECAMATAN ON (REF_KELURAHAN.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN) AND (REF_KELURAHAN.KD_DATI2 = REF_KECAMATAN.KD_DATI2) AND (REF_KELURAHAN.KD_PROPINSI = REF_KECAMATAN.KD_PROPINSI)) ON (JALAN.KD_KELURAHAN = REF_KELURAHAN.KD_KELURAHAN) AND (JALAN.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN) WHERE DAT_NIR.THN_NIR_ZNT='" . $tahun_pajak . "' AND JALAN.KD_KECAMATAN='" . $KD_KECAMATAN . "' AND JALAN.KD_KELURAHAN='" . $KD_KELURAHAN . "'";
}

$datas = $qb->rawQuery($C_STR)->get();

if(isset($mode) && $mode == 'cek_cetak')
{
    $vOP = [];
    foreach($datas as $key => $_data)
    {
        $vOP[$key] = [
            '',
            $key+1,
            $_data['KD_KECAMATAN'],
            $_data['NM_KECAMATAN'],
            $_data['KD_KELURAHAN'],
            $_data['NM_KELURAHAN'],
            $_data['NM_JLN'],
            $_data['NIR'],
            $_data['KD_ZNT'],
            $tahun_pajak,
            0,
            0,
            0,
            0,
            $_data['KD_BLOK'],
        ];

    }

    $qry = "SELECT THN_AWAL_KLS_TANAH  FROM KELAS_TANAH ORDER BY THN_AWAL_KLS_TANAH DESC";

    $thn_awal = $qb->rawQuery($qry)->first();

    $K_TAHUN = $thn_awal['THN_AWAL_KLS_TANAH'];

    $C_STR = "SELECT * FROM KELAS_TANAH WHERE THN_AWAL_KLS_TANAH ='" . $K_TAHUN . "' ORDER BY KD_KLS_TANAH ASC,THN_AWAL_KLS_TANAH DESC";

    $data = $qb->rawQuery($C_STR)->get();

    foreach ($data as $key => $value) {

        foreach ($vOP as $key2 => $value2) {
            if( $value2[7] >= $value['NILAI_MIN_TANAH'] && $value2[7] <= $value['NILAI_MAX_TANAH'] ){
                $vOP[$key2][10] = $value['KD_KLS_TANAH'];
                $vOP[$key2][11] = $value['NILAI_MIN_TANAH'] * 1000;
                $vOP[$key2][12] = $value['NILAI_MAX_TANAH'] * 1000;
                $vOP[$key2][13] = $value['NILAI_PER_M2_TANAH'] * 1000;
            }
        }

    }

    $D_STR = "DELETE  FROM TEMP_BUMI";

    $qb->rawQuery($D_STR)->exec();

    $xRec = count($vOP);

    foreach ($vOP as $key2 => $value2) {
        $xKode1 = $value2[2];
        $xKec = $value2[3];
        $xKode2 = $value2[4];
        $xKel = $value2[5];
        $xJALAN = $value2[6];
        $xZNT = $value2[8];
        $xTahun = $value2[9];
        $xKelas = $value2[10];
        $xMIN = $value2[11];
        $xMAX = $value2[12];
        $xNJOP = $value2[13];
        $xBLOK = $value2[14];

        $C_STR = "INSERT INTO TEMP_BUMI (KD_KECAMATAN,NM_KECAMATAN,KD_KELURAHAN, NM_KELURAHAN,[BLOK],NM_JALAN,KD_ZNT,THN_NIR,KLS_TANAH,NILAI_MIN,NILAI_MAX,NJOP) VALUES ('" . $xKode1 . "','" . $xKec . "','" . $xKode2 . "','" . $xKel . "','" . $xBLOK . "','" . $xJALAN . "','" . $xZNT . "','" . $xTahun . "','" . $xKelas . "','" . $xMIN . "','" . $xMAX . "','" . $xNJOP . "')";

        $qb->rawQuery($C_STR)->exec();
    }

    echo json_encode([
        'status'=>'success',
        'message'=>'',
    ]);
    die();

}

