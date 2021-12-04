<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-4xl">Edit Roles : <?=$data['NM_WEWENANG']?></h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <form id="login-form" action="index.php?page=<?=$_GET['page']?>&roles=<?=$_GET['roles']?>" method="post" enctype="multipart/form-data">
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
                <label class="capitalize">Modul</label>
                <?php foreach (getModules() as $key => $value) {
                        
                    echo "<div class='form-group my-2'>";
                    echo "<label class='capitalize font-bold'>$key</label>";
                    echo "<br>";

                    foreach ($value as $key2 => $value2) {
                        if(is_array($value2)){

                            echo "<div class='form-group my-2 ml-2'>";
                            echo "<label class='capitalize font-bold'>$key2</label>";
                            echo "<br>";

                            foreach ($value2 as $key3 => $value3) {
                                $checked = isset($module[$value3]) && $module[$value3] == 1 ? 'checked' : '';
                                echo "<div class='form-group inline-block mr-2'>";
                                echo "<input type='checkbox' class='mr-3' name='$value3' $checked id='$key3-checkbox'>";
                                echo "<label class='capitalize' for='$key3-checkbox'>$key3</label>";
                                echo "</div>";
                            }

                            echo "</div>";

                        }else{

                            $checked = isset($module[$value2]) && $module[$value2] == 1 ? 'checked' : '';

                            echo "<div class='form-group inline-block mr-2'>";
                            echo "<input type='checkbox' class='mr-3' name='$value2' $checked id='$key2-checkbox'>";
                            echo "<label class='capitalize' for='$key2-checkbox'>$key2</label>";
                            echo "</div>";

                        }
                    }

                    echo "</div>";


                }?>
            </div>

            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" id="btn-login">Update</button>
                <a href="index.php?page=builder/roles/index" class="w-full p-2 bg-yellow-500 text-white rounded block text-center mt-2">Kembali</a>
            </div>
        </form>
    </div>
</div>
<?php load('builder/partials/bottom') ?>
