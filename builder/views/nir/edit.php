<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-4xl">Edit NIR : <?=$data["NO_DOKUMEN"]?> - <?=$data["NIR"]?></h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <form id="login-form" action="index.php?page=<?=$_GET['page']?>&kecamatan=<?=$_GET['kecamatan']?>&kelurahan=<?=$_GET['kelurahan']?>&znt=<?=$_GET['znt']?>&nir=<?=$data['NIR']?>&no_dokumen=<?=$data['NO_DOKUMEN']?>&tahun=<?=$data['THN_NIR_ZNT']?>" method="post" enctype="multipart/form-data">
            
            <div class="form-group">
                <label for="">Tahun</label>
                <select class="p-2 w-full border rounded" name="THN_NIR_ZNT">
                    <option value="" selected readonly>- Pilih Tahun -</option>
                    <?php foreach($years as $Y):?>
                        <option <?= (isset($data) && $data['THN_NIR_ZNT'] == $Y) ? "selected" : ""?> value="<?=$Y?>"><?=$Y?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group mb-2">
                <label>Kecamatan</label>
                <select name="KD_KECAMATAN" class="p-2 w-full border rounded" onchange="kecamatanChange(this)">
                    <option value="" selected readonly>- Pilih Kecamatan -</option>
                    <?php foreach($kecamatans as $kecamatan):?>
                        <option <?= $data['KD_KECAMATAN'] == $kecamatan['KD_KECAMATAN'] ? 'selected' : ''?> value="<?=$kecamatan['KD_KECAMATAN']?>"><?=$kecamatan['KD_KECAMATAN']." - ".$kecamatan['NM_KECAMATAN']?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2 <?=isset($_GET['kelurahan']) && $_GET['kelurahan'] ? '' : 'hidden' ?>" id="kelurahan">
                <label>Kelurahan</label>
                <select name="KD_KELURAHAN" class="p-2 w-full border rounded" onchange="kelurahanChange(this)">
                    <option value="" selected readonly>- Pilih Kelurahan -</option>
                    <?php foreach($kelurahans as $kelurahan):?>
                        <option <?= $_GET['kelurahan'] == $kelurahan['KD_KELURAHAN'] && $_GET['kecamatan'] == $kelurahan['KD_KECAMATAN']  ? 'selected' : ''?> value="<?=$kelurahan['KD_KELURAHAN']?>"><?=$kelurahan['KD_KELURAHAN']." - ".$kelurahan['NM_KELURAHAN']?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2 <?=isset($_GET['znt']) && $_GET['znt'] ? '' : 'hidden' ?>" id="znt">
                <label>ZNT</label>
                <select name="KD_ZNT" class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih ZNT -</option>
                    <?php foreach($znts as $znt):?>
                        <option <?= $_GET['znt'] == $znt['KD_ZNT'] && $_GET['kelurahan'] == $znt['KD_KELURAHAN'] && $_GET['kecamatan'] == $znt['KD_KECAMATAN']  ? 'selected' : ''?> value="<?=$znt['KD_ZNT']?>"><?=$znt['KD_ZNT']?></option>
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

    function kecamatanChange(el){
        fetch("index.php?page=builder/nir/index&filter-kecamatan="+el.value).then(response => response.json()).then(data => {

                var html = `
                        <label>Kelurahan</label>
                        <select name="KD_KELURAHAN" class="p-2 w-full border rounded" onchange="kelurahanChange(this)">
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

    function kelurahanChange(el){
        var kecamatan = document.querySelector("select[name='KD_KECAMATAN']")

        fetch("index.php?page=builder/nir/index&filter-kelurahan="+el.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

                var html = `
                        <label>ZNT</label>
                        <select name="KD_ZNT" class="p-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih ZNT -</option>`

                data.map(dt=>{
                    html += `<option value="${dt.KD_ZNT}">${dt.KD_ZNT}</option>`
                })

                html += `</select>`

                var znt = document.querySelector("#znt")

                znt.innerHTML = html

                znt.classList.remove("hidden")

        }); 
    }    
</script>

<?php load('builder/partials/bottom') ?>
