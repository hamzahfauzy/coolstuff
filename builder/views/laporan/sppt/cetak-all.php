<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak SPPT Masal</title>
    <style>
    body {
        height:297mm;
        width:210mm;
        margin:0;
        padding:0;
        font-family:Arial;
        font-size:10px;
    }
    .report-page {
        padding:30px;
        padding-right:200px;
        margin-top:50px;
    }
    </style>
</head>
<body onload="window.print()">
    <?php foreach($datas as $data): ?>
    <div class="report-page">
        <?php
        $bumiPerM2 = 0; 
        $bngPerM2 = 0; 
        $njkp = 0;
        $tarif = 0;
        if($data['LUAS_BUMI_SPPT'] > 0)
            $bumiPerM2 = $data['NJOP_BUMI_SPPT']/$data['LUAS_BUMI_SPPT'];
        if($data['LUAS_BNG_SPPT'] > 0)
            $bngPerM2 = $data['NJOP_BNG_SPPT']/$data['LUAS_BNG_SPPT'];
        if(($data['NJOP_SPPT']-$data['NJOPTKP_SPPT']) > 0)
            $njkp = ($data['NJOP_SPPT']-$data['NJOPTKP_SPPT']);
        if($njkp > 0)
            $tarif = $data['PBB_TERHUTANG_SPPT']/$njkp*100;
            
    
        ?>
        <div id="kd_map" style="width:100%;text-align:right">
            <?= $data['KD_MAP'] ?>
        </div>

        <div id="tahun_pajak" style="text-align:right;margin-right:70px;font-weight:bold;">
            <?= $data['THN_PAJAK_SPPT'] ?>
        </div>

        <div id="nop" style="margin-left:10px;">
            <?= $data['NOPQ'] ?>
        </div>

        <br><br>
        
        <table width="100%">
            <tr>
                <td width="50%"></td>
                <td width="50%">
                    <b><?= $data['NM_WP_SPPT'] ?></b>
                </td>
            </tr>
            <tr>
                <td width="50%" style="vertical-align:top;">
                    <?= $data['JALAN_OP'] ?><br>
                    <?= $data['NM_KELURAHAN'] ?><br>
                    <?= $data['NM_KECAMATAN'] ?><br>
                </td>
                <td width="50%" style="vertical-align:top;">
                    <?= $data['JLN_WP_SPPT'] ?><br>
                    <?= $data['KELURAHAN_WP_SPPT'] ?><br>
                    <?= $data['KOTA_WP_SPPT'] ?><br>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <div style="margin-left:30px;">- Kode Pos: -</div>
                </td>
            </tr>
        </table>
        
        
        <br><br><br>
        
        <table width="100%">
            <tr>
                <td width="120px">BUMI</td>
                <td width="60px"><?= $data['LUAS_BUMI_SPPT'] ?></td>
                <td width="90px"><?= $data['KD_KLS_TANAH'] ?></td>
                <td width="50px" style="text-align:right;"><?= $bumiPerM2 ?></td>
                <td style="text-align:right;"><?= number_format($data['NJOP_BUMI_SPPT']) ?></td>
            </tr>
            <tr>
                <td>BANGUNAN</td>
                <td><?= $data['LUAS_BNG_SPPT'] ?></td>
                <td><?= $data['KD_KLS_BNG'] ?></td>
                <td style="text-align:right;"><?= $bngPerM2 ?></td>
                <td style="text-align:right;"><?= number_format($data['NJOP_BNG_SPPT']) ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align:right;"><?= number_format($data['NJOP_SPPT']) ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align:right;"><?= number_format($data['NJOPTKP_SPPT']) ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align:right;"><?= number_format($njkp) ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><?= $tarif ?> % x</td>
                <td><?= number_format($njkp) ?></td>
                <td style="text-align:right;"><?= number_format($data['PBB_TERHUTANG_SPPT']) ?></td>
            </tr>
            <tr>
                <td><br></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4">
                    <i><?= terbilang($data['PBB_YG_HARUS_DIBAYAR_SPPT']) ?> Rupiah</i>
                </td>
                <td style="text-align:right;"><b><?= number_format($data['PBB_YG_HARUS_DIBAYAR_SPPT']) ?></b></td>
            </tr>
        </table>
        <br><br>
        <table width="100%">
            <tr>
                <td width="50%" style="text-align:center;"><?= tanggal_indo($_GET['tanggal_terbit']) ?></td>
                <td width="50%" style="text-align:center;">Salak, <?= tanggal_indo($_GET['tanggal_cetak']) ?></td>
            </tr>
            <tr>
                <td style="vertical-align:top;">
                <br>
                    <?= $data['NM_TP'] ?>
                </td>
                <td style="text-align:center;">
                    <br><br><br><br><br>
                    <u><b>BENAR BAIK SEMBIRING, SE, M.Si</b></u><br>
                    <b>NIP. 19790111 200604 1 003</b>
                </td>
            </tr>
        </table>
        <br><br>
        <div id="detail-wp" style="margin-left:150px">
            <div id="nm-wp"><?= $data['NM_WP_SPPT'] ?></div>
            <div id="nm-wp" style="margin-left:100px;"><?= $data['NM_KECAMATAN'] ?></div>
            <div id="nm-wp" style="margin-left:100px;"><?= $data['NM_KELURAHAN'] ?></div>
            <div id="nm-wp"><?= $data['NOPQ'] ?></div>
            <div id="nm-wp"><?= $data['THN_PAJAK_SPPT'] ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; / &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= number_format($data['PBB_YG_HARUS_DIBAYAR_SPPT']) ?></div>
        </div>
    </div>
    <?php endforeach ?>
</body>
</html>