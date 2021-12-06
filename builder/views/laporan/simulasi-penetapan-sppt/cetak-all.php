<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak DHKP</title>
    <style>
    body {
        margin:10mm;
    }
    </style>
</head>
<body onload="window.print()">
    <h2 align="center">PERBANDINGAN KETETAPAN SPPT TAHUN <?=$_GET['tahun_pajak']-1?> DAN SIMULASI KETETAPAN SPPT TAHUN <?=$_GET['tahun_pajak']?> </h2>
    <table border="1" width="100%">
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">NAMA DESA / KELURAHAN</th>
            <th colspan="2">SPPT TAHUN <?=$_GET['tahun_pajak']?></th>
            <th colspan="2">SPPT TAHUN <?=$_GET['tahun_pajak']-1?></th>
        </tr>
        <tr>
            <th>SPPT</th>
            <th>PBB</th>
            <th>SPPT</th>
            <th>PBB</th>
        </tr>
        <?php foreach($datas_new as $key => $data): ?>
        <tr>
            <td style="padding:8px;" colspan="2"><?=$key?></td>
            <td align="center" style="font-weight:bold"><?=$data['total']['SPPT1']?></td>
            <td align="center" style="font-weight:bold"><?=$data['total']['PBB1']?></td>
            <td align="center" style="font-weight:bold"><?=$data['total']['SPPT2']?></td>
            <td align="center" style="font-weight:bold"><?=$data['total']['PBB2']?></td>
            
            <?php $i=1; foreach($data['kelurahans'] as $key2 => $data2): ?>
            <tr>
                    
                <td align="center"><?=$i?></td>
                <td><?=$key2?></td>
                <td align="center"><?=$data2['SPPT1']?></td>
                <td align="center"><?=$data2['PBB1']?></td>
                <td align="center"><?=$data2['SPPT2']?></td>
                <td align="center"><?=$data2['PBB2']?></td>

            </tr>
            <?php $i++; endforeach ?>
        
        </tr>
        <?php endforeach ?>
    </table>
</body>
</html>