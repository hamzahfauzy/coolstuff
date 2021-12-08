<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();
$qb = new QueryBuilder();

extract($_GET);

$QQ = 0;
$query = "";
$q_bayar = "";

if($KD_KECAMATAN == 'Semua')
{
    $QQ = 1;
    $q_bayar = "SELECT * FROM PEMBAYARAN_SPPT WHERE THN_PAJAK_SPPT='" .$tahun_pajak. "' ";
    $query = "
            SELECT REF_MAP.KD_MAP, REF_JNS_SEKTOR.NM_SEKTOR, SPPT.PROSES,[SPPT].[KD_PROPINSI]+'.'+[SPPT].[KD_DATI2]+'.'+[SPPT].[KD_KECAMATAN]+'.'+[SPPT].[KD_KELURAHAN]+'.'+[SPPT].[KD_BLOK]+'-'+[SPPT].[NO_URUT]+'.'+[SPPT].[KD_JNS_OP] AS NOPQ, 
                SPPT.KD_KECAMATAN, SPPT.KD_KELURAHAN, SPPT.THN_PAJAK_SPPT, SPPT.NM_WP_SPPT, SPPT.JLN_WP_SPPT, SPPT.BLOK_KAV_NO_WP_SPPT, 
                SPPT.RW_WP_SPPT, SPPT.RT_WP_SPPT, SPPT.KELURAHAN_WP_SPPT, SPPT.KOTA_WP_SPPT, SPPT.KD_POS_WP_SPPT, SPPT.NPWP_SPPT, 
                SPPT.NO_PERSIL_SPPT, SPPT.KD_KLS_TANAH, SPPT.KD_KLS_BNG, SPPT.LUAS_BUMI_SPPT, SPPT.LUAS_BNG_SPPT, SPPT.NJOP_BUMI_SPPT, 
                SPPT.NJOP_BNG_SPPT, SPPT.NJOP_SPPT, SPPT.NJOPTKP_SPPT, SPPT.NJKP_SPPT, SPPT.PBB_TERHUTANG_SPPT, SPPT.FAKTOR_PENGURANG_SPPT, 
                SPPT.PBB_YG_HARUS_DIBAYAR_SPPT, SPPT.TGL_JATUH_TEMPO_SPPT, SPPT.TGL_TERBIT_SPPT, SPPT.TGL_CETAK_SPPT, TEMPAT_BAYAR.NM_TP, 
                QOBJEKPAJAK.JALAN_OP, QOBJEKPAJAK.BLOK_KAV_NO_OP, QOBJEKPAJAK.RW_OP, QOBJEKPAJAK.RT_OP, QOBJEKPAJAK.NM_KECAMATAN, 
                QOBJEKPAJAK.NM_KELURAHAN, QOBJEKPAJAK.TGL_PEREKAMAN_OP 
            FROM 
                QOBJEKPAJAK 
            INNER JOIN (((SPPT INNER JOIN REF_KELURAHAN ON 
                (SPPT.KD_KECAMATAN = REF_KELURAHAN.KD_KECAMATAN) AND 
                (SPPT.KD_KELURAHAN = REF_KELURAHAN.KD_KELURAHAN)) 
            INNER JOIN (REF_JNS_SEKTOR INNER JOIN REF_MAP ON REF_JNS_SEKTOR.KD_SEKTOR = REF_MAP.KD_SEKTOR) ON 
                REF_KELURAHAN.KD_SEKTOR = REF_MAP.KD_SEKTOR) 
            INNER JOIN TEMPAT_BAYAR ON SPPT.KD_TP = TEMPAT_BAYAR.KD_TP) ON 
                (QOBJEKPAJAK.KD_JNS_OP = SPPT.KD_JNS_OP) AND 
                (QOBJEKPAJAK.NO_URUT = SPPT.NO_URUT) AND 
                (QOBJEKPAJAK.KD_BLOK = SPPT.KD_BLOK) AND 
                (QOBJEKPAJAK.KD_KELURAHAN = SPPT.KD_KELURAHAN) AND 
                (QOBJEKPAJAK.KD_Kecamatan = SPPT.KD_KECAMATAN) 
            WHERE 
                (((SPPT.THN_PAJAK_SPPT)='" . $tahun_pajak . "')) 
            ORDER BY 
                SPPT.KD_KECAMATAN, SPPT.KD_KELURAHAN, SPPT.KD_BLOK, SPPT.NO_URUT, SPPT.KD_JNS_OP
    ";

}
else
{
    if($KD_KELURAHAN == 'Semua')
    {
        $QQ = 2;
        $q_bayar = "SELECT * FROM PEMBAYARAN_SPPT WHERE THN_PAJAK_SPPT='" .$tahun_pajak. "' AND KD_KECAMATAN='" .$KD_KECAMATAN. "'";
        $query = "
                SELECT REF_MAP.KD_MAP, REF_JNS_SEKTOR.NM_SEKTOR, SPPT.PROSES,[SPPT].[KD_PROPINSI]+'.'+[SPPT].[KD_DATI2]+'.'+[SPPT].[KD_KECAMATAN]+'.'+[SPPT].[KD_KELURAHAN]+'.'+[SPPT].[KD_BLOK]+'-'+[SPPT].[NO_URUT]+'.'+[SPPT].[KD_JNS_OP] AS NOPQ, 
                    SPPT.KD_KECAMATAN, SPPT.KD_KELURAHAN, SPPT.THN_PAJAK_SPPT, SPPT.NM_WP_SPPT, SPPT.JLN_WP_SPPT, SPPT.BLOK_KAV_NO_WP_SPPT, 
                    SPPT.RW_WP_SPPT, SPPT.RT_WP_SPPT, SPPT.KELURAHAN_WP_SPPT, SPPT.KOTA_WP_SPPT, SPPT.KD_POS_WP_SPPT, SPPT.NPWP_SPPT, 
                    SPPT.NO_PERSIL_SPPT, SPPT.KD_KLS_TANAH, SPPT.KD_KLS_BNG, SPPT.LUAS_BUMI_SPPT, SPPT.LUAS_BNG_SPPT, SPPT.NJOP_BUMI_SPPT, 
                    SPPT.NJOP_BNG_SPPT, SPPT.NJOP_SPPT, SPPT.NJOPTKP_SPPT, SPPT.NJKP_SPPT, SPPT.PBB_TERHUTANG_SPPT, SPPT.FAKTOR_PENGURANG_SPPT, 
                    SPPT.PBB_YG_HARUS_DIBAYAR_SPPT, SPPT.TGL_JATUH_TEMPO_SPPT, SPPT.TGL_TERBIT_SPPT, SPPT.TGL_CETAK_SPPT, TEMPAT_BAYAR.NM_TP, 
                    QOBJEKPAJAK.JALAN_OP, QOBJEKPAJAK.BLOK_KAV_NO_OP, QOBJEKPAJAK.RW_OP, QOBJEKPAJAK.RT_OP, QOBJEKPAJAK.NM_KECAMATAN, 
                    QOBJEKPAJAK.NM_KELURAHAN, QOBJEKPAJAK.TGL_PEREKAMAN_OP 
                FROM 
                    QOBJEKPAJAK 
                INNER JOIN (((SPPT INNER JOIN REF_KELURAHAN ON 
                    (SPPT.KD_KECAMATAN = REF_KELURAHAN.KD_KECAMATAN) AND 
                    (SPPT.KD_KELURAHAN = REF_KELURAHAN.KD_KELURAHAN)) 
                INNER JOIN (REF_JNS_SEKTOR INNER JOIN REF_MAP ON REF_JNS_SEKTOR.KD_SEKTOR = REF_MAP.KD_SEKTOR) ON 
                    REF_KELURAHAN.KD_SEKTOR = REF_MAP.KD_SEKTOR) 
                INNER JOIN TEMPAT_BAYAR ON SPPT.KD_TP = TEMPAT_BAYAR.KD_TP) ON 
                    (QOBJEKPAJAK.KD_JNS_OP = SPPT.KD_JNS_OP) AND 
                    (QOBJEKPAJAK.NO_URUT = SPPT.NO_URUT) AND 
                    (QOBJEKPAJAK.KD_BLOK = SPPT.KD_BLOK) AND 
                    (QOBJEKPAJAK.KD_KELURAHAN = SPPT.KD_KELURAHAN) AND 
                    (QOBJEKPAJAK.KD_Kecamatan = SPPT.KD_KECAMATAN) 
                WHERE 
                    (((SPPT.THN_PAJAK_SPPT)='" . $tahun_pajak . "')) AND
                    (((SPPT.KD_KECAMATAN)='" . $KD_KECAMATAN . "'))
                ORDER BY 
                    SPPT.KD_KECAMATAN, SPPT.KD_KELURAHAN, SPPT.KD_BLOK, SPPT.NO_URUT, SPPT.KD_JNS_OP
        ";
    }
    else
    {
        $QQ = 3;
        $q_bayar = "SELECT * FROM PEMBAYARAN_SPPT WHERE THN_PAJAK_SPPT='" . $tahun_pajak . "' AND KD_KECAMATAN='" . $KD_KECAMATAN . "' AND KD_KELURAHAN='" . $KD_KELURAHAN . "'";
        $query = "
                SELECT REF_MAP.KD_MAP, REF_JNS_SEKTOR.NM_SEKTOR, SPPT.PROSES,[SPPT].[KD_PROPINSI]+'.'+[SPPT].[KD_DATI2]+'.'+[SPPT].[KD_KECAMATAN]+'.'+[SPPT].[KD_KELURAHAN]+'.'+[SPPT].[KD_BLOK]+'-'+[SPPT].[NO_URUT]+'.'+[SPPT].[KD_JNS_OP] AS NOPQ, 
                    SPPT.KD_KECAMATAN, SPPT.KD_KELURAHAN, SPPT.THN_PAJAK_SPPT, SPPT.NM_WP_SPPT, SPPT.JLN_WP_SPPT, SPPT.BLOK_KAV_NO_WP_SPPT, 
                    SPPT.RW_WP_SPPT, SPPT.RT_WP_SPPT, SPPT.KELURAHAN_WP_SPPT, SPPT.KOTA_WP_SPPT, SPPT.KD_POS_WP_SPPT, SPPT.NPWP_SPPT, 
                    SPPT.NO_PERSIL_SPPT, SPPT.KD_KLS_TANAH, SPPT.KD_KLS_BNG, SPPT.LUAS_BUMI_SPPT, SPPT.LUAS_BNG_SPPT, SPPT.NJOP_BUMI_SPPT, 
                    SPPT.NJOP_BNG_SPPT, SPPT.NJOP_SPPT, SPPT.NJOPTKP_SPPT, SPPT.NJKP_SPPT, SPPT.PBB_TERHUTANG_SPPT, SPPT.FAKTOR_PENGURANG_SPPT, 
                    SPPT.PBB_YG_HARUS_DIBAYAR_SPPT, SPPT.TGL_JATUH_TEMPO_SPPT, SPPT.TGL_TERBIT_SPPT, SPPT.TGL_CETAK_SPPT, TEMPAT_BAYAR.NM_TP, 
                    QOBJEKPAJAK.JALAN_OP, QOBJEKPAJAK.BLOK_KAV_NO_OP, QOBJEKPAJAK.RW_OP, QOBJEKPAJAK.RT_OP, QOBJEKPAJAK.NM_KECAMATAN, 
                    QOBJEKPAJAK.NM_KELURAHAN, QOBJEKPAJAK.TGL_PEREKAMAN_OP 
                FROM 
                    QOBJEKPAJAK 
                INNER JOIN (((SPPT INNER JOIN REF_KELURAHAN ON 
                    (SPPT.KD_KECAMATAN = REF_KELURAHAN.KD_KECAMATAN) AND 
                    (SPPT.KD_KELURAHAN = REF_KELURAHAN.KD_KELURAHAN)) 
                INNER JOIN (REF_JNS_SEKTOR INNER JOIN REF_MAP ON REF_JNS_SEKTOR.KD_SEKTOR = REF_MAP.KD_SEKTOR) ON 
                    REF_KELURAHAN.KD_SEKTOR = REF_MAP.KD_SEKTOR) 
                INNER JOIN TEMPAT_BAYAR ON SPPT.KD_TP = TEMPAT_BAYAR.KD_TP) ON 
                    (QOBJEKPAJAK.KD_JNS_OP = SPPT.KD_JNS_OP) AND 
                    (QOBJEKPAJAK.NO_URUT = SPPT.NO_URUT) AND 
                    (QOBJEKPAJAK.KD_BLOK = SPPT.KD_BLOK) AND 
                    (QOBJEKPAJAK.KD_KELURAHAN = SPPT.KD_KELURAHAN) AND 
                    (QOBJEKPAJAK.KD_Kecamatan = SPPT.KD_KECAMATAN) 
                WHERE 
                    (((SPPT.THN_PAJAK_SPPT)='" . $tahun_pajak . "')) AND
                    (((SPPT.KD_KECAMATAN)='" . $KD_KECAMATAN . "')) AND
                    (((SPPT.KD_KELURAHAN)='" . $KD_KELURAHAN . "'))
                ORDER BY 
                    SPPT.KD_KECAMATAN, SPPT.KD_KELURAHAN, SPPT.KD_BLOK, SPPT.NO_URUT, SPPT.KD_JNS_OP
        ";
    }
}

