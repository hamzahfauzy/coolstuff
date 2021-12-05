<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak DBKB</title>
    <style>
    body {
        margin:10mm;
    }
    </style>
</head>
<body onload="window.print()">
    <h2 align="center">DAFTAR BIAYA KOMPONEN BANGUNAN (DBKB)<br>TAHUN <?=$_GET['tahun_pajak']?></h2>
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
    </table>
    <?php if($type == "bangunan_standard"): ?>

        <table border="1" width="100%">
            <tr>
                <th>NO</th>
                <th>KOMPONEN JENIS PENGGUNAAN BANGUNAN</th>
                <th>LUAS BANGUNAN</th>
                <th>JUMLAH LANTAI</th>
                <th>NJOP/M2 (Rp.1000)</th>
            </tr>
            <?php $i = 1; foreach($datas as $key => $data): ?>
            <tr>
                <td align="center"><?=$i?></td>
                <td align="center"><?=$data['JPB']?></td>
                <td align="center"><?=$data['LUAS']?></td>
                <td align="center"><?=$data['LANTAI']?></td>
                <td align="center"><?=$data['NJOP']?></td>
            </tr>
            <?php $i++; endforeach ?>
        </table>
    
    <?php elseif($type=="perkantoran_swasta"): ?>

        
        <table border="1" width="100%">
            <tr>
                <th>NO</th>
                <th>KOMPONEN JENIS PENGGUNAAN BANGUNAN</th>
                <th>JUMLAH LANTAI</th>
                <th>KELAS</th>
                <th>NJOP/M2 (Rp.1000)</th>
            </tr>
            <tr>
                <td colspan="5" style="padding:12px">1.4 Perkantoran</th>
            </tr>
            <?php $i = 1; foreach($datas as $key => $data): ?>
            <tr>
                <td align="center"><?=$i?></td>
                <td align="center"><?=$data['JPB']?></td>
                <td align="center"><?=$data['LANTAI']?></td>
                <td align="center"><?=$data['KELAS']?></td>
                <td align="center"><?=$data['NJOP']?></td>
            </tr>
            <?php $i++; endforeach ?>
        </table>

    <?php elseif($type=="pabrik"): ?>

        
        <table border="1" width="100%">
            <tr>
                <th>NO</th>
                <th>KOMPONEN JENIS PENGGUNAAN BANGUNAN</th>
                <th>Lebar Bentangan</th>
                <th>Tinggi Kolam</th>
                <th>NJOP/M2 (Rp.1000)</th>
            </tr>
            <tr>
                <td colspan="5" style="padding:12px">1.5 Bangunan Pabrik</th>
            </tr>
            <?php $i = 1; foreach($datas as $key => $data): ?>
            <tr>
                <td align="center"><?=$i?></td>
                <td align="center"><?=$data['JPB']?></td>
                <td align="center"><?=$data['LUAS']?></td>
                <td align="center"><?=$data['LANTAI']?></td>
                <td align="center"><?=$data['NJOP']?></td>
            </tr>
            <?php $i++; endforeach ?>
        </table>

    <?php elseif($type=="pertokoan"): ?>

        
        <table border="1" width="100%">
            <tr>
                <th>NO</th>
                <th>KOMPONEN JENIS PENGGUNAAN BANGUNAN</th>
                <th>JUMLAH LANTAI</th>
                <th>KELAS</th>
                <th>NJOP/M2 (Rp.1000)</th>
            </tr>
            <tr>
                <td colspan="5" style="padding:12px">1.6 Pertokoan/Apotik/Pasar/Ruko</th>
            </tr>
            <?php $i = 1; foreach($datas as $key => $data): ?>
            <tr>
                <td align="center"><?=$i?></td>
                <td align="center"><?=$data['JPB']?></td>
                <td align="center"><?=$data['LANTAI']?></td>
                <td align="center"><?=$data['KELAS']?></td>
                <td align="center"><?=$data['NJOP']?></td>
            </tr>
            <?php $i++; endforeach ?>
        </table>

    <?php elseif($type=="rumah_sakit"): ?>

        
        <table border="1" width="100%">
            <tr>
                <th>NO</th>
                <th>KOMPONEN JENIS PENGGUNAAN BANGUNAN</th>
                <th>JUMLAH LANTAI</th>
                <th>KELAS</th>
                <th>NJOP/M2 (Rp.1000)</th>
            </tr>
            <tr>
                <td colspan="5" style="padding:12px">1.7 Rumah Sakit</th>
            </tr>
            <?php $i = 1; foreach($datas as $key => $data): ?>
            <tr>
                <td align="center"><?=$i?></td>
                <td align="center"><?=$data['JPB']?></td>
                <td align="center"><?=$data['LANTAI']?></td>
                <td align="center"><?=$data['KELAS']?></td>
                <td align="center"><?=$data['NJOP']?></td>
            </tr>
            <?php $i++; endforeach ?>
        </table>

    <?php elseif($type=="hotel"): ?>

        
        <table border="1" width="100%">
            <tr>
                <th>NO</th>
                <th>KOMPONEN JENIS PENGGUNAAN BANGUNAN</th>
                <th>JUMLAH LANTAI</th>
                <th>BINTANG</th>
                <th>NJOP/M2 (Rp.1000)</th>
            </tr>
            <tr>
                <td colspan="5" style="padding:12px">1.10 Hotel/Wisma</th>
            </tr>
            <?php $i = 1; foreach($datas as $key => $data): ?>
            <tr>
                <td align="center"><?=$i?></td>
                <td align="center"><?=$data['JPB']?></td>
                <td align="center"><?=$data['LANTAI']?></td>
                <td align="center"><?=$data['BINTANG']?></td>
                <td align="center"><?=$data['NJOP']?></td>
            </tr>
            <?php $i++; endforeach ?>
        </table>

     <?php elseif($type=="olahraga"): ?>

        
        <table border="1" width="100%">
            <tr>
                <th>NO</th>
                <th>KOMPONEN JENIS PENGGUNAAN BANGUNAN</th>
                <th>Tipe</th>
                <th>NJOP/M2 (Rp.1000)</th>
            </tr>
            <tr>
                <td colspan="5" style="padding:12px">1.8 Bangunan Parkir</th>
            </tr>
            <?php $i = 1; foreach($datas as $key => $data): ?>
            <tr>
                <td align="center"><?=$i?></td>
                <td align="center"><?=$data['JPB']?></td>
                <td align="center"><?=$data['TIPE']?></td>
                <td align="center"><?=$data['NJOP']?></td>
            </tr>
            <?php $i++; endforeach ?>
        </table>

    <?php elseif($type=="apartemen"): ?>

        
        <table border="1" width="100%">
            <tr>
                <th>NO</th>
                <th>KOMPONEN JENIS PENGGUNAAN BANGUNAN</th>
                <th>JUMLAH LANTAI</th>
                <th>KELAS</th>
                <th>NJOP/M2 (Rp.1000)</th>
            </tr>
            <tr>
                <td colspan="5" style="padding:12px">1.12 Apartemen</th>
            </tr>
            <?php $i = 1; foreach($datas as $key => $data): ?>
            <tr>
                <td align="center"><?=$i?></td>
                <td align="center"><?=$data['JPB']?></td>
                <td align="center"><?=$data['LANTAI']?></td>
                <td align="center"><?=$data['KELAS']?></td>
                <td align="center"><?=$data['NJOP']?></td>
            </tr>
            <?php $i++; endforeach ?>
        </table>

    <?php elseif($type=="kanopi"): ?>

        
        <table border="1" width="100%">
            <tr>
                <th>NO</th>
                <th>KOMPONEN JENIS PENGGUNAAN BANGUNAN</th>
                <th>TIPE</th>
                <th>NJOP/M2 (Rp.1000)</th>
            </tr>
            <tr>
                <td colspan="5" style="padding:12px">1.12 Daya Dukung</th>
            </tr>
            <?php $i = 1; foreach($datas as $key => $data): ?>
            <tr>
                <td align="center"><?=$i?></td>
                <td align="center"><?=$data['JPB']?></td>
                <td align="center"><?=$data['TIPE']?></td>
                <td align="center"><?=$data['NJOP']?></td>
            </tr>
            <?php $i++; endforeach ?>
        </table>

    <?php elseif($type=="tangki_minyak"): ?>

        
        <table border="1" width="100%">
            <tr>
                <th>NO</th>
                <th>KOMPONEN JENIS PENGGUNAAN BANGUNAN</th>
                <th>KAPASITAS</th>
                <th>NJOP/M2 (Rp.1000)</th>
            </tr>
            <tr>
                <td colspan="5" style="padding:12px">1.16 Tangki Minyak</th>
            </tr>
            <?php $i = 1; foreach($datas as $key => $data): ?>
            <tr>
                <td align="center"><?=$i?></td>
                <td align="center"><?=$data['JPB']?></td>
                <td align="center"><?=$data['KAPASITAS']?></td>
                <td align="center"><?=$data['NJOP']?></td>
            </tr>
            <?php $i++; endforeach ?>
        </table>

    <?php elseif($type=="gedung_sekolah"): ?>

        <table border="1" width="100%">
            <tr>
                <th>NO</th>
                <th>KOMPONEN JENIS PENGGUNAAN BANGUNAN</th>
                <th>JUMLAH LANTAI</th>
                <th>KELAS</th>
                <th>NJOP/M2 (Rp.1000)</th>
            </tr>
            <tr>
                <td colspan="5" style="padding:12px">1.17 Gedung Sekolah</th>
            </tr>
            <?php $i = 1; foreach($datas as $key => $data): ?>
            <tr>
                <td align="center"><?=$i?></td>
                <td align="center"><?=$data['JPB']?></td>
                <td align="center"><?=$data['LANTAI']?></td>
                <td align="center"><?=$data['KELAS']?></td>
                <td align="center"><?=$data['NJOP']?></td>
            </tr>
            <?php $i++; endforeach ?>
        </table>

    <?php elseif($type=="fasilitas1"): ?>

        <table border="1" width="100%">
            <tr>
                <th>NO</th>
                <th>KOMPONEN JENIS PENGGUNAAN BANGUNAN</th>
                <th>KELAS</th>
                <th>NJOP/M2 (Rp.1000)</th>
            </tr>
            <tr>
                <td colspan="5" style="padding:12px">Fasilitas</th>
            </tr>
            <?php $i = 1; foreach($datas as $key => $data): ?>
            <tr>
                <td align="center"><?=$i?></td>
                <td align="center"><?=$data['JPB']?></td>
                <td align="center"><?=$data['KELAS']?></td>
                <td align="center"><?=$data['NJOP']?></td>
            </tr>
            <?php $i++; endforeach ?>
        </table>

    
    <?php elseif($type=="fasilitas2"): ?>

        <table border="1" width="100%">
            <tr>
                <th>NO</th>
                <th>KOMPONEN JENIS PENGGUNAAN BANGUNAN</th>
                <th>KELAS</th>
                <th>NJOP/M2 (Rp.1000)</th>
            </tr>
            <tr>
                <td colspan="5" style="padding:12px">Fasilitas</th>
            </tr>
            <?php $i = 1; foreach($datas as $key => $data): ?>
            <tr>
                <td align="center"><?=$i?></td>
                <td align="center"><?=$data['JPB']?></td>
                <td align="center"><?=$data['KELAS']?></td>
                <td align="center"><?=$data['NJOP']?></td>
            </tr>
            <?php $i++; endforeach ?>
        </table>

    <?php elseif($type=="fasilitas3"): ?>

        <table border="1" width="100%">
            <tr>
                <th>NO</th>
                <th>KOMPONEN JENIS PENGGUNAAN BANGUNAN</th>
                <th>NJOP/M2 (Rp.1000)</th>
            </tr>
            <tr>
                <td colspan="5" style="padding:12px">Fasilitas</th>
            </tr>
            <?php $i = 1; foreach($datas as $key => $data): ?>
            <tr>
                <td align="center"><?=$i?></td>
                <td align="center"><?=$data['JPB']?></td>
                <td align="center"><?=$data['NJOP']?></td>
            </tr>
            <?php $i++; endforeach ?>
        </table>

    <?php elseif($type=="material"): ?>

        <table border="1" width="100%">
            <tr>
                <th>NO</th>
                <th>KOMPONEN JENIS PENGGUNAAN BANGUNAN</th>
                <th>NJOP/M2 (Rp.1000)</th>
            </tr>
            <tr>
                <td colspan="5" style="padding:12px">Fasilitas</th>
            </tr>
            <?php $i = 1; foreach($datas as $key => $data): ?>
            <tr>
                <td align="center"><?=$i?></td>
                <td align="center"><?=$data['JPB']?></td>
                <td align="center"><?=$data['NJOP']?></td>
            </tr>
            <?php $i++; endforeach ?>
        </table>
    
    <?php endif ?>
</body>
</html>