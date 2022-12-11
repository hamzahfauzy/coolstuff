<?php load('partials/landing-top') ?>

        <main style="padding-bottom:100px;">
            <h2 align="center">Cari Riwayat Tagihan Anda</h2>
            <form action="">
                <input type="hidden" name="page" value="cari">
                <div class="hero-form field field-grouped" style="margin-left:auto;margin-right:auto;">
                    <div class="control control-expanded">
                        <select name="type" id="tipe" class="input" onchange="init(this.value)">
                            <option>Subjek Pajak</option>
                            <option>NOP</option>
                        </select>
                    </div>
                    <div class="control control-expanded">
                        <input class="input" type="text" name="subjek_pajak_id" placeholder="NIK / Subjek Pajak ID / NOP" value="<?=@$_GET['subjek_pajak_id']?>">
                    </div>
                    <div class="control">
                        <button class="button button-primary button-block" href="#">Cari</button>
                    </div>
                </div>
            </form>

            <?php 
            if($cari):
                if(empty($datas)):
                    echo "<h3 align='center'>Data tidak ditemukan</h3>";
                else: ?>
                    <section class="hero">
                        <div class="container"> 
                            <?php foreach($datas as $data): ?>
                            <div class="objek-pajak">
                                <div class="side">
                                    <div class="group">
                                        <label for="">NOP :</label>
                                        <p><b><?= $data['NOPQ'] ?></b></p>
                                    </div>
                                    <div class="group">
                                        <label for="">Nama Wajib Pajak :</label>
                                        <p><b><?= $data['NM_WP'] ?></b></p>
                                    </div>
                                    <div class="group">
                                        <label for="">Alamat :</label>
                                        <p><?= $data['JALAN_WP']. ', ' .$data['KELURAHAN_WP']. ', ' .$data['KOTA_WP'] ?></p>
                                    </div>
                                    <div class="group">
                                        <label for="">Riwayat Pembayaran :</label>
                                        <p>
                                            <ul>
                                                <?php foreach($data['riwayat'] as $riwayat): ?>
                                                <li><?=$riwayat['THN_PAJAK_SPPT'].' - '.number_format($riwayat['JML_SPPT_YG_DIBAYAR'],0,',','.') ?></li>
                                                <?php endforeach ?>
                                            </ul>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>
                    </section>
                <?php endif; 
            endif; 
            ?>
        </main>
        <script src="https://code.jquery.com/jquery-3.6.1.slim.min.js" integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>
        <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
        <script>
            function init(val)
            {
                if(val == 'NOP')
                {
                    var nop = $("input[name='subjek_pajak_id']");
                    nop.inputmask({mask:"12.12.999.999.999-9{1,4}.9"})
                }
                else
                {
                    $("input[name='subjek_pajak_id']").inputmask('remove');
                }
            }
        </script>

<?php load('partials/landing-bottom') ?>