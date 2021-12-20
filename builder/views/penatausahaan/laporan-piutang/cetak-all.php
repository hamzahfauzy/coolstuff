<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Piutang</title>
    <style>
    body {
        margin:10mm;
        position:relative;
    }
    table tr {
        page-break-before: always;
    }

    thead {display: table-header-group;}
    </style>
</head>
<body onload="window.print()">
    <table border="1" width="100%" cellspacing="0" cellpadding="5px">
        <thead>
            <tr>
                <td colspan="8">
                    <h2 align="center">LAPORAN PIUTANG PAJAK BUMI DAN BANGUNAN PEDESAAN PERKOTAAN<br>TAHUN <?=$_GET['tahun_pajak']?></h2>
                    <table width="100%">
                        <tr>
                            <td width="50%">
                                <table>
                                    <tr>
                                        <td>TEMPAT PEMBAYARAN</td>
                                        <td>:</td>
                                        <td><?=$datas[0]['NM_TP']?></td>
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
                            </td>
                            <td>
                                <table align="right">
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>KECAMATAN</td>
                                        <td>:</td>
                                        <td><?=$datas[0]['KD_KECAMATAN'].' - '.$datas[0]['NM_KECAMATAN']?></td>
                                    </tr>
                                    <tr>
                                        <td>KELURAHAN</td>
                                        <td>:</td>
                                        <td><?=$datas[0]['KD_KELURAHAN'].' - '.$datas[0]['NM_KELURAHAN']?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th>NO</th>
                <th>NOP</th>
                <th>NAMA WAJIB PAJAK</th>
                <th>ALAMAT OBJEK PAJAK<br>WAJIB PAJAK</th>
                <th>LS TNH<br>LS BNG</th>
                <th>PAJAK TERHUTANG</th>
                <th>PERUBAHAN PAJAK</th>
                <th>KETERANGAN</th>
            </tr>
        </thead>
        <?php 
        $bumi_sppt = 0;
        $bng_sppt = 0;
        $hutang = 0;
        $jumlah = 0;
        foreach($datas as $key => $data): 
            $xTanggal = "";
            if(is_null($data['TGL_BAYAR']) || $data['TGL_BAYAR'] == "" || $data['TGL_BAYAR'] == "0")
                $xTanggal = "";
            else
                $xTanggal = $data['TGL_BAYAR'];
        
            $total_hutang = $data['PBB_YG_HARUS_DIBAYAR_SPPT'];
            if($data['JUM_UBAH'] != 0 || $xTanggal != "")
                $total_hutang = 0;

            $ccJum = 0;

            if(($data['PBB_YG_HARUS_DIBAYAR_SPPT'] <> $data['JUM_AKHIR'] && $data['JUM_UBAH'] <> 0) || abs($data['JUM_SELISIH']) == abs($data['PBB_YG_HARUS_DIBAYAR_SPPT']))
                $ccJum = $data['JUM_UBAH'];
            elseif($data['PBB_YG_HARUS_DIBAYAR_SPPT'] <> $data['JUM_AKHIR'] && $data['JUM_UBAH'] == 0)
                $ccJum = $data['PBB_YG_HARUS_DIBAYAR_SPPT'];               

            $bumi_sppt += $data['LUAS_BUMI_SPPT'];
            $bng_sppt += $data['LUAS_BNG_SPPT'];
            $hutang += $total_hutang;
            $jumlah += $ccJum;
        ?>
        <tr>
            <td><?=$key+1?></td>
            <td><?=$data['NOPQ']?></td>
            <td><?=$data['NM_WP_SPPT']?></td>
            <td><?=$data['JALAN_OP']?><br><?=$data['JLN_WP_SPPT']?></td>
            <td><?=$data['LUAS_BUMI_SPPT']?><br><?=$data['LUAS_BNG_SPPT']?></td>
            <td style="text-align:right"><?=number_format($total_hutang)?></td>
            <td style="text-align:right"><?=$ccJum>0??''?></td>
            <td>BELUM LUNAS</td>
        </tr>
        <?php endforeach ?>
        <tr>
            <td colspan="4" style="text-align:center;">JUMLAH</td>
            <td>
                <?=number_format($bumi_sppt)?><br>
                <?=number_format($bng_sppt)?>
            </td>
            <td style="text-align:right"><?=number_format($hutang)?></td>
            <td style="text-align:right"><?=$jumlah>0?number_format($jumlah):''?></td>
            <td></td>
        </tr>
    </table>

    <br><br><br>

    <table border="1" cellspacing="0" cellpadding="10" align="center">
        <tr>
            <th>JUMLAH OBJEK</th>
            <th>LUAS BUMI</th>
            <th>LUAS BANGUNGAN</th>
            <th>POKOK KETETAPAN</th>
        </tr>
        <tr>
            <td><?=count($datas)?></td>
            <td><?=number_format($bumi_sppt)?></td>
            <td><?=number_format($bng_sppt)?></td>
            <td><?=number_format($hutang)?></td>
        </tr>
        <tr>
            <td colspan="4">
                POKOK KETETAPAN : <?=terbilang($hutang)?>
            </td>
        </tr>
    </table>

    <br><br><br>

    <table width="300px" align="center">
        <tr>
            <td width="50%" style="text-align:center;">
                <b>Salak, <?= tanggal_indo($datas[0]['TGL_TERBIT_SPPT']->format('Y-m-d')) ?></b><br>
                <b><?=$xJabatan?></b>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;">
                <br><br><br><br><br>
                <u><b><?=$xNama?></b></u><br>
                <b>NIP. <?=$xNIP?></b>
            </td>
        </tr>
    </table>
</body>
</html>