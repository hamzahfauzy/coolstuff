<?php load('builder/partials/top'); ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">Laporan Realisasi</h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <form method="post" action="index.php?page=builder/penatausahaan/laporan-realisasi/cetak" onsubmit="check(this); return false" target="_blank">
            <div class="form-group mb-2">
                <?php 
                $options = [];
                for($i=date('Y');$i>=1900;$i--) $options[] = $i;
                $options = implode("|",$options);
                ?>
                <label>Tahun Pajak</label>
                <?= Form::input('options:'.$options, 'tahun_pajak', ['class'=>"p-2 w-full border rounded"]) ?>
            </div>

            <div class="form-group mb-2">
                <button class="p-2 bg-indigo-800 text-white rounded" id="btn-login">Cetak</button>
            </div>

        </form>
    </div>
</div>
<?php load('builder/partials/bottom') ?>
