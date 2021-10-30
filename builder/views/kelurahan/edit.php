<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-4xl">Edit Kelurahan : <?=$data['NM_KELURAHAN']?></h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <form id="login-form" action="index.php?page=<?=$_GET['page']?>&kecamatan=<?=$_GET['kecamatan']?>&kelurahan=<?=$_GET['kelurahan']?>" method="post" enctype="multipart/form-data">
            <div class="form-group mb-2">
                <label>Kecamatan</label>
                <select name="KD_KECAMATAN" class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih Kecamatan -</option>
                    <?php foreach($kecamatans as $kecamatan):?>
                        <option <?= $data['KD_KECAMATAN'] == $kecamatan['KD_KECAMATAN'] ? 'selected' : ''?> value="<?=$kecamatan['KD_KECAMATAN']?>"><?=$kecamatan['KD_KECAMATAN']." - ".$kecamatan['NM_KECAMATAN']?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2">
                <label>Sektor</label>
                <select name="KD_SEKTOR" class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih Sektor -</option>
                    <?php foreach($sektors as $sektor):?>
                        <option <?=$data['KD_SEKTOR'] == $sektor['KD_SEKTOR'] ? 'selected' : ''?> value="<?=$sektor['KD_SEKTOR']?>"><?=$sektor['KD_SEKTOR']." - ".$sektor['NM_SEKTOR']?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <?php 
            foreach($fields as $key => $val): 
                $label = str_replace("_"," ",$key);
                $label = str_replace("KD","KODE",$label);
                $label = str_replace("NM","NAMA",$label);
            ?>
            <div class="form-group mb-2">
                <label><?=ucwords($label)?></label>
                <?= Form::input($val['type'], $key, ['class'=>"p-2 w-full border rounded","value"=>$val['value'],"placeholder"=>$label,'maxlength'=>$val['character_maximum_length'] ]) ?>
            </div>
            <?php endforeach ?>

            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" id="btn-login">Update</button>
            </div>
        </form>
    </div>
</div>
<?php load('builder/partials/bottom') ?>
