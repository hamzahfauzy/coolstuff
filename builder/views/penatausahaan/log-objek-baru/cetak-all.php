<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Log Objek Baru</title>
    <style>
    body {
        margin:10mm;
    }
    </style>
</head>
<body onload="window.print()">
    <h2 align="center">Log Objek Baru<br>TAHUN <?=$_GET['tahun_pajak']?></h2>
    <table border="1" width="100%" cellspacing="0" cellpadding="10">
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">NOP</th>
            <th rowspan="2">Nama</th>
            <th rowspan="2">Lokasi Objek Pajak</th>
            <th>LUAS BUMI</th>
            
            <th>NJOP Bumi</th>
            
            <th>NJOPTKP Lama</th>
            
            <th>Kelas T</th>
            
            <th>PBB TERHUTANG LAMA</th>
            
            <th rowspan="2">Log Perekaman</th>
        </tr>

        <tr>
            <th>LUAS BNG</th>
            <th>NJOP Bangunan</th>
            <th>NJOPTKP Baru</th>
            <th>Kelas B</th>
            <th>PBB TERHUTANG BARU</th>
        </tr>
        <?php foreach($datas as $key => $data):

        $PBB1 = is_null($data['PBB_TERUTANG']) ? 0 : $data['PBB_TERUTANG'];
        $PBB2 = is_null($data['PBB_TERUTANG1']) ? 0 : $data['PBB_TERUTANG1'];

        ?>
        
        <tr>
            <td rowspan="2" align="center"><?=$key+1?></td>
            <td rowspan="2" align="center"><?=$data['NOP1']?></td>
            <td rowspan="2"><?=$data['NM_WP1']?></td>
            <td rowspan="2"><?=$data['LOKASI1']?></td>
            <td align="right"><?= number_format($data['TOTAL_LUAS_BUMI1'],2)?></td>
            <td align="right"><?=number_format($data['NJOP_BUMI1'],2)?></td>
            <td align="right"><?=number_format($data['NJOPTKP'],2)?></td>
            <td align="center"><?=$data['KD_KLS_TANAH']?></td>
            <td align="right"><?=number_format($PBB1)?></td>
            <td rowspan="2" align="center"><?=$data['TGL_PEREKAMAN_OP']->format("Y-m-d H:i:s")?></td>
        </tr>

        <tr>
            <td align="right"><?=number_format($data['TOTAL_LUAS_BNG1'],2)?></td>
            <td align="right"><?=number_format($data['NJOP_BNG1'],2)?></td>
            <td align="right"><?=number_format($data['NJOPTKP1'],2)?></td>
            <td align="center"><?=$data['KD_KLS_BNG']?></td>
            <td align="right"><?=number_format($PBB2,2)?></td>
        </tr>
        <?php endforeach ?>
    </table>
</body>
</html>