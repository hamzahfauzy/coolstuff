<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN PERBANDINGAN PENILAIAN OBJEK PAJAK<br>TAHUN <?=$_GET['tahun_pajak']?> DENGAN TAHUN <?=$_GET['tahun_pajak']-1?></title>
    <style>
    body {
        margin:10mm;
    }
    </style>
</head>
<body onload="window.print()">
    <h2 align="center">LAPORAN PERBANDINGAN PENILAIAN OBJEK PAJAK<br>TAHUN <?=$_GET['tahun_pajak']?> DENGAN TAHUN <?=$_GET['tahun_pajak']-1?></h2>
    <table border="1" width="100%">
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">Nama Desa / Kelurahan</th>
            <th colspan="3">Penilaian Bumi</th>
            <th colspan="3">Penilaian Bangunan</th>
        </tr>
        <tr>
            <th>Jumlah</th>
            <th>Luas</th>
            <th>Nilai Sistem</th>

            <th>Jumlah</th>
            <th>Luas</th>
            <th>Nilai Sistem</th>
        </tr>
        <?php 
            
         foreach($datas_new as $thn => $data_new):
            foreach($data_new['KECAMATANS'] as $key => $data):
         ?>
            <tr style="font-weight:bold">
                <td style="padding:12px" colspan="8">Kec. <?=$key?></td>
            </tr>
            <?php
            $i=1;
                foreach($data['KELURAHANS'] as $key2 => $value): ?>

                <tr>
                    <td align="center"><?=$i?></td>
                    <td><?=$key2?></td>

                    <td align="center"><?=number_format($value['JLH_BUMI'])?></td>
                    <td align="center"><?=number_format($value['LUAS_BUMI'])?></td>
                    <td align="center"><?=number_format($value['NILAI_SISTEM_BUMI'])?></td>

                    <td align="center"><?=number_format($value['JLH_BNG'])?></td>
                    <td align="center"><?=number_format($value['LUAS_BNG'])?></td>
                    <td align="center"><?=number_format($value['NILAI_SISTEM_BNG'])?></td>
                </tr>
            <?php $i++; endforeach ?>

            <tr style="font-weight:bold;">
                <td style="padding:8px" colspan="2" align="center">Jumlah</td>
                
                <td style="padding:8px" align="center"><?=number_format($data['JUMLAH']['JLH_BUMI'])?></td>
                <td style="padding:8px" align="center"><?=number_format($data['JUMLAH']['LUAS_BUMI'])?></td>
                <td style="padding:8px" align="center"><?=number_format($data['JUMLAH']['NILAI_SISTEM_BUMI'])?></td>

                <td style="padding:8px" align="center"><?=number_format($data['JUMLAH']['JLH_BNG'])?></td>
                <td style="padding:8px" align="center"><?=number_format($data['JUMLAH']['LUAS_BNG'])?></td>
                <td style="padding:8px" align="center"><?=number_format($data['JUMLAH']['NILAI_SISTEM_BNG'])?></td>
            </tr>
        <?php endforeach ?>

        <tr style="font-weight:bold;">
            <td style="padding:8px" colspan="2" align="center">Total (TAHUN <?=$thn?>)</td>
            
            <td style="padding:8px" align="center"><?=number_format($datas_new[$thn]['TOTAL']['JLH_BUMI'])?></td>
            <td style="padding:8px" align="center"><?=number_format($datas_new[$thn]['TOTAL']['LUAS_BUMI'])?></td>
            <td style="padding:8px" align="center"><?=number_format($datas_new[$thn]['TOTAL']['NILAI_SISTEM_BUMI'])?></td>

            <td style="padding:8px" align="center"><?=number_format($datas_new[$thn]['TOTAL']['JLH_BNG'])?></td>
            <td style="padding:8px" align="center"><?=number_format($datas_new[$thn]['TOTAL']['LUAS_BNG'])?></td>
            <td style="padding:8px" align="center"><?=number_format($datas_new[$thn]['TOTAL']['NILAI_SISTEM_BNG'])?></td>
        </tr>

        <?php endforeach ?>
    </table>

    <h2 align="center">TABEL PERBANDINGAN</h2>
    <table border="1" width="100%">
        <tr>
            <th></th>
            <th><?=$_GET['tahun_pajak']-1?></th>
            <th><?=$_GET['tahun_pajak']?></th>
        </tr>

        <tr>
            <td align="center">Jumlah Objek Bumi</td>
            <td align="center"><?=number_format($datas_new[$_GET['tahun_pajak']-1]['TOTAL']['JLH_BUMI'])?></td>
            <td align="center"><?=number_format($datas_new[$_GET['tahun_pajak']]['TOTAL']['JLH_BUMI'])?></td>
        </tr>
        <tr>
            <td align="center">Total Luas Bumi</td>
            <td align="center"><?=number_format($datas_new[$_GET['tahun_pajak']-1]['TOTAL']['LUAS_BUMI'])?></td>
            <td align="center"><?=number_format($datas_new[$_GET['tahun_pajak']]['TOTAL']['LUAS_BUMI'])?></td>
        </tr>
        <tr>
            <td align="center">Total Nilai Sistem Bumi</td>
            <td align="center"><?=number_format($datas_new[$_GET['tahun_pajak']-1]['TOTAL']['NILAI_SISTEM_BUMI'])?></td>
            <td align="center"><?=number_format($datas_new[$_GET['tahun_pajak']]['TOTAL']['NILAI_SISTEM_BUMI'])?></td>
        </tr>

        <tr>
            <td align="center">Jumlah Objek Bangunan</td>
            <td align="center"><?=number_format($datas_new[$_GET['tahun_pajak']-1]['TOTAL']['JLH_BNG'])?></td>
            <td align="center"><?=number_format($datas_new[$_GET['tahun_pajak']]['TOTAL']['JLH_BNG'])?></td>
        </tr>
        <tr>
            <td align="center">Total Luas Bangunan</td>
            <td align="center"><?=number_format($datas_new[$_GET['tahun_pajak']-1]['TOTAL']['LUAS_BNG'])?></td>
            <td align="center"><?=number_format($datas_new[$_GET['tahun_pajak']]['TOTAL']['LUAS_BNG'])?></td>
        </tr>
        <tr>
            <td align="center">Total Nilai Sistem Bangunan</td>
            <td align="center"><?=number_format($datas_new[$_GET['tahun_pajak']-1]['TOTAL']['NILAI_SISTEM_BNG'])?></td>
            <td align="center"><?=number_format($datas_new[$_GET['tahun_pajak']]['TOTAL']['NILAI_SISTEM_BNG'])?></td>
        </tr>

    </table>
</body>
</html>