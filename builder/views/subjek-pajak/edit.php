<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-4xl">Edit Subjek Pajak : <?=$data["SUBJEK_PAJAK_ID"]?></h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <form id="login-form" action="index.php?page=<?=$_GET['page']?>&id=<?=$_GET['id']?>" method="post" enctype="multipart/form-data">
            <div class="form-group mb-2" id="kelurahan">
                <label>Kelurahan</label>
                <select name="KELURAHAN_WP" class="p-2 w-full border rounded" onchange="kelurahanChange(this)">
                    <option value="" selected readonly>- Pilih Kelurahan -</option>
                    <?php foreach($kelurahans as $kelurahan):?>
                        <option <?= $data['KELURAHAN_WP'] == $kelurahan['NM_KELURAHAN']  ? 'selected' : ''?> value="<?=$kelurahan['KD_KELURAHAN']." - ".$kelurahan['NM_KELURAHAN']?>"><?=$kelurahan['KD_KELURAHAN']." - ".$kelurahan['NM_KELURAHAN']?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2" id="blok">
                <label>Blok</label>
                <select name="BLOK_KAV_NO_WP" class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih Blok -</option>
                    <?php foreach($bloks as $blok):?>
                        <option <?= $data['BLOK_KAV_NO_WP'] == $blok['KD_BLOK']  ? 'selected' : ''?> value="<?=$blok['KD_BLOK']?>"><?=$blok['KD_BLOK']?></option>
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


<script>

    function kelurahanChange(el){
        fetch("index.php?page=builder/subjek-pajak/index&filter-kelurahan="+el.value).then(response => response.json()).then(data => {

                var html = `
                        <label>Blok</label>
                        <select name="BLOK_KAV_NO_WP" class="p-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Blok -</option>`

                data.map(dt=>{
                    html += `<option value="${dt.KD_BLOK}">${dt.KD_BLOK}</option>`
                })

                html += `</select>`

                var blok = document.querySelector("#blok")

                blok.innerHTML = html

                blok.classList.remove("hidden")

        }); 
    }    
</script>

<?php load('builder/partials/bottom') ?>
