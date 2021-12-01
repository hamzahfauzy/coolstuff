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
    <h2 align="center">DAFTAR HIMPUNAN KETETAPAN PAJAK DAN PEMBAYARAN BUKU<br>TAHUN <?=$_GET['tahun_pajak']?></h2>
    <table>
        <tr>
            <td>TEMPAT PEMBAYARAN</td>
            <td>:</td>
            <td></td>
        </tr>
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
    </table>
    <table border="1" width="100%">
        <tr>
            <th>NO</th>
            <th>NOP</th>
            <th>NAMA WAJIB PAJAK</th>
            <th>ALAMAT OBJEK PAJAK WAJIB PAJAK</th>
        </tr>
        <?php foreach($datas as $key => $data): ?>
        <tr>
            <td><?=$key+1?></td>
            <td><?=$data['NOPQ']?></td>
            <td><?=$data['NM_WP_SPPT']?></td>
            <td><?=$data['JALAN_OP']?><br><?=$data['JLN_WP_SPPT']?></td>
        </tr>
        <?php endforeach ?>
    </table>
</body>
</html>