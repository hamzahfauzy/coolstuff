<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-4xl"><?=$jpb['KD_JPB']?> - <?=$jpb['NM_JPB']?> : <?=$tahun?></h2>
    <form id="login-form" action="index.php?page=<?=$_GET['page']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="tahun" value="<?=$tahun?>">
        <input type="hidden" name="jpb" value="<?=$jpb['KD_JPB']?>">
        <div class="bg-white shadow-md rounded my-6 p-8">
            
            <?php foreach($fields['columns'] as $key => $title): ?>
            <div class="form-group mb-2">
                <label><?=$title == 'Nilai Lama' ? 'Nilai' : $title?></label>
                <input name="fields[<?=$key?>]" type="text" class="p-2 w-full border rounded" placeholder="<?=$title == 'Nilai Lama' ? 'Nilai' : $title?>">
            </div>
            <?php endforeach ?>

            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" id="btn-login">Insert</button>
                <a href="index.php?page=builder/dbkb-non-standar/index&tahun=<?=$tahun?>&jpb=<?=$jpb['KD_JPB']?>&tampilkan=" class="w-full p-2 bg-yellow-500 text-white rounded block text-center mt-2">Kembali</a>
            </div>
        </div>
    </form>
</div>

<?php load('builder/partials/bottom') ?>
