<?php load('partials/landing-top') ?>
<style>
.group {
    margin-bottom:10px;
}
</style>
        <main style="padding-bottom:100px;">
            <h2 align="center">Cek SPPT Anda</h2>
            <form action="" method="post">
                <div class="hero-form field field-grouped" style="margin-left:auto;margin-right:auto;max-width:1000px;">
                    <div class="control control-expanded">
                        <input class="input" type="text" name="NOPQ" placeholder="NOP" value="<?=@$_POST['NOPQ']?>">
                    </div>
                    <div class="control control-expanded">
                        <input class="input" type="text" name="NM_WP" placeholder="Nama Wajib Pajak" value="<?=@$_POST['NM_WP']?>">
                    </div>
                    <div class="control control-expanded">
                        <select name="TAHUN" id="" class="input">
                            <?php for($i=date('Y');$i>=1990;$i--): ?>
                            <option <?=isset($_POST['TAHUN']) && $_POST['TAHUN']==$i?'selected':''?>><?=$i?></option>
                            <?php endfor ?>
                        </select>
                    </div>
                    <div class="control">
                        <button class="button button-primary button-block" name="submit">Submit</button>
                    </div>
                </div>
            </form>

            <?php 
            if(empty($data) && $submit):
                echo "<h3 align='center'>Data tidak ditemukan</h3>";
            endif;
            if($submit && !empty($data)):
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
            <section class="hero" style="padding-top:20px">
                <div class="container"> 
                    <div class="objek-pajak">
                        <div class="side">
                            <div class="group">
                                <label for="">NOP :</label>
                                <p><b><?= $data['NOPQ'] ?></b></p>
                            </div>
                            <div class="group">
                                <label for="">Nama Wajib Pajak :</label>
                                <p><b><?= $data['NM_WP_SPPT'] ?></b></p>
                            </div>
                            <div class="group">
                                <label for="">Alamat :</label>
                                <p><?= $data['JLN_WP_SPPT']. ', ' .$data['KELURAHAN_WP_SPPT']. ', ' .$data['KOTA_WP_SPPT'] ?></p>
                            </div>
                            <div class="group">
                                <label for="">Bumi :</label>
                                <p>
                                    Luas Bumi : <?= $data['LUAS_BUMI_SPPT'] ?><br>
                                    Kelas : <?= $data['KD_KLS_TANAH'] ?><br>
                                    Nilai Bumi / m<sup>2</sup> : <?= $bumiPerM2 ?><br>
                                    NJOP Bumi : <?= number_format($data['NJOP_BUMI_SPPT']) ?>
                                </p>
                            </div>
                            <div class="group">
                                <label for="">Bangunan :</label>
                                <p>
                                    Luas Bangunan : <?= $data['LUAS_BNG_SPPT'] ?><br>
                                    Kelas : <?= $data['KD_KLS_BNG'] ?><br>
                                    Nilai Bangunan / m<sup>2</sup> : <?= $bngPerM2 ?><br>
                                    NJOP Bangunan : <?= number_format($data['NJOP_BNG_SPPT']) ?>
                                </p>
                            </div>
                            <div class="group">
                                <label for="">NJOP SPPT :</label>
                                <p><?= number_format($data['NJOP_SPPT']) ?></p>
                            </div>
                            <div class="group">
                                <label for="">NJOPTKP SPPT :</label>
                                <p><?= number_format($data['NJOPTKP_SPPT']) ?></p>
                            </div>
                            <div class="group">
                                <label for="">NJKP :</label>
                                <p><?= number_format($njkp) ?></p>
                            </div>
                            <div class="group">
                                <label for="">Terhutang :</label>
                                <p><?= $tarif ?> % x <?= number_format($njkp) ?> = <?= number_format($data['PBB_TERHUTANG_SPPT']) ?> (<?= terbilang($data['PBB_YG_HARUS_DIBAYAR_SPPT']) ?> Rupiah)</p>
                            </div>
                            <div class="group">
                                <label for="">Tanggal Terbit :</label>
                                <p><?= tanggal_indo($data['TGL_TERBIT_SPPT']->format('Y-m-d')) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php endif; ?>
        </main>
        <script src="https://code.jquery.com/jquery-3.6.1.slim.min.js" integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
        <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
        <script>
            $(document).ready(e => {
                var nop = $("input[name='NOPQ']");

                nop.inputmask({mask:"12.12.999.999.999-9999.9"})
            })
        </script>

<?php load('partials/landing-bottom') ?>