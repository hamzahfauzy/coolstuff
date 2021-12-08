<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Log Perubahan Objek</title>
    <style>
    body {
        margin:10mm;
    }
    </style>
</head>
<body onload="window.print()">
    <h2 align="center">Log Perubahan Objek<br>TAHUN <?=$_GET['tahun_pajak']?></h2>
    <table border="1" width="100%" cellspacing="0" cellpadding="10">
        <tr>
            <th>NO</th>
            <th>NOP</th>
            <th>Nama</th>
            <th>Lokasi Objek Pajak</th>
            <th>L BUMI</th>
            <th>L BNG</th>
            <th>NJOP Bumi</th>
            <th>NJOP Bangunan</th>
            <th>NJOPTKP</th>
            <th>Keterangan</th>
        </tr>
        <?php foreach($datas as $key => $data):

        $KET = "[Log: " . $data['TGL_PEREKAMAN_OP']->format("Y-m-d") . ", " . $data['NIP_PEREKAM_OP'] . " | " .$data['KET'] . "]";

        $NopB = $data['NOP'] == $data['NOP1'] || $data['NOP1'] == "-" || $data['NOP1'] == "" ? "-" : $data['NOP1'];

        $NamaB = trim(strtoupper($data['NM_WP'])) == trim(strtoupper($data['NM_WP1'])) ? "-" : $data['NM_WP1'];

        $LokasiB = trim(strtoupper($data['LOKASI'])) == trim(strtoupper($data['LOKASI1'])) ? "-" : $data['LOKASI1'];

        $Luas1  =  $data['TOTAL_LUAS_BUMI'] == $data['TOTAL_LUAS_BUMI1'] ? 0 : $data['TOTAL_LUAS_BUMI1'];

        $Luas2 = $data['TOTAL_LUAS_BNG'] == $data['TOTAL_LUAS_BNG1'] ? 0 : $data['TOTAL_LUAS_BNG1'];

        $NJOP1 = $data['NJOP_BUMI'] == $data['NJOP_BUMI1'] ? 0 : $data['NJOP_BUMI1'];
        
        $NJOP2 = $data['NJOP_BNG'] == $data['NJOP_BNG1'] ? 0 : $data['NJOP_BNG1'];

        $PBB = $data['NJOPTKP']=$data['NJOPTKP1'] ? 0 : $data['NJOPTKP1'];

        ?>
        
        <tr>
            <td style="border:0; border-top:1px solid #000; border-left:1px solid #000" rowspan="2" align="center"><?=$key+1?></td>
            <td style="border:0; border-top:1px solid #000; " align="left"><?=$data['NOP']?></td>
            <td style="border:0; border-top:1px solid #000; "><?=$data['NM_WP']?></td>
            <td style="border:0; border-top:1px solid #000; " align="left"><?=$data['LOKASI']?></td>
            <td style="border:0; border-top:1px solid #000; " align="right"><?=number_format($data['TOTAL_LUAS_BUMI'],2)?></td>
            <td style="border:0; border-top:1px solid #000; " align="right"><?=number_format($data['TOTAL_LUAS_BNG'],2)?></td>
            <td style="border:0; border-top:1px solid #000; " align="right"><?=number_format($data['NJOP_BUMI'],2)?></td>
            <td style="border:0; border-top:1px solid #000; " align="right"><?=number_format($data['NJOP_BNG'],2)?></td>
            <td style="border:0; border-top:1px solid #000; " align="right"><?=number_format($data['NJOPTKP'],2)?></td>
            <td style="border:0; border-top:1px solid #000; border-right:1px solid #000; font-weight:bold;" rowspan="2" align="left"><?=$KET?></td>
        </tr>

        <tr>
            <td style="border:0; border-top:1px dashed #000;" align="left"><?=$NopB?></td>
            <td style="border:0; border-top:1px dashed #000;"><?=$NamaB?></td>
            <td style="border:0; border-top:1px dashed #000;" align="left"><?=$LokasiB?></td>
            <td style="border:0; border-top:1px dashed #000;" align="right"><?=number_format($Luas1,2)?></td>
            <td style="border:0; border-top:1px dashed #000;" align="right"><?=number_format($Luas2,2)?></td>
            <td style="border:0; border-top:1px dashed #000;" align="right"><?=number_format($NJOP1,2)?></td>
            <td style="border:0; border-top:1px dashed #000;" align="right"><?=number_format($NJOP2,2)?></td>
            <td style="border:0; border-top:1px dashed #000;" align="right"><?=number_format($PBB,2)?></td>
        </tr>
        <?php endforeach ?>
    </table>
</body>
</html>