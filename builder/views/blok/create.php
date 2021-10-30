<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-4xl">Add Blok</h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <form id="login-form" action="index.php?page=<?=$_GET['page']?>" method="post" enctype="multipart/form-data">
            <div class="form-group mb-2">
                <label>Kecamatan</label>
                <select name="KD_KECAMATAN" class="p-2 w-full border rounded" onchange="kecamatanChange(this)">
                    <option value="" selected readonly>- Pilih Kecamatan -</option>
                    <?php foreach($kecamatans as $kecamatan):?>
                        <option value="<?=$kecamatan['KD_KECAMATAN']?>"><?=$kecamatan['KD_KECAMATAN']." - ".$kecamatan['NM_KECAMATAN']?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2 hidden" id="kelurahan"></div>
            <div class="form-group mb-2 hidden">
                <label>Status Peta Blok</label>
                <select name="STATUS_PETA_BLOK" class="p-2 w-full border rounded">
                    <option value=""  readonly>- Pilih Status -</option>
                    <option value="0" selected>0</option>
                    <option value="1">1</option>
                </select>
            </div>
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

    function kecamatanChange(el){
        fetch("index.php?page=builder/blok/index&filter-kecamatan="+el.value).then(response => response.json()).then(data => {

                var html = `
                        <label>Kelurahan</label>
                        <select name="KD_KELURAHAN" class="p-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Kelurahan -</option>`

                data.map(dt=>{
                    html += `<option value="${dt.KD_KELURAHAN}">${dt.KD_KELURAHAN} - ${dt.NM_KELURAHAN}</option>`
                })

                html += `</select>`

                var kelurahan = document.querySelector("#kelurahan")

                kelurahan.innerHTML = html

                kelurahan.classList.remove("hidden")

        }); 
    }    
</script>

<?php load('builder/partials/bottom') ?>
