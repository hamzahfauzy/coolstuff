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
    <h2 align="center">KLASIFIKASI DAN BESARAN NJOP BUMI<br>TAHUN <?=$_GET['tahun_pajak']?></h2>
    <table>
        <tr>
            <td>PROPINSI</td>
            <td>:</td>
            <td>12 - SUMATERA UTARA</td>
        </tr>
        <tr>
            <td>KABUPATEN</td>
            <td>:</td>
            <td>12 - PAKPAK BHARAT</td>
        </tr>
        <tr>
            <td>KECAMATAN</td>
            <td>:</td>
            <td><?=$kecamatan['KD_KECAMATAN']?> - <?=$kecamatan['NM_KECAMATAN']?></td>
        </tr>
        <tr>
            <td>KELURAHAN</td>
            <td>:</td>
            <td><?=$kelurahan['KD_KELURAHAN']?> - <?=$kelurahan['NM_KELURAHAN']?></td>
        </tr>
    </table>
    <table border="1" width="100%">
        <tr>
            <th>NO</th>
            <th>BLOK</th>
            <th>NAMA JALAN</th>
            <th>KD ZNT</th>
            <th>KELAS BUMI</th>
            <th>PENGELOMPOKAN NILAI JUAL BUMI</th>
            <th>NJOP BUMI</th>
        </tr>
        <?php foreach($datas as $key => $data): ?>
        <tr>
            <td align="center"><?=$key+1?></td>
            <td align="center"><?=$data['BLOK']?></td>
            <td><?=$data['NM_JALAN']?></td>
            <td align="center"><?=$data['KD_ZNT']?></td>
            <td align="center"><?=$data['KLS_TANAH']?></td>
            <td align="center"><?=number_format($data['NILAI_MIN'])?> s.d <?=number_format($data['NILAI_MAX'])?></td>
            <td align="center"><?=number_format($data['NJOP'])?></td>
        </tr>
        <?php endforeach ?>
    </table>
</body>
</html>