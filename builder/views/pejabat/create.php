<?php load('builder/partials/top'); ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-4xl">Add Pejabat</h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <form id="login-form" action="index.php?page=<?=$_GET['page']?>" method="post" enctype="multipart/form-data">
            <?php 
            foreach($fields as $key => $val): 
                $label = str_replace("_"," ",$val['column_name']);
                $label = str_replace("KD","KODE",$label);
                $label = str_replace("NM","NAMA",$label);
            ?>

            <div class="form-group mb-2">
                <label><?=ucwords($label)?></label>
                <?= Form::input($val['data_type'], $val['column_name'], ['class'=>"p-2 w-full border rounded","placeholder"=>$label,'maxlength'=>$val['character_maximum_length'] ]) ?>
            </div>
            <?php endforeach ?>

            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" id="btn-login">Insert</button>
            </div>
        </form>
    </div>
</div>
<?php load('builder/partials/bottom') ?>