$datas = $qb->rawQuery($query)->get();

if(isset($mode) && $mode == 'cek_cetak')
{
    if(empty($datas)){
        echo json_encode(['status'=>'fail','message'=>'SPPT Belum di Tetapkan']);
        die();
    }
    
    $jum = 0;
    $vOP = [];
    foreach($datas as $key => $_data)
    {
        if(isset($_data['PROSES']) && $_data['PROSES'] == 'N')
        {
            echo json_encode(['status'=>'fail','message'=>'SPPT Belum di Tetapkan']);
            die();
        }
        $vOP[$key] = [
            '',
            $key+1,
            $_data['KD_KECAMATAN'],
            $_data['NM_KECAMATAN'],
            $_data['KD_KELURAHAN'],
            $_data['NM_KELURAHAN'],
            $_data['NOPQ'],
            $_data['NM_WP_SPPT'],
        ];
        if($_data['JLN_WP_SPPT'] == "-" || empty($_data['JLN_WP_SPPT'])){
            if($_data['KOTA_WP_SPPT'] == "PAKPAK BHARAT"){
                $vOP[$key][] = $_data['KELURAHAN_WP_SPPT']."(!)";
            }else{
                $vOP[$key][] = $_data['KELURAHAN_WP_SPPT']."-".$_data['KOTA_WP_SPPT']."(!)";
            }
        }else{
            if(strtoupper(trim($_data['KOTA_WP_SPPT'])) == "PAKPAK BHARAT")
                $vOP[$key][] = $_data['JLN_WP_SPPT'] . "-".$_data['KELURAHAN_WP_SPPT'];
            else
                $vOP[$key][] = $_data['JLN_WP_SPPT']."-".$_data['KOTA_WP_SPPT'];
        }
        if(substr($vOP[$key][8], -1) == "-") $vOP[$key][8] = $_data['JLN_WP_SPPT'];
        $vOP[$key][] = $_data['JALAN_OP'];
        $vOP[$key][] = $_data['NM_SEKTOR'];
        $vOP[$key][] = $_data['PBB_YG_HARUS_DIBAYAR_SPPT'];
        $vOP[$key][] = $_data['TGL_TERBIT_SPPT'];
        $vOP[$key][] = $tahun_pajak;
        $vOP[$key][] = $_data['NM_TP'];
        $vOP[$key][] = 0;
        $vOP[$key][] = 0;
        $vOP[$key][] = 0;
        $vOP[$key][] = $_data['PBB_YG_HARUS_DIBAYAR_SPPT'];
        $vOP[$key][] = $_data['LUAS_BUMI_SPPT'];
        $vOP[$key][] = $_data['LUAS_BNG_SPPT'];
        if(empty($_data['KOTA_WP_SPPT']) || trim($_data['KOTA_WP_SPPT']) == "-")
            $vOP[$key][] = "-";
        else
            $vOP[$key][] = $_data['KOTA_WP_SPPT'];
        $jum += $_data['PBB_YG_HARUS_DIBAYAR_SPPT'];
    }

    // from buku
    $K = 0;
    $buku = $qb->rawQuery("SELECT * FROM REF_BUKU")->get();
    foreach($buku as $b)
    {
        $K = $K + 1;
    
        foreach($vOP as $k => $v)
        {
            if($v[11] * 1 >= $b['NILAI_MIN_BUKU'] && $v[11] * 1 <= $b['NILAI_MAX_BUKU']){
                $vOP[$k][15] = "BUKU " . $b['KD_BUKU'];
            }
        }
    }

    // from sub bayar
    $C = 0;
    $bayar = $qb->rawQuery($q_bayar)->get();
    foreach($bayar as $b)
    {
        foreach($vOP as $k => $v)
        {
            if($b['KD_PROPINSI'] . "." . $b['KD_DATI2'] . "." . $b['KD_KECAMATAN'] . "." . $b['KD_KELURAHAN'] . "." . $b['KD_BLOK'] . "-" . $b['NO_URUT'] . "." . $b['KD_JNS_OP'] == trim($v[6]))
            {
                $vOP[$k][16] = $b['JML_SPPT_YG_DIBAYAR'];
                $vOP[$k][17] = $b['TGL_PEMBAYARAN_SPPT'];
                $vOP[$k][11] = $v[11] * 1 - ($v[16] * 1);
                if($v[11] <= 0) $vOP[$k][11] = 0;
            }
        }
    }

    // from simpan dhkp
    $qb->rawQuery("Delete From TEMP_DHKP")->exec();

    foreach($vOP as $v):
        $xProp = "12"; 
        $xKab = "12";
        $cKode1 = $v[2];
        $xKec = $v[3];
        $cKode2 = $v[4];
        $xKel = $v[5];
        $xNOP = $v[6];
        $xNama = $v[7];
        $xAlamat = $v[8];
        $cAlamat = $v[9];
        $xSektor = $v[10];
        $xPBB = $v[11];
        $xTerbit = $v[12]->format('Y-m-d');
        $xTahun = $v[13];
        $xTempat = $v[14];
        $xBUKU = $v[15];
        $xBayar = $v[16];
        $xTanggal = $v[17];
        if($xTanggal == 0) $xTanggal = "";
        $cBayar = $v[18];
        $tLuas = $v[19];
        $bLuas = $v[20];
        $cKota = $v[21];

        $query = "
                    INSERT INTO TEMP_DHKP
                        (
                            KD_PROPINSI,
                            KD_DATI2,
                            KD_KECAMATAN,
                            NM_KECAMATAN,
                            KD_KELURAHAN,
                            NM_KELURAHAN,
                            NOPQ,
                            NM_WP_SPPT,
                            JLN_WP_SPPT,
                            JALAN_OP,
                            NM_SEKTOR,
                            PBB_YG_HARUS_DIBAYAR_SPPT,
                            TGL_TERBIT_SPPT,
                            THN_PAJAK,
                            NM_TP,
                            BUKU,
                            JUM_BAYAR,
                            TGL_BAYAR,
                            JUM_AKHIR,
                            LUAS_BUMI_SPPT,
                            LUAS_BNG_SPPT,
                            KOTA_WP
                        )
                        VALUES
                        (
                            '" . $xProp . "',
                            '" . $xKab . "',
                            '" . $cKode1 . "',
                            '" . $xKec . "',
                            '" . $cKode2 . "',
                            '" . $xKel . "',
                            '" . $xNOP . "',
                            '" . $xNama . "',
                            '" . $xAlamat . "',
                            '" . $cAlamat . "',
                            '" . $xSektor . "',
                            '" . $xPBB . "',
                            '" . date('Y-m-d',strtotime($xTerbit)) . "',
                            '" . $xTahun . "',
                            '" . $xTempat . "',
                            '" . $xBUKU . "',
                            '" . $xBayar . "',
                            '" . ($xTanggal != "" ? date('Y-m-d',strtotime($xTanggal)) : "") . "',
                            '" . $cBayar . "',
                            '" . $tLuas . "',
                            '" . $bLuas . "',
                            '" . $cKota . "'
                        )";
        $qb->rawQuery($query)->exec();    
    endforeach;

    $xBayar=0;
    $xNOP=0;
    $xBayar2=0;
    $xProp=0;$xKab=0;$xxKec=0;$xxKel=0;$xxBlok=0;$xxUrut=0;$xxJenis=0;

    if($QQ==1)
    {
        $C_SPPT = "SELECT KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,
			PBB_YG_HARUS_DIBAYAR_SPPT,THN_PAJAK_SPPT FROM SPPT_1 WHERE THN_PAJAK_SPPT = $tahun_pajak";
    }
    elseif($QQ==2)
    {
        $C_SPPT = "SELECT KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,
        PBB_YG_HARUS_DIBAYAR_SPPT,THN_PAJAK_SPPT FROM SPPT_1 WHERE KD_KECAMATAN=$KD_KECAMATAN and THN_PAJAK_SPPT = $tahun_pajak";
    }
    else
    {
        $C_SPPT = "SELECT KD_PROPINSI,KD_DATI2,KD_KECAMATAN,KD_KELURAHAN,KD_BLOK,NO_URUT,KD_JNS_OP,
        PBB_YG_HARUS_DIBAYAR_SPPT,THN_PAJAK_SPPT FROM SPPT_1 WHERE KD_KECAMATAN=$KD_KECAMATAN and KD_KELURAHAN=$KD_KELURAHAN and THN_PAJAK_SPPT = $tahun_pajak";
    }

    $C_SPPT = $qb->rawQuery($C_SPPT)->get();
    foreach($C_SPPT as $c)
    {

        $xProp = $c['xProp'];
        $xKab = $c['xKab'];
        $xxKec = $c['xxKec'];
        $xxKel = $c['xxKel'];
        $xxBlok = $c['xxBlok'];
        $xxUrut = $c['xxUrut'];
        $xxJenis = $c['xxJenis'];
        $xBayar = $c['xBayar'];
        $xTahun = $c['xTahun'];

        $qb->rawQuery("UPDATE TEMP_DHKP SET JUM_UBAH=PBB_YG_HARUS_DIBAYAR_SPPT,PBB_YG_HARUS_DIBAYAR_SPPT=$xBayar,JUM_SELISIH=(PBB_YG_HARUS_DIBAYAR_SPPT-$xBayar) WHERE $xBayar <> PBB_YG_HARUS_DIBAYAR_SPPT  and (NOPQ=$xProp +'.'+ $xKab +'.'+ $xxKec +'.'+ $xxKel +'.'+ $xxBlok +'-'+ $xxUrut +'.'+ $xxJenis)");
    }


    echo json_encode([
        'status'=>'success',
        'message'=>'',
    ]);
    die();

}

