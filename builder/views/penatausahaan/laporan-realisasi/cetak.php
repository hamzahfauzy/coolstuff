<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Realisasi</title>
    <style>
    .clear-mp {
        margin:0;
        padding:0;
    }
    table { page-break-inside:auto }
    table tr {
        page-break-inside:avoid; page-break-after:auto
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
    <center>
        <b>LAPORAN REALISASI PAJAK BUMI DAN BANGUNAN PERDESAAN DAN PERKOTAAN (PBB-P2) TAHUN <?=$_POST['tahun_pajak']?><br>KABUPATEN PAKPAK BHARAT<br>PER DESA</b>
    </center>
    <table width="100%">
        <tr>
            <td width="50%" style="text-align:center"><b>PERIODE PEMBAYARAN : s/d <?= tanggal_indo(date('Y-m-d')) ?></b></td>
            <td width="50%" style="text-align:center"><b>TANGGAL JATUH TEMPO : <?= tanggal_indo($tempo['TGL_JATUH_TEMPO_SPPT']->format('Y-m-d')) ?></b></td>
        </tr>
    </table>
    <br>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">KODE DESA</th>
            <th rowspan="2">KECAMATAN/DESA</th>
            <th colspan="2">PENETAPAN <?=$_POST['tahun_pajak']?></th>
            <th colspan="3">REALISASI <?=$_POST['tahun_pajak']?> *)</th>
            <th colspan="3">SALDO TAHUN <?=$_POST['tahun_pajak']?></th>
            <th colspan="2">SALDO TAHUN 2009 S/D <?=$_POST['tahun_pajak']-1?></th>
            <th colspan="3">SISA TAGIHAN **)</th>
            <th rowspan="2">STATUS LUNAS DI SISTEM PBB</th>
            <th rowspan="2">KETERANGAN</th>
        </tr>
        <tr>
            <th>SPPT (Lbr)</th>
            <th>PBB (Rp)</th>
            <th>SPPT (Lbr)</th>
            <th>PBB (Rp)</th>
            <th>DENDA (Rp)</th>
            <th>SPPT (Lbr)</th>
            <th>PBB (Rp)</th>
            <th>% <?=$_POST['tahun_pajak']?></th>
            <th>SPPT (Lbr)</th>
            <th>PBB (Rp)</th>
            <th>SPPT (Lbr)</th>
            <th>PBB (Rp)</th>
            <th>% 2009 s/d <?=$_POST['tahun_pajak']?></th>
        </tr>
        <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
            <th>10</th>
            <th>11</th>
            <th>12</th>
            <th>13</th>
            <th>14</th>
            <th>15</th>
            <th>16</th>
            <th>17</th>
            <th>18</th>
        </tr>
        <?php 
        $no = 1;
        foreach($kecamatan as $kec): 
            $sppt_kec = $qb->rawQuery("SELECT SUM(LUAS_BUMI_SPPT) as L_SPPT, SUM(PBB_YG_HARUS_DIBAYAR_SPPT) as PBB_SPPT FROM SPPT WHERE KD_KECAMATAN='$kec[KD_KECAMATAN]' AND THN_PAJAK_SPPT = '$_POST[tahun_pajak]'")->first();
            $realisasi_kec = $qb->rawQuery("SELECT SUM(DENDA_SPPT) as DENDA, SUM(JML_SPPT_YG_DIBAYAR) as PBB_SPPT FROM PEMBAYARAN_SPPT WHERE KD_KECAMATAN='$kec[KD_KECAMATAN]' AND THN_PAJAK_SPPT = '$_POST[tahun_pajak]'")->first();
            $saldo_kec = $qb->rawQuery("SELECT SUM(SPPT.LUAS_BUMI_SPPT) as L_SPPT, SUM(SPPT.PBB_YG_HARUS_DIBAYAR_SPPT) as PBB_SPPT FROM SPPT LEFT JOIN PEMBAYARAN_SPPT ON PEMBAYARAN_SPPT.KD_PROPINSI = SPPT.KD_PROPINSI AND PEMBAYARAN_SPPT.KD_DATI2 = SPPT.KD_DATI2 AND PEMBAYARAN_SPPT.KD_KECAMATAN = SPPT.KD_KECAMATAN AND PEMBAYARAN_SPPT.KD_KELURAHAN = SPPT.KD_KELURAHAN AND PEMBAYARAN_SPPT.KD_BLOK = SPPT.KD_BLOK AND PEMBAYARAN_SPPT.NO_URUT = SPPT.NO_URUT AND PEMBAYARAN_SPPT.KD_JNS_OP = SPPT.KD_JNS_OP AND PEMBAYARAN_SPPT.THN_PAJAK_SPPT = SPPT.THN_PAJAK_SPPT WHERE SPPT.KD_KECAMATAN='$kec[KD_KECAMATAN]' AND SPPT.THN_PAJAK_SPPT = '$_POST[tahun_pajak]' AND PEMBAYARAN_SPPT.JML_SPPT_YG_DIBAYAR IS NULL")->first();
            $saldo_kec_awal = $qb->rawQuery("SELECT SUM(SPPT.LUAS_BUMI_SPPT) as L_SPPT, SUM(SPPT.PBB_YG_HARUS_DIBAYAR_SPPT) as PBB_SPPT FROM SPPT LEFT JOIN PEMBAYARAN_SPPT ON PEMBAYARAN_SPPT.KD_PROPINSI = SPPT.KD_PROPINSI AND PEMBAYARAN_SPPT.KD_DATI2 = SPPT.KD_DATI2 AND PEMBAYARAN_SPPT.KD_KECAMATAN = SPPT.KD_KECAMATAN AND PEMBAYARAN_SPPT.KD_KELURAHAN = SPPT.KD_KELURAHAN AND PEMBAYARAN_SPPT.KD_BLOK = SPPT.KD_BLOK AND PEMBAYARAN_SPPT.NO_URUT = SPPT.NO_URUT AND PEMBAYARAN_SPPT.KD_JNS_OP = SPPT.KD_JNS_OP AND PEMBAYARAN_SPPT.THN_PAJAK_SPPT = SPPT.THN_PAJAK_SPPT WHERE SPPT.KD_KECAMATAN='$kec[KD_KECAMATAN]' AND SPPT.THN_PAJAK_SPPT IN ($in_year) AND PEMBAYARAN_SPPT.JML_SPPT_YG_DIBAYAR IS NULL")->first();
            if($realisasi_kec['PBB_SPPT'] == 0)
                $presentase_kec = 0;
            else
                $presentase_kec = $saldo_kec['PBB_SPPT'] == 0 ? 100 : 100-($saldo_kec['PBB_SPPT']/$realisasi_kec['PBB_SPPT']*100);

            $sisa_tagihan_sppt_kec = ($saldo_kec_awal['L_SPPT']/1000)+($saldo_kec['L_SPPT']/1000);
            $sisa_tagihan_pbb_kec  = $saldo_kec_awal['PBB_SPPT']+$saldo_kec['PBB_SPPT'];
            $realisasi_harusnya_kec = $realisasi_kec['PBB_SPPT'] + $sisa_tagihan_pbb_kec;
            $presentase_tagihan_kec = $sisa_tagihan_pbb_kec / $realisasi_harusnya_kec * 100;
            $presentase_tagihan_kec = 100-$presentase_tagihan_kec;
        ?>
        <tr>
            <td style="font-weight:bold;text-align:center;"><?=numberToRomanRepresentation($no)?></td>
            <td></td>
            <td style="font-weight:bold;font-style:italic"><?=$kec['NM_KECAMATAN']?></td>
            <td style="text-align:right"><?=number_format($sppt_kec['L_SPPT']/1000)?></td>
            <td style="text-align:right"><?=number_format($sppt_kec['PBB_SPPT'])?></td>
            <td style="text-align:right"><?=number_format($sppt_kec['L_SPPT']/1000)?></td>
            <td style="text-align:right"><?=number_format($realisasi_kec['PBB_SPPT'])?></td>
            <td style="text-align:right"><?=number_format($realisasi_kec['DENDA'])?></td>
            <td style="text-align:right"><?=number_format($saldo_kec['L_SPPT']/1000)?></td>
            <td style="text-align:right"><?=number_format($saldo_kec['PBB_SPPT'])?></td>
            <td style="text-align:right"><?=number_format($presentase_kec)?> %</td>
            <td style="text-align:right"><?=number_format($saldo_kec_awal['L_SPPT']/1000)?></td>
            <td style="text-align:right"><?=number_format($saldo_kec_awal['PBB_SPPT'])?></td>
            <td style="text-align:right"><?=number_format($sisa_tagihan_sppt_kec)?></td>
            <td style="text-align:right"><?=number_format($sisa_tagihan_pbb_kec)?></td>
            <td style="text-align:right"><?=number_format($presentase_tagihan_kec)?> %</td>
            <?php if($presentase_tagihan_kec == 100): ?>
            <td style="background:green;color:#FFF">LUNAS</td>
            <?php else: ?>
            <td>BELUM LUNAS</td>
            <?php endif ?>
            <td></td>
        </tr>
        <?php
            $no_kel = 1;
            $kelurahan = $qb->select('REF_KELURAHAN')->where('KD_KECAMATAN',$kec['KD_KECAMATAN'])->orderby('KD_KELURAHAN')->get();
            foreach($kelurahan as $kel):
                $sppt_kel = $qb->rawQuery("SELECT SUM(LUAS_BUMI_SPPT) as L_SPPT, SUM(PBB_YG_HARUS_DIBAYAR_SPPT) as PBB_SPPT FROM SPPT WHERE KD_KECAMATAN='$kec[KD_KECAMATAN]' AND KD_KELURAHAN = '$kel[KD_KELURAHAN]' AND THN_PAJAK_SPPT = '$_POST[tahun_pajak]'")->first();
                $realisasi_kel = $qb->rawQuery("SELECT SUM(DENDA_SPPT) as DENDA, SUM(JML_SPPT_YG_DIBAYAR) as PBB_SPPT FROM PEMBAYARAN_SPPT WHERE KD_KECAMATAN='$kec[KD_KECAMATAN]' AND KD_KELURAHAN = '$kel[KD_KELURAHAN]' AND THN_PAJAK_SPPT = '$_POST[tahun_pajak]'")->first();
                $saldo_kel = $qb->rawQuery("SELECT SUM(SPPT.LUAS_BUMI_SPPT) as L_SPPT, SUM(SPPT.PBB_YG_HARUS_DIBAYAR_SPPT) as PBB_SPPT FROM SPPT LEFT JOIN PEMBAYARAN_SPPT ON PEMBAYARAN_SPPT.KD_PROPINSI = SPPT.KD_PROPINSI AND PEMBAYARAN_SPPT.KD_DATI2 = SPPT.KD_DATI2 AND PEMBAYARAN_SPPT.KD_KECAMATAN = SPPT.KD_KECAMATAN AND PEMBAYARAN_SPPT.KD_KELURAHAN = SPPT.KD_KELURAHAN AND PEMBAYARAN_SPPT.KD_BLOK = SPPT.KD_BLOK AND PEMBAYARAN_SPPT.NO_URUT = SPPT.NO_URUT AND PEMBAYARAN_SPPT.KD_JNS_OP = SPPT.KD_JNS_OP AND PEMBAYARAN_SPPT.THN_PAJAK_SPPT = SPPT.THN_PAJAK_SPPT WHERE SPPT.KD_KECAMATAN='$kec[KD_KECAMATAN]' AND SPPT.KD_KELURAHAN = '$kel[KD_KELURAHAN]' AND SPPT.THN_PAJAK_SPPT = '$_POST[tahun_pajak]' AND PEMBAYARAN_SPPT.JML_SPPT_YG_DIBAYAR IS NULL")->first();
                $saldo_kel_awal = $qb->rawQuery("SELECT SUM(SPPT.LUAS_BUMI_SPPT) as L_SPPT, SUM(SPPT.PBB_YG_HARUS_DIBAYAR_SPPT) as PBB_SPPT FROM SPPT LEFT JOIN PEMBAYARAN_SPPT ON PEMBAYARAN_SPPT.KD_PROPINSI = SPPT.KD_PROPINSI AND PEMBAYARAN_SPPT.KD_DATI2 = SPPT.KD_DATI2 AND PEMBAYARAN_SPPT.KD_KECAMATAN = SPPT.KD_KECAMATAN AND PEMBAYARAN_SPPT.KD_KELURAHAN = SPPT.KD_KELURAHAN AND PEMBAYARAN_SPPT.KD_BLOK = SPPT.KD_BLOK AND PEMBAYARAN_SPPT.NO_URUT = SPPT.NO_URUT AND PEMBAYARAN_SPPT.KD_JNS_OP = SPPT.KD_JNS_OP AND PEMBAYARAN_SPPT.THN_PAJAK_SPPT = SPPT.THN_PAJAK_SPPT WHERE SPPT.KD_KECAMATAN='$kec[KD_KECAMATAN]' AND SPPT.KD_KELURAHAN = '$kel[KD_KELURAHAN]' AND SPPT.THN_PAJAK_SPPT IN ($in_year) AND PEMBAYARAN_SPPT.JML_SPPT_YG_DIBAYAR IS NULL")->first();
                if($realisasi_kel['PBB_SPPT'] == 0)
                    $presentase_kel = 0;
                else
                    $presentase_kel = $saldo_kel['PBB_SPPT'] == 0 ? 100 : 100-($saldo_kel['PBB_SPPT']/$realisasi_kel['PBB_SPPT']*100);

                $sisa_tagihan_sppt_kel = ($saldo_kel_awal['L_SPPT']/1000)+($saldo_kel['L_SPPT']/1000);
                $sisa_tagihan_pbb_kel  = $saldo_kel_awal['PBB_SPPT']+$saldo_kel['PBB_SPPT'];
                $realisasi_harusnya_kel = $realisasi_kel['PBB_SPPT'] + $sisa_tagihan_pbb_kel;
                $presentase_tagihan_kel = $sisa_tagihan_pbb_kel / $realisasi_harusnya_kel * 100;
                $presentase_tagihan_kel = 100-$presentase_tagihan_kel;
        ?>
        <tr>
            <td><?=$no_kel++?></td>
            <td><?=$kel['KD_KECAMATAN'].$kel['KD_KELURAHAN']?></td>
            <td><?=$kel['NM_KELURAHAN']?></td>
            <td style="text-align:right"><?=number_format($sppt_kel['L_SPPT']/1000)?></td>
            <td style="text-align:right"><?=number_format($sppt_kel['PBB_SPPT'])?></td>
            <td style="text-align:right"><?=number_format($sppt_kel['L_SPPT']/1000)?></td>
            <td style="text-align:right"><?=number_format($realisasi_kel['PBB_SPPT'])?></td>
            <td style="text-align:right"><?=number_format($realisasi_kel['DENDA'])?></td>
            <td style="text-align:right"><?=number_format($saldo_kel['L_SPPT']/1000)?></td>
            <td style="text-align:right"><?=number_format($saldo_kel['PBB_SPPT'])?></td>
            <td style="text-align:right"><?=number_format($presentase_kel)?> %</td>
            <td style="text-align:right"><?=number_format($saldo_kel_awal['L_SPPT']/1000)?></td>
            <td style="text-align:right"><?=number_format($saldo_kel_awal['PBB_SPPT'])?></td>
            <td style="text-align:right"><?=number_format($sisa_tagihan_sppt_kel)?></td>
            <td style="text-align:right"><?=number_format($sisa_tagihan_pbb_kel)?></td>
            <td style="text-align:right"><?=number_format($presentase_tagihan_kel)?> %</td>
            <?php if($presentase_tagihan_kel == 100): ?>
            <td style="background:green;color:#FFF">LUNAS</td>
            <?php else: ?>
            <td>BELUM LUNAS</td>
            <?php endif ?>
            <td></td>
        </tr>
        <?php 
            endforeach;
        $no++; 
        endforeach;
        ?>
    </table>
</body>
</html>