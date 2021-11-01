<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-4xl">Add Subjek Pajak</h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <form id="login-form" action="index.php?page=<?=$_GET['page']?>" method="post" enctype="multipart/form-data">
            <div class="form-group mb-2" id="kelurahan">
                <label>Kelurahan</label>
                <select name="KELURAHAN_WP" class="p-2 w-full border rounded" onchange="kelurahanChange(this)">
                    <option value="" selected readonly>- Pilih Kelurahan -</option>
                    <?php foreach($kelurahans as $kelurahan):?>
                        <option value="<?=$kelurahan['KD_KELURAHAN']." - ".$kelurahan['NM_KELURAHAN']?>"><?=$kelurahan['KD_KELURAHAN']." - ".$kelurahan['NM_KELURAHAN']?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2 hidden" id="blok"></div>
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
