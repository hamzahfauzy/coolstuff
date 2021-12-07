<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

extract($_GET);

if($KD_KECAMATAN == 'Semua' && $KD_KELURAHAN == 'Semua')
{
    $C_STR = "SELECT SPPT.KD_KECAMATAN, REF_KECAMATAN.NM_KECAMATAN, Count(SPPT.KD_KELURAHAN) AS JUM_SPPT, REF_KELURAHAN.NM_KELURAHAN, Sum(SPPT.PBB_YG_HARUS_DIBAYAR_SPPT) AS JUM_PBB, SPPT.PROSES, SPPT.THN_PAJAK_SPPT FROM SPPT INNER JOIN (REF_KELURAHAN INNER JOIN REF_KECAMATAN ON (REF_KELURAHAN.KD_PROPINSI = REF_KECAMATAN.KD_PROPINSI) AND (REF_KELURAHAN.KD_DATI2 = REF_KECAMATAN.KD_DATI2) AND (REF_KELURAHAN.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN)) ON (SPPT.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN) AND (SPPT.KD_KELURAHAN = REF_KELURAHAN.KD_KELURAHAN)GROUP BY SPPT.KD_KECAMATAN, REF_KECAMATAN.NM_KECAMATAN, REF_KELURAHAN.NM_KELURAHAN, SPPT.PROSES, SPPT.THN_PAJAK_SPPT HAVING (((SPPT.THN_PAJAK_SPPT)='" . $tahun_pajak . "'))  ORDER BY REF_KECAMATAN.NM_KECAMATAN,REF_KELURAHAN.NM_KELURAHAN ASC";

    $C_STR2 = "SELECT SPPT.KD_KECAMATAN, REF_KECAMATAN.NM_KECAMATAN, Count(SPPT.KD_KELURAHAN) AS JUM_SPPT, REF_KELURAHAN.NM_KELURAHAN, Sum(SPPT.PBB_YG_HARUS_DIBAYAR_SPPT) AS JUM_PBB, SPPT.PROSES, SPPT.THN_PAJAK_SPPT FROM SPPT INNER JOIN (REF_KELURAHAN INNER JOIN REF_KECAMATAN ON (REF_KELURAHAN.KD_PROPINSI = REF_KECAMATAN.KD_PROPINSI) AND (REF_KELURAHAN.KD_DATI2 = REF_KECAMATAN.KD_DATI2) AND (REF_KELURAHAN.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN)) ON (SPPT.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN) AND (SPPT.KD_KELURAHAN = REF_KELURAHAN.KD_KELURAHAN)GROUP BY SPPT.KD_KECAMATAN, REF_KECAMATAN.NM_KECAMATAN, REF_KELURAHAN.NM_KELURAHAN, SPPT.PROSES, SPPT.THN_PAJAK_SPPT HAVING (((SPPT.THN_PAJAK_SPPT)='" . ($tahun_pajak - 1) . "') )  ORDER BY REF_KECAMATAN.NM_KECAMATAN,REF_KELURAHAN.NM_KELURAHAN ASC";

    $C_KEC = "SELECT REF_KECAMATAN.KD_KECAMATAN, REF_KECAMATAN.NM_KECAMATAN, REF_KELURAHAN.KD_KELURAHAN, REF_KELURAHAN.NM_KELURAHAN FROM REF_KELURAHAN INNER JOIN REF_KECAMATAN ON (REF_KELURAHAN.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN) AND (REF_KELURAHAN.KD_DATI2 = REF_KECAMATAN.KD_DATI2) AND (REF_KELURAHAN.KD_PROPINSI = REF_KECAMATAN.KD_PROPINSI) ORDER BY REF_KECAMATAN.NM_KECAMATAN,REF_KELURAHAN.NM_KELURAHAN ASC";

}
else
{
    if($KD_KELURAHAN == 'Semua')
    {

        $C_STR = "SELECT SPPT.KD_KECAMATAN, REF_KECAMATAN.NM_KECAMATAN, Count(SPPT.KD_KELURAHAN) AS JUM_SPPT, REF_KELURAHAN.NM_KELURAHAN, Sum(SPPT.PBB_YG_HARUS_DIBAYAR_SPPT) AS JUM_PBB, SPPT.PROSES, SPPT.THN_PAJAK_SPPT FROM SPPT INNER JOIN (REF_KELURAHAN INNER JOIN REF_KECAMATAN ON (REF_KELURAHAN.KD_PROPINSI = REF_KECAMATAN.KD_PROPINSI) AND (REF_KELURAHAN.KD_DATI2 = REF_KECAMATAN.KD_DATI2) AND (REF_KELURAHAN.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN)) ON (SPPT.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN) AND (SPPT.KD_KELURAHAN = REF_KELURAHAN.KD_KELURAHAN)GROUP BY SPPT.KD_KECAMATAN, REF_KECAMATAN.NM_KECAMATAN, REF_KELURAHAN.NM_KELURAHAN, SPPT.PROSES, SPPT.THN_PAJAK_SPPT HAVING (((SPPT.THN_PAJAK_SPPT)='" . $tahun_pajak . "')  and SPPT.KD_KECAMATAN='" . $KD_KECAMATAN . "') ORDER BY REF_KECAMATAN.NM_KECAMATAN,REF_KELURAHAN.NM_KELURAHAN ASC";

        $C_STR2 = "SELECT SPPT.KD_KECAMATAN, REF_KECAMATAN.NM_KECAMATAN, Count(SPPT.KD_KELURAHAN) AS JUM_SPPT, REF_KELURAHAN.NM_KELURAHAN, Sum(SPPT.PBB_YG_HARUS_DIBAYAR_SPPT) AS JUM_PBB, SPPT.PROSES, SPPT.THN_PAJAK_SPPT FROM SPPT INNER JOIN (REF_KELURAHAN INNER JOIN REF_KECAMATAN ON (REF_KELURAHAN.KD_PROPINSI = REF_KECAMATAN.KD_PROPINSI) AND (REF_KELURAHAN.KD_DATI2 = REF_KECAMATAN.KD_DATI2) AND (REF_KELURAHAN.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN)) ON (SPPT.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN) AND (SPPT.KD_KELURAHAN = REF_KELURAHAN.KD_KELURAHAN)GROUP BY SPPT.KD_KECAMATAN, REF_KECAMATAN.NM_KECAMATAN, REF_KELURAHAN.NM_KELURAHAN, SPPT.PROSES, SPPT.THN_PAJAK_SPPT HAVING (((SPPT.THN_PAJAK_SPPT)='" . ($tahun_pajak - 1) . "') and SPPT.KD_KECAMATAN='" . $KD_KECAMATAN . "') ORDER BY REF_KECAMATAN.NM_KECAMATAN,REF_KELURAHAN.NM_KELURAHAN ASC";

        $C_KEC = "SELECT REF_KECAMATAN.KD_KECAMATAN, REF_KECAMATAN.NM_KECAMATAN, REF_KELURAHAN.KD_KELURAHAN, REF_KELURAHAN.NM_KELURAHAN FROM REF_KELURAHAN INNER JOIN REF_KECAMATAN ON (REF_KELURAHAN.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN) AND (REF_KELURAHAN.KD_DATI2 = REF_KECAMATAN.KD_DATI2) AND (REF_KELURAHAN.KD_PROPINSI = REF_KECAMATAN.KD_PROPINSI)WHERE (((REF_KECAMATAN.KD_KECAMATAN)='" . $KD_KECAMATAN . "')) ORDER BY REF_KECAMATAN.NM_KECAMATAN,REF_KELURAHAN.NM_KELURAHAN ASC";

    }
    else
    {

        $C_STR = "SELECT SPPT.KD_KECAMATAN, REF_KECAMATAN.NM_KECAMATAN, COUNT(SPPT.KD_KELURAHAN) AS JUM_SPPT, REF_KELURAHAN.KD_KELURAHAN, REF_KELURAHAN.NM_KELURAHAN, Sum(SPPT.PBB_YG_HARUS_DIBAYAR_SPPT) AS JUM_PBB, SPPT.PROSES, SPPT.THN_PAJAK_SPPT FROM SPPT INNER JOIN (REF_KELURAHAN INNER JOIN REF_KECAMATAN ON (REF_KELURAHAN.KD_PROPINSI = REF_KECAMATAN.KD_PROPINSI) AND (REF_KELURAHAN.KD_DATI2 = REF_KECAMATAN.KD_DATI2) AND (REF_KELURAHAN.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN)) ON (SPPT.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN) AND (SPPT.KD_KELURAHAN = REF_KELURAHAN.KD_KELURAHAN) GROUP BY SPPT.KD_KECAMATAN, REF_KECAMATAN.NM_KECAMATAN, REF_KELURAHAN.KD_KELURAHAN, REF_KELURAHAN.NM_KELURAHAN, SPPT.PROSES, SPPT.THN_PAJAK_SPPT HAVING (((SPPT.KD_KECAMATAN)='" . $KD_KECAMATAN . "') AND ((REF_KELURAHAN.KD_KELURAHAN)='" . $KD_KELURAHAN . "') AND ((SPPT.THN_PAJAK_SPPT)='" . $tahun_pajak . "'))ORDER BY REF_KECAMATAN.NM_KECAMATAN,REF_KELURAHAN.NM_KELURAHAN ASC";

        $C_STR2 = "SELECT SPPT.KD_KECAMATAN, REF_KECAMATAN.NM_KECAMATAN, COUNT(SPPT.KD_KELURAHAN) AS JUM_SPPT, REF_KELURAHAN.KD_KELURAHAN, REF_KELURAHAN.NM_KELURAHAN, Sum(SPPT.PBB_YG_HARUS_DIBAYAR_SPPT) AS JUM_PBB, SPPT.PROSES, SPPT.THN_PAJAK_SPPT FROM SPPT INNER JOIN (REF_KELURAHAN INNER JOIN REF_KECAMATAN ON (REF_KELURAHAN.KD_PROPINSI = REF_KECAMATAN.KD_PROPINSI) AND (REF_KELURAHAN.KD_DATI2 = REF_KECAMATAN.KD_DATI2) AND (REF_KELURAHAN.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN)) ON (SPPT.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN) AND (SPPT.KD_KELURAHAN = REF_KELURAHAN.KD_KELURAHAN) GROUP BY SPPT.KD_KECAMATAN, REF_KECAMATAN.NM_KECAMATAN, REF_KELURAHAN.KD_KELURAHAN, REF_KELURAHAN.NM_KELURAHAN, SPPT.PROSES, SPPT.THN_PAJAK_SPPT HAVING (((SPPT.KD_KECAMATAN)='" . $KD_KECAMATAN . "') AND ((REF_KELURAHAN.KD_KELURAHAN)='" . $KD_KELURAHAN . "') AND ((SPPT.THN_PAJAK_SPPT)='" . ($tahun_pajak - 1) . "'))ORDER BY REF_KECAMATAN.NM_KECAMATAN,REF_KELURAHAN.NM_KELURAHAN ASC";

        $C_KEC = "SELECT REF_KECAMATAN.KD_KECAMATAN, REF_KECAMATAN.NM_KECAMATAN, REF_KELURAHAN.KD_KELURAHAN, REF_KELURAHAN.NM_KELURAHAN FROM REF_KELURAHAN INNER JOIN REF_KECAMATAN ON (REF_KELURAHAN.KD_KECAMATAN = REF_KECAMATAN.KD_KECAMATAN) AND (REF_KELURAHAN.KD_DATI2 = REF_KECAMATAN.KD_DATI2) AND (REF_KELURAHAN.KD_PROPINSI = REF_KECAMATAN.KD_PROPINSI)WHERE (((REF_KECAMATAN.KD_KECAMATAN)='" . $KD_KECAMATAN . "')) AND (((REF_KELURAHAN.KD_KELURAHAN)='" . $KD_KELURAHAN . "'))ORDER BY REF_KECAMATAN.NM_KECAMATAN,REF_KELURAHAN.NM_KELURAHAN ASC";

    }
}

