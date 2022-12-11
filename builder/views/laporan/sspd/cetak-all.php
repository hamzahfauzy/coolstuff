<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak SSPD Masal</title>
    <style>
    body {
        margin:0;
        padding:0;
    }
    .bg {
        height:255mm;
        width:318mm;
        margin:0;
        padding:0;
        font-family:Arial;
        font-size:10px;
        <?php if(isset($_GET['dengan_blangko'])): ?>
        background-image:url(<?=url().'/images/SSPD.jpg'?>);
        <?php endif ?>
        background-repeat:no-repeat;
    }
    .report-page {
        padding-top:65px;
        width:33%;
        float:left;
        box-sizing:border-box;
        padding-left:110px;
    }
    .mb-10 {
        margin-bottom:5px;
    }
    .mb-3 {
        margin-bottom:3px;
    }
    .ml-50 {
        margin-left:60px;
    }
    .ml-10 {
        margin-left:10px;
    }
    .mt-15 {
        margin-top:15px;
    }
    .mt-5 {
        margin-top:5px;
    }
    .mb-5 {
        margin-bottom:10px;
    }
    </style>
</head>
<body onload="window.print()">
    <?php $no=0; foreach($datas as $data): ?>
    <?php if($no%3 == 0): ?>
    <div class="bg">
    <?php endif ?>
    <div class="report-page">
            <?php
            $bumiPerM2 = 0; 
            $bngPerM2 = 0; 
            $njkp = 0;
            $tarif = 0.02*$data['PBB_YG_HARUS_DIBAYAR_SPPT'];
            // if($data['LUAS_BUMI_SPPT'] > 0)
            //     $bumiPerM2 = $data['NJOP_BUMI_SPPT']/$data['LUAS_BUMI_SPPT'];
            // if($data['LUAS_BNG_SPPT'] > 0)
            //     $bngPerM2 = $data['NJOP_BNG_SPPT']/$data['LUAS_BNG_SPPT'];
            // if(($data['NJOP_SPPT']-$data['NJOPTKP_SPPT']) > 0)
            //     $njkp = ($data['NJOP_SPPT']-$data['NJOPTKP_SPPT']);
            // if($njkp > 0)
            //     $tarif = $data['PBB_TERHUTANG_SPPT']/$njkp*100;
        
            ?>
            <div id="top-align" style="width:200px;margin:auto;">
                <div id="tp" class="mb-10">
                <?= $data['NM_TP'] ?>
                </div>
                <div id="kd_map" class="mb-3" style="width:100%;text-align:center;">
                    <span>
                        <?= $data['THN_PAJAK_SPPT'] ?>
                    </span>
                    <span style="float:right;margin-right:9px;">
                        <?= $data['KD_MAP'] ?>
                    </span>
                </div>
        
                <div id="nm_wp">
                <?= $data['NM_WP_SPPT'] ?>
                </div>

                <div id="kecamatan" class="ml-50">
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

                <br>
                <div id="tgl_jatuh_tempo" class="ml-10">
                <b><?= tanggal_indo($data['TGL_JATUH_TEMPO_SPPT']->format('Y-m-d')) ?></b>
                </div>
            </div>
            
            <table width="85%" class="mt-15">
                <tr class="mt-10">
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
                <div id="tp" class="mb-10 mt-5">
                <?= $data['NM_TP'] ?>
                </div>
                <div id="kd_map" class="mb-3" style="width:100%;text-align:center;">
                    <span>
                        <?= $data['THN_PAJAK_SPPT'] ?>
                    </span>
                    <span style="float:right;margin-right:9px;">
                        <?= $data['KD_MAP'] ?>
                    </span>
                </div>
        
                <div id="nm_wp">
                <?= $data['NM_WP_SPPT'] ?>
                </div>

                <div id="kecamatan" class="ml-50">
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
            <br>
            <div id="top-align" style="width:200px;margin:auto;">
                <div id="tp" class="mb-10 mt-5">
                <?= $data['NM_TP'] ?>
                </div>
                <div id="kd_map" class="mb-3" style="width:100%;text-align:center;">
                    <span>
                        <?= $data['THN_PAJAK_SPPT'] ?>
                    </span>
                    <span style="float:right;margin-right:9px;">
                        <?= $data['KD_MAP'] ?>
                    </span>
                </div>
        
                <div id="nm_wp" class="mb-3">
                <?= $data['NM_WP_SPPT'] ?>
                </div>

                <div id="kecamatan" class="ml-50">
                <?= $data['NM_KECAMATAN'] ?>
                </div>

                <div id="kelurahan" class="mb-3 ml-50">
                <?= $data['NM_KELURAHAN'] ?>
                </div>

                <div id="nop" class="mb-3">
                <?= $data['NOPQ'] ?>
                </div>
                <div id="total" class="mb-10">
                <?= number_format($data['PBB_YG_HARUS_DIBAYAR_SPPT']) ?>
                </div>
            </div>
        </div>
    <?php if(($no+1)%3 == 0): ?>
    </div>
    <?php endif ?>
    <?php $no++; endforeach ?>
</body>
</html>