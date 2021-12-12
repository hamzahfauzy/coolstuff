<?php load('builder/partials/top'); ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">Surat Tagihan</h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <form action="index.php" onsubmit="doSubmit(this); return false;">
            <input type="hidden" name="page" value="builder/penatausahaan/log-objek-baru/results">
            <div class="form-group mb-2">
                <?php 
                $options = [];
                for($i=date('Y');$i>=1900;$i--) $options[] = $i;
                $options = implode("|",$options);
                ?>
                <label>Tahun Pajak</label>
                <?= Form::input('options:'.$options, 'tahun_pajak', ['class'=>"p-2 w-full border rounded"]) ?>
            </div>

            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" name="cetak" value="cetak">Cetak</button>
            </div>
        </form>
    </div>
</div>
<?php load('builder/partials/bottom') ?>
