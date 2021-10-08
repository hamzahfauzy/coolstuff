<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-4xl">Edit <?=ucwords($_data)?></h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <form id="login-form" action="" method="post" enctype="multipart/form-data">
            <?php 
            foreach($fields as $name => $field): 
                $label = str_replace("_"," ",$name);
            ?>
            <div class="form-group mb-2">
                <label><?=ucwords($label)?></label>
                <?php if($field['type'] == 'file'): ?>
                <a href="<?= get_file_storage("installation/".$field['value']) ?>" class="text-blue-700" target="_blank">Lihat File</a>
                <?php endif ?>
                <?= Form::input($field['type'], $name, ['class'=>"p-2 w-full border rounded","placeholder"=>$name,"value"=>$field['value']]) ?>
            </div>
            <?php endforeach ?>

            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" id="btn-login">Update</button>
            </div>
        </form>
    </div>
</div>
<?php load('builder/partials/bottom') ?>
