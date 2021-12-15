<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Tagihan</title>
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
                <p class="clear-mp">Kompleks Panorama Indah Sindeka, Salak<br>Telp. 0627-7433003  Fax. 0627-7433003 KodePos : 22272</p>
            </center>
        </div>
        <br>
        <hr>
    </div>
    <?php foreach($datas as $data): ?>
    <div class="print-area" style="width:950px;margin:auto">
        <div style="margin-top:190px;"></div>
        <center>
            <h3 class="clear-mp">SURAT TAGIHAN</h3>
            <h4 class="clear-mp">NOMOR : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h4>
        </center>
        <br><br><br>
        <p>Dengan hormat disampaikan kepada :</p>

        <table width="100%">
            <tr>
                <td>No. ID</td>
                <td>:</td>
                <td><?= $data['SUBJEK_PAJAK_ID'] ?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?= $data['NM_WP'] ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?= $data['JALAN_WP']. ', ' .$data['KELURAHAN_WP']. ', ' .$data['KOTA_WP'] ?></td>
            </tr>
        </table>

        <p>Berdasarkan data tunggakan pajak pada Sistem Informasi Pajak Bumi Dan Bangunan Perdesaan dan Perkotaan (PBB-P2) keadaan s/d tanggal <?=date('d-m-Y')?> Saudara masih memiliki tunggakan PBB yang belum terbayar dengan daftar sebagai berikut:</p>

    
        <table border="1" cellpadding="5" cellspacing="0" width="100%">
            <tr>
                <th>NO</th>
                <th>NOP</th>
                <th>TAHUN PAJAK</th>
                <th>TANGGAL JATUH TEMPO</th>
                <th>POKOK PBB</th>
                <th>DENDA</th>
                <th>JUMLAH</th>
            </tr>
            <?php
            $no=1;
            $qobjpajak = $qb->rawQuery("SELECT * FROM QOBJEKPAJAK WHERE SUBJEK_PAJAK_ID = '$data[SUBJEK_PAJAK_ID]'")->get();
            foreach($qobjpajak as $n => $objpajak):
                $sppts = $qb->rawQuery("SELECT * FROM SPPT WHERE
                    KD_PROPINSI = '$objpajak[KD_PROPINSI]' AND
                    KD_DATI2 = '$objpajak[KD_DATI2]' AND
                    KD_KECAMATAN = '$objpajak[KD_KECAMATAN]' AND
                    KD_KELURAHAN = '$objpajak[KD_KELURAHAN]' AND
                    KD_BLOK = '$objpajak[KD_BLOK]' AND
                    NO_URUT = '$objpajak[NO_URUT]' AND
                    KD_JNS_OP = '$objpajak[KD_JNS_OP]' AND
                    STATUS_PEMBAYARAN_SPPT <> 1
                ORDER BY THN_PAJAK_SPPT")->get();
                if(empty($sppts)) continue;
                $tahun_pajak_sppt = "";
                $tgl_jatuh_tempo_sppt = "";
                $pbb_terhutang_sppt = "";
                $total_sppt = "";
                $denda_sppt = "";
                foreach($sppts as $sppt)
                {
                    $tahun_pajak_sppt .= $sppt['THN_PAJAK_SPPT'] . "<br>";
                    $tgl_jatuh_tempo_sppt .= $sppt['TGL_JATUH_TEMPO_SPPT']->format('d-m-Y') . "<br>";
                    $pbb_terhutang_sppt .= $sppt['PBB_TERHUTANG_SPPT'] . "<br>";
                    $total_sppt .= $sppt['PBB_YG_HARUS_DIBAYAR_SPPT'] . "<br>";
                    $denda_sppt .= ($sppt['PBB_YG_HARUS_DIBAYAR_SPPT']-$sppt['PBB_TERHUTANG_SPPT']) . "<br>";
                }
            ?>
            <tr>
                <td><?=$no++?></td>
                <td><?=$objpajak['NOPQ']?></td>
                <td><?=$tahun_pajak_sppt?></td>
                <td><?=$tgl_jatuh_tempo_sppt?></td>
                <td><?=$pbb_terhutang_sppt?></td>
                <td><?=$denda_sppt?></td>
                <td><?=$total_sppt?></td>
            </tr>
            <?php endforeach ?>
        </table>


        <p>Diharapkan saudara dapat segera melunasi tagihan dimaksud. Pembayaran dapat dilakukan melalui: Teller Bank Sumut Seluruh Indonesia, ATM Bank Sumut, Aplikasi SUMUT Mobile, Kantor Pos dan berbagai ecommerce (Gopay, LinkAJa, OVO, BukaLapak, Tokopedia). Gunakan NOP dan Tahun Pajak sebagai Kode Pembayaran.</p>

        <p>Demikian disampaikan, atas partisipasi dan kepatuhan Saudara dalam memenuhi kewajiban perpajakan diucapkan terima kasih.</p>

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