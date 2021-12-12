<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Status Wajib Pajak</title>
    <style>
    .clear-mp {
        margin:0;
        padding:0;
    }
    .page-break {
        page-break-after:always;
    }
    .header-page {
        width:100%;
        position:fixed;
        top:0;
        margin-top:10px;
    }
    </style>
</head>
<body onload="window.print()">
    <div class="header-page">
        <img src="<?=get_file_storage('installation/'.$installation->logo)?>" width="100px" style="position:absolute;">
        <div>
            <center>
                <h2 class="clear-mp">
                    PEMERINTAH KABUPATEN PAKPAK BHARAT<br>
                    BADAN PENGELOLA KEUANGAN PENDAPATAN DAN ASET DAERAH
                </h2>
                <p class="clear-mp">Kompleks Panorama Indah Sindeka, Salak 22272<br>SALAK</p>
            </center>
        </div>
        <br>
        <hr>
    </div>
    <?php 
    foreach($datas as $data): 
        $query = "SELECT * FROM PEMBAYARAN_SPPT WHERE
          KD_PROPINSI = '$data[KD_PROPINSI]' AND
          KD_DATI2 = '$data[KD_DATI2]' AND
          KD_KECAMATAN = '$data[KD_KECAMATAN]' AND
          KD_KELURAHAN = '$data[KD_KELURAHAN]' AND
          KD_BLOK = '$data[KD_BLOK]' AND
          NO_URUT = '$data[NO_URUT]' AND
          KD_JNS_OP = '$data[KD_JNS_OP]' AND
          THN_PAJAK_SPPT IN ($in_year)
        ORDER BY THN_PAJAK_SPPT DESC";
        $sppts = $qb->rawQuery("SELECT * FROM SPPT WHERE
            KD_PROPINSI = '$data[KD_PROPINSI]' AND
            KD_DATI2 = '$data[KD_DATI2]' AND
            KD_KECAMATAN = '$data[KD_KECAMATAN]' AND
            KD_KELURAHAN = '$data[KD_KELURAHAN]' AND
            KD_BLOK = '$data[KD_BLOK]' AND
            NO_URUT = '$data[NO_URUT]' AND
            KD_JNS_OP = '$data[KD_JNS_OP]' AND
            THN_PAJAK_SPPT IN ($in_year)
        ORDER BY THN_PAJAK_SPPT DESC")->get();
        $riwayats = $qb->rawQuery($query)->get();
    ?>
    <div class="print-area" style="width:950px;margin:auto">
        <div style="margin-top:190px;"></div>
        <center>
            <h3 class="clear-mp">KETERANGAN STATUS WAJIB PAJAK</h3>
            <h4 class="clear-mp">NOMOR : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h4>
        </center>
        <br><br><br>
        <p>Dengan ini diberitahukan bahwa berdasarkan hasil penelitian, kami sampaikan bahwa Wajib Pajak :</p>

        <div style="width:650px; margin:auto;">
        <table>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?= $data['NM_WP'] ?></td>
            </tr>
            <tr>
                <td>NOP</td>
                <td>:</td>
                <td><?= $data['NOPQ'] ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= $data['JALAN_WP']. ', ' .$data['KELURAHAN_WP']. ', ' .$data['KOTA_WP'] ?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <td><b><?=count($riwayats) == 5 ? 'VALID' : 'TIDAK VALID' ?></b></td>
            </tr>
            <tr>
                <td>Alamat Objek Pajak</td>
                <td>:</td>
                <td><?= $data['JALAN_OP']. ', ' .$data['NM_KELURAHAN']. ', ' .$data['NM_KECAMATAN'] ?></td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>:</td>
                <td></td>
            </tr>
        </table>

        <br><br>

        <b>KEWAJIBAN</b>
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <tr>
                <th width="10px">NO</th>
                <th>TAHUN</th>
                <th>TERHUTANG</th>
                <th>PBB HARUS DIBAYAR</th>
                <th>JATUH TEMPO</th>
            </tr>
            <?php 
            $total = 0;
            foreach($sppts as $index => $sppt): 
                $total += $sppt['PBB_YG_HARUS_DIBAYAR_SPPT'];
            ?>
            <tr>
                <td><?=++$index?></td>
                <td><?=$sppt['THN_PAJAK_SPPT']?></td>
                <td><?=number_format($sppt['PBB_TERHUTANG_SPPT'])?></td>
                <td><?=number_format($sppt['PBB_YG_HARUS_DIBAYAR_SPPT'])?></td>
                <td><?=$sppt['TGL_JATUH_TEMPO_SPPT']->format('Y-m-d')?></td>
            </tr>
            <?php endforeach ?>
            <tr>
                <td colspan="3">Total</td>
                <td colspan="2"><?=number_format($total)?></td>
            </tr>
        </table>

        <br><br>

        <b>PEMBAYARAN</b>
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <tr>
                <th width="10px">NO</th>
                <th>TAHUN</th>
                <th>JML BAYAR</th>
                <th>TGL BAYAR</th>
                <th>TGL REKAM</th>
            </tr>
            <?php 
            $total = 0;
            foreach($riwayats as $n => $riwayat): 
                $total += $riwayat['JML_SPPT_YG_DIBAYAR'];
            ?>
            <tr>
                <td><?=++$n?></td>
                <td><?=$riwayat['THN_PAJAK_SPPT']?></td>
                <td><?=number_format($riwayat['JML_SPPT_YG_DIBAYAR'],0,',','.') ?></td>
                <td><?=$riwayat['TGL_PEMBAYARAN_SPPT']->format('Y-m-d')?></td>
                <td><?=$riwayat['TGL_REKAM_BYR_SPPT']->format('Y-m-d')?></td>
            </tr>
            <?php endforeach ?>
            <tr>
                <td colspan="2">Total</td>
                <td colspan="3"><?=number_format($total)?></td>
            </tr>
        </table>
        </div>

        <br><br>

        <p>Demikian disampaikan, untuk dipergunakan sebagaimana mestinya.</p>

        <br><br>

        <table align="right" style="margin-right:100px">
            <tr>
                <td>
                    Salak, <?=tanggal_indo(date('Y-m-d'))?><br>
                    <b><?=$xJabatan?></b>
                </td>
            </tr>
            <tr>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    <br><br><br><br><br>
                    <u><b><?=$xNama?></b></u><br>
                    <b>NIP. <?=$xNIP?></b>
                </td>
            </tr>
        </table>

        <div style="clear:both;"></div>

    </div>
    <div class="page-break"></div>
    <?php endforeach ?>
</body>
</html>