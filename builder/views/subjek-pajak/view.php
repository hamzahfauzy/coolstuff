<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">

    <a href="index.php?page=builder/subjek-pajak/index" class="p-2 bg-green-500 text-white rounded">Kembali</a>

    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white shadow-md rounded my-6 p-8">
            <div class="flex justify-between">
                <p>Subjek Pajak ID</p>
                
                <b><?=$data['SUBJEK_PAJAK_ID']?></b>
            </div>

            <div class="flex justify-between">
                <p>Kelurahan</p>
                
                <b><?=$data['KELURAHAN_WP']?></b>
            </div>
            
            <div class="flex justify-between">
                <p>Blok</p>
                
                <b><?=$data['BLOK_KAV_NO_WP']?></b>
            </div>

            <div class="flex justify-between">
                <p>Nama</p>
                
                <b><?=$data['NM_WP']?></b>
            </div>

            <div class="flex justify-between">
                <p>Jalan</p>
                
                <b><?=$data['JALAN_WP']?></b>
            </div>

            <div class="flex justify-between">
                <p>RW</p>
                
                <b><?=$data['RW_WP']?></b>
            </div>
        </div>

        <div class="bg-white shadow-md rounded my-6 p-8">
            <div class="flex justify-between">
                <p>RT</p>
                
                <b><?=$data['RW_WP']?></b>
            </div>

            <div class="flex justify-between">
                <p>Kota</p>
                
                <b><?=$data['KOTA_WP']?></b>
            </div>
            
            <div class="flex justify-between">
                <p>Kode Pos</p>
                
                <b><?=$data['KD_POS_WP']?></b>
            </div>

            <div class="flex justify-between">
                <p>Telepon</p>
                
                <b><?=$data['TELP_WP']?></b>
            </div>

            <div class="flex justify-between">
                <p>NPWP</p>
                
                <b><?=$data['NPWP']?></b>
            </div>

            <div class="flex justify-between">
                <p>Status Pekerjaan</p>
                
                <b><?=$data['STATUS_PEKERJAAN_WP']?></b>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded p-8 <?= $opBumi ? '' : 'hidden' ?>">

        <h2 class="text-lg mb-5">Objek Pajak Bumi</h2>

        <form id="login-form" action="index.php?page=<?=$_GET['page']?>&id=<?=$_GET['id']?>" method="post" enctype="multipart/form-data">
            <div class="form-group mb-2">
                <label>Kecamatan</label>
                <select name="KD_KECAMATAN" class="p-2 w-full border rounded" onchange="kecamatanChange(this)">
                    <option value="" selected readonly>- Pilih Kecamatan -</option>
                    <?php foreach($kecamatans as $kecamatan):?>
                        <option <?= $opBumi['KD_KECAMATAN'] == $kecamatan['KD_KECAMATAN'] ? 'selected' : ''?> value="<?=$kecamatan['KD_KECAMATAN']?>"><?=$kecamatan['KD_KECAMATAN']." - ".$kecamatan['NM_KECAMATAN']?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2 <?= $opBumi['KD_KELURAHAN'] ? '' : 'hidden' ?>" id="kelurahan">
                <label>Kelurahan</label>
                <select name="KD_KELURAHAN" class="p-2 w-full border rounded" onchange="kelurahanChange(this)">
                    <option value="" selected readonly>- Pilih Kelurahan -</option>
                    <?php foreach($kelurahans as $kelurahan):?>
                        <option <?= $opBumi['KD_KELURAHAN'] == $kelurahan['KD_KELURAHAN'] && $opBumi['KD_KECAMATAN'] == $kelurahan['KD_KECAMATAN']  ? 'selected' : ''?> value="<?=$kelurahan['KD_KELURAHAN']?>"><?=$kelurahan['KD_KELURAHAN']." - ".$kelurahan['NM_KELURAHAN']?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2 <?= $opBumi['KD_BLOK'] ? '' : 'hidden' ?>" id="blok">
                <label>Blok</label>
                <select name="KD_BLOK" class="p-2 w-full border rounded" onchange="blokChange(this)">
                    <option value="" selected readonly>- Pilih Blok -</option>
                    <?php foreach($bloks as $blok):?>
                        <option <?= $opBumi['KD_BLOK'] == $blok['KD_BLOK'] && $opBumi['KD_KELURAHAN'] == $blok['KD_KELURAHAN'] && $opBumi['KD_KECAMATAN'] == $blok['KD_KECAMATAN']  ? 'selected' : ''?> value="<?=$blok['KD_BLOK']?>"><?=$blok['KD_BLOK']?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2 <?=$opBumi['KD_ZNT'] ? '' : 'hidden' ?>" id="znt">
                <label>ZNT</label>
                <select name="KD_ZNT" class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih ZNT -</option>
                    <?php foreach($znts as $znt):?>
                        <option <?= $opBumi['KD_ZNT'] == $znt['KD_ZNT'] && $opBumi['KD_BLOK'] == $znt['KD_BLOK'] && $opBumi['KD_KELURAHAN'] == $znt['KD_KELURAHAN'] && $opBumi['KD_KECAMATAN'] == $znt['KD_KECAMATAN']  ? 'selected' : ''?> value="<?=$znt['KD_ZNT']?>"><?=$znt['KD_ZNT']?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <?php 
            foreach($fields as $key => $val): 
                $label = str_replace("_"," ",$val['column_name']);
                $label = str_replace("KD","KODE",$label);
                $label = str_replace("NM","NAMA",$label);
                $label = str_replace("JNS","JENIS",$label);
            ?>
            <div class="form-group mb-2">
                <label><?=ucwords($label)?></label>
                <?= Form::input($val['data_type'], $val['column_name'], ['class'=>"p-2 w-full border rounded","value"=>$opBumi[$val["column_name"]],"placeholder"=>$label,'maxlength'=>$val['character_maximum_length'] ]) ?>
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
        fetch("index.php?page=builder/subjek-pajak/view&filter-kecamatan="+el.value).then(response => response.json()).then(data => {

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

        fetch("index.php?page=builder/subjek-pajak/view&filter-kelurahan="+el.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

                var html = `
                        <label>Blok</label>
                        <select name="KD_BLOK" class="p-2 w-full border rounded" onchange="blokChange(this)">
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

    function blokChange(el){
        var kecamatan = document.querySelector("select[name='KD_KECAMATAN']")
        var kelurahan = document.querySelector("select[name='KD_KELURAHAN']")

        fetch("index.php?page=builder/subjek-pajak/view&filter-blok="+el.value+"&filter-kelurahan="+kelurahan.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

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
