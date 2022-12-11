<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-4xl">Add Objek Pajak</h2>
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
            <div class="form-group mb-2 hidden" id="blok"></div>
            <div class="form-group mb-2 hidden" id="znt"></div>
            <?php 
            foreach($fields as $key => $val): 
                $label = str_replace("_"," ",$val['column_name']);
                $label = str_replace("KD","KODE",$label);
                $label = str_replace("NM","NAMA",$label);
                $label = str_replace("JNS","JENIS",$label);
            ?>
            <div class="form-group mb-2">
                <label><?=ucwords($label)?></label>
                <?= Form::input($val['data_type'], $val['column_name'], ['class'=>"p-2 w-full border rounded","placeholder"=>$label,'maxlength'=>$val['character_maximum_length'] ]) ?>
            </div>
            <?php endforeach ?>

            <div class="form-group mb-2">
                <label>Subjek Pajak</label>
                <select name="SUBJEK_PAJAK_ID" class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih Subjek Pajak -</option>
                    <?php foreach($sps as $sp):?>
                        <option value="<?=$sp['SUBJEK_PAJAK_ID']?>"><?=$sp['SUBJEK_PAJAK_ID']?> - <?=$sp['NM_WP']?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" id="btn-login">Insert</button>
                <a href="index.php?page=builder/objek-pajak-bumi/index" class="w-full p-2 bg-yellow-500 text-white rounded block text-center mt-2">Kembali</a>
            </div>
        </form>
    </div>
</div>

<script>

    function kecamatanChange(el){
        fetch("index.php?page=builder/objek-pajak-bumi/index&filter-kecamatan="+el.value).then(response => response.json()).then(data => {

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

        fetch("index.php?page=builder/objek-pajak-bumi/index&filter-kelurahan="+el.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

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

        fetch("index.php?page=builder/objek-pajak-bumi/index&filter-blok="+el.value+"&filter-kelurahan="+kelurahan.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

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
