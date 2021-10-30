<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-4xl">Edit Users : <?=$data['USERNAME']?></h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <form id="login-form" action="index.php?page=<?=$_GET['page']?>&users=<?=$_GET['users']?>" method="post" enctype="multipart/form-data">
            <?php 
            foreach($fields as $key => $val): 
                $label = str_replace("_"," ",$key);
                $label = str_replace("KD","KODE",$label);
                $label = str_replace("NM","NAMA",$label);
            ?>
            <div class="form-group mb-2">
                <label><?=ucwords($label)?></label>
                <?= Form::input($val['type'], $key, ['class'=>"p-2 w-full border rounded","placeholder"=>$label,'value'=>$val['value'],'maxlength'=>$val['character_maximum_length'] ]) ?>
            </div>
            <?php endforeach ?>

            <div class="form-group mb-2">
                <label>Role</label>
                <select name="WEWENANG" class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih Role -</option>
                    <?php foreach($roles as $role): ?>
                        <option <?=$data['WEWENANG'] == $role['KD_WEWENANG'] ? 'selected' : ''?> value="<?=$role['KD_WEWENANG']?>"><?=$role['NM_WEWENANG']?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" id="btn-login">Update</button>
            </div>
        </form>
    </div>
</div>
<?php load('builder/partials/bottom') ?>
