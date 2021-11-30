<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak SSPD Masal</title>
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
        width:40%;
    }
    .mb-10 {
        margin-bottom:5px;
    }
    .ml-50 {
        margin-left:60px;
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
        $tarif = 0.02*$data['PBB_YG_HARUS_DIBAYAR_SPPT'];
        ?>
        <div id="top-align" style="width:200px;margin:auto;">
            <div id="tp" class="mb-10">
            <?= $data['NM_TP'] ?>
            </div>
            <div id="kd_map" class="mb-10" style="width:100%;text-align:center;">
                <span>
                    <?= $data['THN_PAJAK_SPPT'] ?>
                </span>
                <span style="float:right;margin-right:9px;">
                    <?= $data['KD_MAP'] ?>
                </span>
            </div>
    
            <div id="nm_wp" class="mb-10">
            <?= $data['NM_WP_SPPT'] ?>
            </div>

            <div id="kecamatan" class="mb-10 ml-50">
            <?= $data['NM_KECAMATAN'] ?>
            </div>

            <div id="kelurahan" class="mb-10 ml-50">
            <?= $data['NM_KELURAHAN'] ?>
            </div>

            <div id="nop" class="mb-10">
            <?= $data['NOPQ'] ?>
            </div>
            <div id="total" class="mb-10">
            <?= number_format($data['PBB_YG_HARUS_DIBAYAR_SPPT']) ?>
            </div>

            <br><br>
            <div id="tgl_jatuh_tempo">
            <b><?= tanggal_indo($data['TGL_JATUH_TEMPO_SPPT']->format('Y-m-d')) ?></b>
            </div>
        </div>
        <br><br>
        
        <table width="85%">
            <tr>
                <td width="50%" style="vertical-align:top;">
                    <?php 
                    $_t = $data['PBB_YG_HARUS_DIBAYAR_SPPT'];
                    for($i=1;$i<=12;$i++):
                        $_t = $_t+$tarif;
                    ?>
                    <b><?= number_format($_t) ?></b><br>
                    <?php endfor ?>
                </td>
                <td width="50%" style="vertical-align:top;text-align:right;">
                    <?php 
                    for($i=1;$i<=12;$i++):
                        $_t = $_t+$tarif;
                    ?>
                    <b><?= number_format($_t) ?></b><br>
                    <?php endfor ?>
                    <span><?=number_format($data['LUAS_BUMI_SPPT'])?></span><br>
                    <span><?=number_format($data['LUAS_BNG_SPPT'])?></span>
                </td>
            </tr>
        </table>
        
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <div id="top-align" style="width:200px;margin:auto;">
            <div id="tp" class="mb-10">
            <?= $data['NM_TP'] ?>
            </div>
            <div id="kd_map" class="mb-10" style="width:100%;text-align:center;">
                <span>
                    <?= $data['THN_PAJAK_SPPT'] ?>
                </span>
                <span style="float:right;margin-right:9px;">
                    <?= $data['KD_MAP'] ?>
                </span>
            </div>
    
            <div id="nm_wp" class="mb-10">
            <?= $data['NM_WP_SPPT'] ?>
            </div>

            <div id="kecamatan" class="mb-10 ml-50">
            <?= $data['NM_KECAMATAN'] ?>
            </div>

            <div id="kelurahan" class="mb-10 ml-50">
            <?= $data['NM_KELURAHAN'] ?>
            </div>

            <div id="nop" class="mb-10">
            <?= $data['NOPQ'] ?>
            </div>
            <div id="total" class="mb-10">
            <?= number_format($data['PBB_YG_HARUS_DIBAYAR_SPPT']) ?>
            </div>
        </div>

        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <div id="top-align" style="width:200px;margin:auto;">
            <div id="tp" class="mb-10">
            <?= $data['NM_TP'] ?>
            </div>
            <div id="kd_map" class="mb-10" style="width:100%;text-align:center;">
                <span>
                    <?= $data['THN_PAJAK_SPPT'] ?>
                </span>
                <span style="float:right;margin-right:9px;">
                    <?= $data['KD_MAP'] ?>
                </span>
            </div>
    
            <div id="nm_wp" class="mb-10">
            <?= $data['NM_WP_SPPT'] ?>
            </div>

            <div id="kecamatan" class="mb-10 ml-50">
            <?= $data['NM_KECAMATAN'] ?>
            </div>

            <div id="kelurahan" class="mb-10 ml-50">
            <?= $data['NM_KELURAHAN'] ?>
            </div>

            <div id="nop" class="mb-10">
            <?= $data['NOPQ'] ?>
            </div>
            <div id="total" class="mb-10">
            <?= number_format($data['PBB_YG_HARUS_DIBAYAR_SPPT']) ?>
            </div>
        </div>
    </div>
    <?php endforeach ?>
</body>
</html>