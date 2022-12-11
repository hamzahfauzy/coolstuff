<div class="report-page" style="height:297mm;width:166mm;font-family:Arial;font-size:10px;background-image:url(<?=url().'/images/SPPT-single.jpg'?>);background-repeat:no-repeat;">
    <div class="innerpage" style="padding-left:34px;padding-right:34px;padding-top:50px;">
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
    
        <div id="tahun_pajak" style="margin-top:5px;text-align:right;margin-right:70px;font-weight:bold;">
            <?= $data['THN_PAJAK_SPPT'] ?>
        </div>
    
        <div id="nop" style="margin-left:25px;margin-top:-4px;">
            <?= $data['NOPQ'] ?>
        </div>
    
        <table width="100%" style="margin-top:15px;" cellspacing="0" cellpadding="0">
            <tr>
                <td width="50%"></td>
                <td width="50%">
                    <div style="padding-left:20px">
                        <b><?= $data['NM_WP'] ?></b>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="50%" style="vertical-align:top;">
                    <div style="padding-left:20px">
                        <?= $data['JALAN_OP'] ?><br>
                        <?= $data['NM_KELURAHAN'] ?><br>
                        <?= $data['NM_KECAMATAN'] ?><br>
                    </div>
                </td>
                <td width="50%" style="vertical-align:top;">
                    <div style="padding-left:20px">
                        <?= $data['JALAN_WP'] ?><br>
                        <?= $data['KELURAHAN_WP'] ?><br>
                        <?= $data['KOTA_WP'] ?><br>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <div style="margin-left:30px;">- Kode Pos: -</div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><div style="margin-left:60px;"><?=$data['NPWP']?></div></td>
            </tr>
        </table>
        
        <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:27px">
            <tr>
                <td width="100px">BUMI</td>
                <td width="100px"><?= $data['LUAS_BUMI_SPPT'] ?></td>
                <td width="100px"><?= $data['KD_KLS_TANAH'] ?></td>
                <td width="50px" style="text-align:right;"><?= number_format($bumiPerM2) ?></td>
                <td style="text-align:right;"><?= number_format($data['NJOP_BUMI_SPPT']) ?></td>
            </tr>
            <tr>
                <td>BANGUNAN</td>
                <td><?= $data['LUAS_BNG_SPPT'] ?></td>
                <td><?= $data['KD_KLS_BNG'] ?></td>
                <td style="text-align:right;"><?= number_format($bngPerM2) ?></td>
                <td style="text-align:right;"><?= number_format($data['NJOP_BNG_SPPT']) ?></td>
            </tr>
            <tr>
                <td colspan="5">
                    <div style="height:31px"></div>
                </td>
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
                <td colspan="5">
                    <div style="height:11px"></div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><?= $tarif ?> % x</td>
                <td><?= number_format($njkp) ?></td>
                <td style="text-align:right;"><?= number_format($data['PBB_TERHUTANG_SPPT']) ?></td>
            </tr>
            <tr>
                <td colspan="5">
                    <div style="height:34px"></div>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <i><?= terbilang($data['PBB_YG_HARUS_DIBAYAR_SPPT']) ?> Rupiah</i>
                </td>
                <td style="text-align:right;"><b><?= number_format($data['PBB_YG_HARUS_DIBAYAR_SPPT']) ?></b></td>
            </tr>
        </table>
        
        <div style="height:14px"></div>
        
        <table width="100%">
            <tr>
                <td width="50%" style="text-align:center;">
                    <div style="padding-left:44px;margin-top:-10px;">
                        <?= tanggal_indo($_GET['tanggal_terbit']) ?>
                    </div>
                </td>
                <td width="50%" style="text-align:center;">
                    <div style="padding-left:22px;">
                        Salak, <?= tanggal_indo($_GET['tanggal_cetak']) ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="vertical-align:top;">
                    <br>
                    <?= $data['NM_TP'] ?>
                </td>
                <td style="text-align:center;">
                    <div style="padding-left:22px;">
                    <br><br><br>
                    <u><b><?=$xNama?></b></u><br>
                    <b>NIP. <?=$xNIP?></b>
                    </div>
                </td>
            </tr>
        </table>
        <br><br>
        <div id="detail-wp" style="margin-left:106px;">
            <div id="nm-wp"><?= $data['NM_WP'] ?></div>
            <div id="nm-wp" style="margin-left:58px;"><?= $data['NM_KECAMATAN'] ?></div>
            <div id="nm-wp" style="margin-left:58px;"><?= $data['NM_KELURAHAN'] ?></div>
            <div id="nm-wp" style="margin-top:2px"><?= $data['NOPQ'] ?></div>
            <div id="nm-wp"><?= $data['THN_PAJAK_SPPT'] ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; / &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= number_format($data['PBB_YG_HARUS_DIBAYAR_SPPT']) ?></div>
        </div>
    </div>
</div>