$datas = $qb->rawQuery($C_STR)->get();
$datas2 = $qb->rawQuery($C_STR2)->get();
$datas3 = $qb->rawQuery($C_KEC)->get();

if(isset($mode) && $mode == 'cek_cetak')
{
    if(empty($datas)){
        echo json_encode(['status'=>'fail','message'=>'Data tidak ada']);
        die();
    }
    
    $JUM1 = 0;
    $JS1 = 0;
    $vOP = [];

    foreach($datas as $key => $_data)
    {
        if(isset($_data['PROSES']) && $_data['PROSES'] == 'N')
        {
            echo json_encode(['status'=>'fail','message'=>'SPPT Belum di Tetapkan']);
            die();
        }

        $c1 = $_data['JUM_SPPT'];
        $c2 = $_data['JUM_PBB'];

        $JUM1 = $JUM1 + $c2;
        $JS1 = $JS1 + $c1;

        $vOP[$key] = [
            '',
            $key+1,
            $_data['NM_KECAMATAN'],
            $_data['NM_KELURAHAN'],
            $c1,
            $c2,
            0,
            0,
            $_data['THN_PAJAK_SPPT'],
            0,
            0
        ];

    }

    $i = count($vOP);
    $JS2 = 0;
    $JUM1 = 0;
    $JUM2 = 0;
    $C = 0;

    foreach($datas2 as $key => $_data)
    {
        if(isset($_data['PROSES']) && $_data['PROSES'] == 'N')
        {
            echo json_encode(['status'=>'fail','message'=>'SPPT Belum di Tetapkan']);
            die();
        }
        
        $c1 = $_data['JUM_SPPT'];
        $c2 = $_data['JUM_PBB'];

        $JUM2 = $JUM2 + $c2;
        $JS2 = $JS2 + $c1;

        $vOP[$i] = [
            '',
            $key+1,
            $_data['NM_KECAMATAN'],
            $_data['NM_KELURAHAN'],
            $c1,
            $c2,
            0,
            0,
            $_data['THN_PAJAK_SPPT'],
            0,
            0
        ];
        
        $i = $i + 1;
    }
    
    foreach ($vOP as $key => $value) {
        $vOP[$key][9] = $vOP[$key][4] + $vOP[$key][6];
        $vOP[$key][10] = $vOP[$key][5] + $vOP[$key][7];
    }

    $vOP1 = [];

    foreach($datas3 as $key => $_data){
        $vOP1[$key] = [
            '',
            $key+1,
            $_data['NM_KECAMATAN'],
            $_data['NM_KELURAHAN'],
            0,
            0,
            0,
            0,
            0,
        ];
    }

    foreach ($vOP1 as $key => $value) {
        
        $c4 = 0;
        $c5 = 0;

        foreach ($vOP as $key2 => $value2) {
            
            if( $value2[2] == $vOP1[$key][2] && $value2[3] == $vOP1[$key][3]){
                $c4 = $c4 + $value2[4];
                $c5 = $c5 + $value2[5];
                $vOP1[$key][4] = $c4;
                $vOP1[$key][5] = $c5 ;
                $vOP1[$key][6] = $value2[9];
                $vOP1[$key][7] = $value2[10];
                
            }

        }

    }

    $c_DEL = "Delete From SPPT_SIMULASI1";
    $qb->rawQuery($c_DEL)->exec();

    foreach ($vOP1 as $key => $value) {
        $xNO = $value[1];
        $xKec = $value[2];
        $xKel = $value[3];
        $xSPPT1 = $value[4];
        $xPBB1 = $value[5];
        $xSPPT2 = $value[6];
        $xPBB2 = $value[7];
        $xTahun = $tahun_pajak;

        $c_ins = "INSERT INTO SPPT_SIMULASI1(NoUrut,KD_PROPINSI,KD_DATI2,NM_KECAMATAN,NM_KELURAHAN,SPPT1,PBB1,SPPT2,PBB2,THN_PAJAK) VALUES('" . $xNO . "','12','12','" . $xKec . "','" . $xKel . "','" . $xSPPT1 . "','" . $xPBB1 . "','" . $xSPPT2 . "','" . $xPBB2 . "','" . $xTahun . "')";
        
        $qb->rawQuery($c_ins)->exec();
    }

    echo json_encode([
        'status'=>'success',
        'message'=>'',
    ]);
    die();

}

