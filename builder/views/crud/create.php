<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-4xl">Add <?=ucwords($_data)?></h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <form id="login-form" action="" method="post" enctype="multipart/form-data">
            <?php 
            foreach($fields as $name => $field): 
                $label = str_replace("_"," ",$name);
            ?>
            <div class="form-group mb-2">
                <label><?=ucwords($label)?></label>
                <?= Form::input($field, $name, ['class'=>"p-2 w-full border rounded","placeholder"=>$name]) ?>
            </div>
            <?php endforeach ?>

            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" id="btn-login">Insert</button>
            </div>
        </form>
    </div>
</div>
<?php load('builder/partials/bottom') ?>
