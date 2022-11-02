<?php load('partials/landing-top') ?>
<style>
.group {
    margin-bottom:10px;
}
.control-expanded{
    margin:12px 0;
}
label {
    margin:6px 0;
    display:block;
}
.hidden{
    display:none;
}
.shadow-md{
    box-shadow:none;
}
</style>
<main style="padding-bottom:100px;">
    <h2 align="center">Daftar PBB</h2>
    <?php if($submit && (empty($data) && empty($dt) && $jenis_op != 'bumi')): ?>
        <p class="text-center">Data tidak ditemukan!</p>
    <?php endif ?>
    <?php if(!$submit || (empty($data) && empty($dt) && $jenis_op != 'bumi') && empty($old)): ?>
    <form action="" method="post">
        <div class="hero-form field" style="margin-left:auto;margin-right:auto;max-width:1000px;">
            <?php if($msg): ?>
            <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md my-6" role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                    <div class="flex items-center">
                    <p class="font-bold m-0"><?=$msg?></p>
                    </div>
                </div>
            </div>
            <?php endif ?> 
            <div class="control control-expanded">
                <label for="">Status Wajib Pajak</label>
                <select name="status" class="input">
                    <option value="-" selected readonly>- Pilih Status -</option>
                    <option value="Baru">Baru</option>
                    <option value="Terdaftar">Terdaftar</option>
                </select>
            </div>
            <div class="control control-expanded hidden">
                <label for="">ID Wajib Pajak</label>
                <input class="input" type="text" name="ID" placeholder="ID Wajib Pajak">
            </div>
            <div class="control control-expanded hidden">
                <label for="">Jenis Objek Pajak</label>
                <select name="jenis_op" class="input">
                    <option value="-" selected readonly>- Pilih Jenis -</option>
                    <option value="bangunan">Objek Pajak Bangunan</option>
                    <option value="bumi">Objek Pajak Bumi</option>
                </select>
            </div>
            <div class="control control-expanded hidden">
                <label for="">NOP</label>
                <input class="input" type="text" name="NOPQ" placeholder="NOP">
            </div>
            <div class="control hidden">
                <button class="button button-primary button-block" name="submit">Lanjutkan</button>
            </div>
        </div>
    </form>
    <?php elseif($submit && $jenis_op == 'bumi'): ?>
        <?php if(!empty($data)): ?>
            <form id="login-form" action="" method="post" enctype="multipart/form-data" style="margin-left:auto;margin-right:auto;max-width:1000px;">

                <?php if($failed): ?>
                <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-6" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div class="flex items-center">
                        <p class="font-bold m-0"><?=$failed?></p>
                        </div>
                    </div>
                </div>
                <?php endif ?> 

                <div class="bg-white shadow-md rounded my-6 p-8">

                    <!-- <h2 class="text-lg mb-10 text-center font-bold">Nomor Formulir</h2> -->

                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group mb-2">
                            <label>NO SPOP</label>
                            <input type="text" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NO_SPOP"] ? $old["NO_SPOP"] : $data["NO_FORMULIR"]?>" name="NO_SPOP">
                        </div>

                        <div class="form-group mb-2">
                            <label>Tahun</label>
                            <select name="TAHUN" class="p-2 mt-2 w-full border rounded">
                                <option value="" selected readonly>- Pilih Tahun -</option>
                                <?php foreach($years as $year):?>
                                    <option <?=isset($old) && $old['TAHUN'] && $old['TAHUN'] == $year ? 'selected'  : ''?> value="<?=$year?>"><?=$year?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label>Kecamatan</label>
                        <select name="KD_KECAMATAN" class="p-2 w-full border rounded" onchange="kecamatanChange(this)">
                            <option value="" selected readonly>- Pilih Kecamatan -</option>
                            <?php foreach($kecamatans as $kecamatan):?>
                                <option <?= isset($data) && $data['KD_KECAMATAN'] == $kecamatan['KD_KECAMATAN'] ? 'selected' : ''?> value="<?=$kecamatan['KD_KECAMATAN']?>"><?=$kecamatan['KD_KECAMATAN']." - ".$kecamatan['NM_KECAMATAN']?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-2 <?= $data['KD_KELURAHAN'] ? '' : 'hidden' ?>" id="kelurahan">
                        <label>Kelurahan</label>
                        <select name="KD_KELURAHAN" class="p-2 w-full border rounded" onchange="kelurahanChange(this)">
                            <option value="" selected readonly>- Pilih Kelurahan -</option>
                            <?php foreach($kelurahans as $kelurahan):?>
                                <option <?= $data['KD_KELURAHAN'] == $kelurahan['KD_KELURAHAN'] && $data['KD_KECAMATAN'] == $kelurahan['KD_KECAMATAN']  ? 'selected' : ''?> value="<?=$kelurahan['KD_KELURAHAN']?>"><?=$kelurahan['KD_KELURAHAN']." - ".$kelurahan['NM_KELURAHAN']?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-2 <?= $data['KD_BLOK'] ? '' : 'hidden' ?>" id="blok">
                        <label>Blok</label>
                        <select name="KD_BLOK" class="p-2 w-full border rounded" onchange="blokChange(this)">
                            <option value="" selected readonly>- Pilih Blok -</option>
                            <?php foreach($bloks as $blok):?>
                                <option <?= $data['KD_BLOK'] == $blok['KD_BLOK'] && $data['KD_KELURAHAN'] == $blok['KD_KELURAHAN'] && $data['KD_KECAMATAN'] == $blok['KD_KECAMATAN']  ? 'selected' : ''?> value="<?=$blok['KD_BLOK']?>"><?=$blok['KD_BLOK']?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-2 <?=$data['KD_ZNT'] ? '' : 'hidden' ?>" id="znt">
                        <label>ZNT</label>
                        <select name="KD_ZNT" class="p-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih ZNT -</option>
                            <?php foreach($znts as $znt):?>
                                <option <?= $data['KD_ZNT'] == $znt['KD_ZNT'] && $data['KD_BLOK'] == $znt['KD_BLOK'] && $data['KD_KELURAHAN'] == $znt['KD_KELURAHAN'] && $data['KD_KECAMATAN'] == $znt['KD_KECAMATAN']  ? 'selected' : ''?> value="<?=$znt['KD_ZNT']?>"><?=$znt['KD_ZNT']?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="form-group mb-2">
                            <label>No Urut</label>
                            <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NO_URUT"] ? $old["NO_URUT"] : $data["NO_URUT"]?>" name="NO_URUT">
                        </div>
                        <div class="form-group mb-2">
                            <label>Kode</label>
                            <select name="KODE" class="p-2 mt-2 w-full border rounded">
                                <option value="" selected readonly>- Pilih Kode -</option>
                                <option <?= isset($old) && $old['KODE'] == '0' || $data['KD_JNS_OP'] == '0' ? 'selected' : ''?>  value="0">0</option>
                                <option <?= isset($old) && $old['KODE'] == '7' || $data['KD_JNS_OP'] == "7" ? 'selected' : ''?> value="7">7</option>
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label>Status WP</label>
                            <select name="STATUS_WP" class="p-2 mt-2 w-full border rounded">
                                <option value="" selected readonly>- Pilih Kode -</option>
                                <option <?= isset($old) && $old['STATUS_WP'] == '1' ? 'selected' : ''?> value="1">1 Pemilik</option>
                                <option <?= isset($old) && $old['STATUS_WP'] == '2' ? 'selected' : ''?> value="2">2 Penyewa</option>
                                <option <?= isset($old) && $old['STATUS_WP'] == '3' ? 'selected' : ''?> value="3">3 Pemakai</option>
                                <option <?= isset($old) && $old['STATUS_WP'] == '4' ? 'selected' : ''?> value="4">4 Pengelola</option>
                                <option <?= isset($old) && $old['STATUS_WP'] == '5' ? 'selected' : ''?> value="5">5 Sengketa</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- <div class="form-group mb-2">
                            <label>No KTP/ID</label>
                            <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NO_KTP"] ? $old["NO_KTP"] : ''?>" name="NO_KTP">
                        </div> -->

                    </div>

                </div>

                <div class="bg-white shadow-md rounded my-6 p-8">

                    <h2 class="text-lg mb-10 text-center font-bold">Lokasi</h2>

                    <div class="form-group mb-2">
                        <label>Jalan</label>
                        <select name="JALAN" class="p-2 w-full border rounded" id="jalan">
                            <?php foreach($jalans as $jalan): ?>
                            <option value="<?=$jalan['NM_JLN']?>" <?=$jalan['NM_JLN']==$datOP['JALAN_OP']?'selected=""':''?> ><?=$jalan['KD_ZNT'].' - '.$jalan['NM_JLN']?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="form-group mb-2">
                            <label>RW</label>
                            <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["RW"] ? $old["RW"] : $datOP["RW_OP"]?>" name="RW">
                        </div>
                        <div class="form-group mb-2">
                            <label>RT</label>
                            <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["RT"] ? $old["RT"] : $datOP["RT_OP"]?>" name="RT">
                        </div>
                        <div class="form-group mb-2">
                            <label>No Persil</label>
                            <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NO_PERSIL"] ? $old["NO_PERSIL"] : $datOP["NO_PERSIL"]?>" name="NO_PERSIL">
                        </div>
                    </div>
                    
                    <div class="form-group mb-2">
                        <label>Jenis Objek</label>
                        <select name="JNS_BUMI" class="p-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Jenis Bumi -</option>
                            <?php foreach($jenisBumis as $jenisBumi):?>
                                <option <?= (isset($old) && $old['JNS_BUMI'] == substr($jenisBumi,1,1)) || $data['JNS_BUMI'] == substr($jenisBumi,1,1) ? 'selected' : ''?> value="<?=substr($jenisBumi,1,1)?>"><?=$jenisBumi?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group mb-2">
                            <label>Jumlah Bangunan</label>
                            <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["JLH_BNG"] ? $old["JLH_BNG"] : ($data["JLH_BNG"]??0)?>" name="JLH_BNG">
                        </div>
                        <div class="form-group mb-2">
                            <label>Luas Tanah</label>
                            <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["LUAS_TANAH"] ? $old["LUAS_TANAH"] : $data['LUAS_BUMI']?>" name="LUAS_TANAH">
                        </div>
                    </div>

                </div>
                
                <div class="bg-white shadow-md rounded my-6 p-8">

                    <div class="form-group mb-2">
                        <label>Keterangan</label>
                        <input type="text" value="<?=isset($old) && $old["KETERANGAN"] ? $old["KETERANGAN"] : ''?>" class="p-2 mt-2 w-full border rounded" name="KETERANGAN">
                    </div>

                    <div class="form-group">
                        <button class="w-full p-2 bg-indigo-800 text-white rounded" name="proses_bumi">Update</button>
                    </div>

                </div>

            </form>
            
            <script>

                function kecamatanChange(el){
                    fetch("index.php?page=builder/subjek-pajak/objek-pajak-bumi/index&filter-kecamatan="+el.value).then(response => response.json()).then(data => {

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

                    fetch("index.php?page=builder/subjek-pajak/objek-pajak-bumi/index&filter-kelurahan="+el.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

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

                    fetch("index.php?page=builder/subjek-pajak/objek-pajak-bumi/index&get-jalan=true&filter-kelurahan="+el.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

                    var html = ``

                    data.map(dt=>{
                        html += `<option value="${dt.NM_JLN}">${dt.KD_ZNT} - ${dt.NM_JLN}</option>`
                    })

                    var blok = document.querySelector("#jalan")

                    blok.innerHTML = html

                    blok.classList.remove("hidden")

                    }); 
                }    

                function blokChange(el){
                    var kecamatan = document.querySelector("select[name='KD_KECAMATAN']")
                    var kelurahan = document.querySelector("select[name='KD_KELURAHAN']")

                    fetch("index.php?page=builder/subjek-pajak/objek-pajak-bumi/index&filter-blok="+el.value+"&filter-kelurahan="+kelurahan.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

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
        <?php else: ?>
            <form id="login-form" action="" method="post" enctype="multipart/form-data" style="margin-left:auto;margin-right:auto;max-width:1000px;">

                <?php if($failed): ?>
                <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-6" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div class="flex items-center">
                        <p class="font-bold m-0"><?=$failed?></p>
                        </div>
                    </div>
                </div>
                <?php endif ?> 

                <div class="bg-white shadow-md rounded my-6 p-8">

                    <!-- <h2 class="text-lg mb-10 text-center font-bold">Nomor Formulir</h2> -->

                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group mb-2">
                            <label>NO SPOP</label>
                            <input type="text" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NO_SPOP"] ? $old["NO_SPOP"] : ''?>" name="NO_SPOP">
                        </div>

                        <div class="form-group mb-2">
                            <label>Tahun</label>
                            <select name="TAHUN" class="p-2 mt-2 w-full border rounded">
                                <option value="" selected readonly>- Pilih Tahun -</option>
                                <?php foreach($years as $year):?>
                                    <option <?=isset($old) && $old['TAHUN'] && $old['TAHUN'] == $year ? 'selected'  : ''?> value="<?=$year?>"><?=$year?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label>Kecamatan</label>
                        <select name="KD_KECAMATAN" class="p-2 w-full border rounded" onchange="kecamatanChange(this)">
                            <option value="" selected readonly>- Pilih Kecamatan -</option>
                            <?php foreach($kecamatans as $kecamatan):?>
                                <option <?= isset($opBumi) && $opBumi['KD_KECAMATAN'] == $kecamatan['KD_KECAMATAN'] ? 'selected' : ''?> value="<?=$kecamatan['KD_KECAMATAN']?>"><?=$kecamatan['KD_KECAMATAN']." - ".$kecamatan['NM_KECAMATAN']?></option>
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

                    <div class="grid grid-cols-3 gap-4">
                        <div class="form-group mb-2">
                            <label>No Urut</label>
                            <input type="text" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NO_URUT"] ? $old["NO_URUT"] : '001'?>" name="NO_URUT">
                        </div>
                        <div class="form-group mb-2">
                            <label>Kode</label>
                            <select name="KODE" class="p-2 mt-2 w-full border rounded">
                                <option value="" selected readonly>- Pilih Kode -</option>
                                <option <?= isset($old) && $old['KODE'] == '0' ? 'selected' : 'selected'?>  value="0">0</option>
                                <option <?= isset($old) && $old['KODE'] == '7' ? 'selected' : ''?> value="7">7</option>
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label>Status WP</label>
                            <select name="STATUS_WP" class="p-2 mt-2 w-full border rounded">
                                <option value="" selected readonly>- Pilih Kode -</option>
                                <option <?= isset($old) && $old['STATUS_WP'] == '1' ? 'selected' : ''?> value="1">1 Pemilik</option>
                                <option <?= isset($old) && $old['STATUS_WP'] == '2' ? 'selected' : ''?> value="2">2 Penyewa</option>
                                <option <?= isset($old) && $old['STATUS_WP'] == '3' ? 'selected' : ''?> value="3">3 Pemakai</option>
                                <option <?= isset($old) && $old['STATUS_WP'] == '4' ? 'selected' : ''?> value="4">4 Pengelola</option>
                                <option <?= isset($old) && $old['STATUS_WP'] == '5' ? 'selected' : ''?> value="5">5 Sengketa</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- <div class="form-group mb-2">
                            <label>No KTP/ID</label>
                            <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NO_KTP"] ? $old["NO_KTP"] : ''?>" name="NO_KTP">
                        </div> -->

                    </div>

                </div>

                <div class="bg-white shadow-md rounded my-6 p-8">

                    <h2 class="text-lg mb-10 text-center font-bold">Lokasi</h2>

                    <div class="form-group mb-2">
                        <label>Jalan</label>
                        <select name="JALAN" class="p-2 w-full border rounded" id="jalan">
                            <option value="" selected readonly>- Pilih Jalan -</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="form-group mb-2">
                            <label>RW</label>
                            <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["RW"] ? $old["RW"] : ''?>" name="RW">
                        </div>
                        <div class="form-group mb-2">
                            <label>RT</label>
                            <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["RT"] ? $old["RT"] : ''?>" name="RT">
                        </div>
                        <div class="form-group mb-2">
                            <label>No Persil</label>
                            <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NO_PERSIL"] ? $old["NO_PERSIL"] : ''?>" name="NO_PERSIL">
                        </div>
                    </div>
                    
                    <div class="form-group mb-2">
                        <label>Jenis Objek</label>
                        <select name="JNS_BUMI" class="p-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Jenis Bumi -</option>
                            <?php foreach($jenisBumis as $jenisBumi):?>
                                <option <?= isset($old) && $old['JNS_BUMI'] == substr($jenisBumi,1,1) ? 'selected' : ''?> value="<?=substr($jenisBumi,1,1)?>"><?=$jenisBumi?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group mb-2">
                            <label>Jumlah Bangunan</label>
                            <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["JLH_BNG"] ? $old["JLH_BNG"] : ''?>" name="JLH_BNG">
                        </div>
                        <div class="form-group mb-2">
                            <label>Luas Tanah</label>
                            <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["LUAS_TANAH"] ? $old["LUAS_TANAH"] : ''?>" name="LUAS_TANAH">
                        </div>
                    </div>

                </div>
                
                <div class="bg-white shadow-md rounded my-6 p-8">

                    <div class="form-group mb-2">
                        <label>Keterangan</label>
                        <input type="text" value="<?=isset($old) && $old["KETERANGAN"] ? $old["KETERANGAN"] : ''?>" class="p-2 mt-2 w-full border rounded" name="KETERANGAN">
                    </div>

                    <div class="form-group">
                        <button class="w-full p-2 bg-indigo-800 text-white rounded" name="proses_bumi">Create</button>
                    </div>

                </div>

            </form>
            
            <script>

                function kecamatanChange(el){
                    fetch("index.php?page=builder/subjek-pajak/objek-pajak-bumi/index&filter-kecamatan="+el.value).then(response => response.json()).then(data => {

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

                    fetch("index.php?page=builder/subjek-pajak/objek-pajak-bumi/index&filter-kelurahan="+el.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

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

                    fetch("index.php?page=builder/subjek-pajak/objek-pajak-bumi/index&get-jalan=true&filter-kelurahan="+el.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

                        var html = ``

                        data.map(dt=>{
                            html += `<option value="${dt.NM_JLN}">${dt.KD_ZNT} - ${dt.NM_JLN}</option>`
                        })

                        var blok = document.querySelector("#jalan")

                        blok.innerHTML = html

                        blok.classList.remove("hidden")

                    }); 
                }    

                function blokChange(el){
                    var kecamatan = document.querySelector("select[name='KD_KECAMATAN']")
                    var kelurahan = document.querySelector("select[name='KD_KELURAHAN']")

                    fetch("index.php?page=builder/subjek-pajak/objek-pajak-bumi/index&filter-blok="+el.value+"&filter-kelurahan="+kelurahan.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

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

                    fetch("index.php?page=builder/subjek-pajak/objek-pajak-bumi/index&get-no-urut=true&blok="+el.value+"&kelurahan="+kelurahan.value+"&kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

                        document.querySelector("[name='NO_URUT']").value = data
                    })
                }    
            </script>

        <?php endif ?>
    <?php elseif($submit && $jenis_op == 'bangunan'): ?>
        <?php if(!empty($data)) : ?>
            <form id="bangunan" action="" method="post" enctype="multipart/form-data" style="margin-left:auto;margin-right:auto;max-width:1000px;">

                <?php if($failed): ?>
                <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-6" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div class="flex items-center">
                        <p class="font-bold m-0"><?=$failed?></p>
                        </div>
                    </div>
                </div>
                <?php endif ?> 

                <div class="bg-white shadow-md rounded my-6 p-8">

                    <h2 class="text-lg mb-10 text-center font-bold">Nomor Formulir</h2>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="form-group mb-2">
                            <label>NOP</label>
                            <input type="text" readonly required class="p-2 mt-2 w-full border rounded" value="<?=$data["NOP"] ? $data["NOP"] : $data['NOP']?>" name="NOP">
                        </div>

                        <div class="form-group mb-2">
                            <label>NO LSPOP</label>
                            <input type="text" required class="p-2 mt-2 w-full border rounded" value="<?=$data["NO_FORMULIR_LSPOP"] ? $data["NO_FORMULIR_LSPOP"] : $data["NO_FORMULIR_LSPOP"]?>" name="NO_FORMULIR_LSPOP">
                        </div>

                        <div class="form-group mb-2">
                            <label>Tahun Pajak</label>
                            <select required name="THN_PAJAK" class="p-2 mt-2 w-full border rounded">
                                <option value="" selected readonly>- Pilih Tahun -</option>
                                <?php foreach($years as $year):?>
                                    <option <?=isset($old) && $old['THN_PAJAK'] && $old['THN_PAJAK'] == $year ? 'selected'  : $year == $nYear ? "selected" : ''?> value="<?=$year?>"><?=$year?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="bg-white shadow-md rounded my-6 p-8">

                    <h2 class="text-lg mb-10 text-center font-bold">Rincian Data Bangunan</h2>

                    <div class="grid grid-cols-2 gap-4">

                        <div>

                            <div class="grid grid-cols-3 gap-4">
                                <div class="form-group mb-2">
                                    <label>No Bangunan</label>
                                    <input required type="text" class="p-2 mt-2 w-full border rounded" value="<?=$data["NO_BNG"] ? $data["NO_BNG"] : ''?>" name="NO_BNG">
                                </div>
                
                                <div class="form-group mb-2">
                                    <label>Jumlah Lantai</label>
                                    <input required type="text" class="p-2 mt-2 w-full border rounded" value="<?=$data["JML_LANTAI_BNG"] ? $data["JML_LANTAI_BNG"] : ''?>" name="JML_LANTAI_BNG">
                                </div>
                
                                <div class="form-group mb-2">
                                    <label>Luas (M2)</label>
                                    <input required type="text" class="p-2 mt-2 w-full border rounded" value="<?=$data["LUAS_BNG"] ? $data["LUAS_BNG"] : ''?>" name="LUAS_BNG">
                                </div>
                            </div>
                        
                            <div class="form-group mb-2">
                                <label>Jenis Pajak Bangunan</label>
                                <select required name="KD_JPB" class="p-2 mt-2 w-full border rounded">
                                    <option value="" selected readonly>- Pilih Jenis Pajak Bangunan -</option>
                                    <?php foreach($jpbs as $jpb):?>
                                        <option <?=isset($data) && $data['KD_JPB'] && $data['KD_JPB'] == $jpb["KD_JPB"] ? 'selected'  : $jpb['KD_JPB'] == "01" ? "selected" : ''?> value="<?=$jpb['KD_JPB']?>"><?=$jpb['KD_JPB']." - ".$jpb['NM_JPB']?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">

                                <div class="form-group mb-2">
                                    <label>Tahun Dibangun</label>
                                    <select required name="THN_DIBANGUN_BNG" class="p-2 mt-2 w-full border rounded">
                                        <option value="" selected readonly>- Pilih Tahun -</option>
                                        <?php foreach($years as $year):?>
                                            <option <?=isset($data) && $data['THN_DIBANGUN_BNG'] && $data['THN_DIBANGUN_BNG'] == $year ? 'selected'  : $year == $nYear ? "selected" : ''?> value="<?=$year?>"><?=$year?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                
                                <div class="form-group mb-2">
                                    <label>Tahun Renovasi</label>
                                    <select name="THN_RENOVASI_BNG" class="p-2 mt-2 w-full border rounded">
                                        <option value="" selected readonly>- Pilih Tahun -</option>
                                        <?php foreach($years as $year):?>
                                            <option <?=isset($data) && $data['THN_RENOVASI_BNG'] && $data['THN_RENOVASI_BNG'] == $year ? 'selected'  : ''?> value="<?=$year?>"><?=$year?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                            </div>  

                            <div class="grid grid-cols-2 gap-4">

                            <div class="form-group mb-2">
                                    <label>Kondisi Bangunan</label>
                                    <select required name="KONDISI_BNG" class="p-2 mt-2 w-full border rounded">
                                        <option value="" selected readonly>- Pilih Kondisi -</option>
                                        <?php foreach($kondisis as $kondisi):?>
                                            <option <?=isset($data) && $data['KONDISI_BNG'] && $data['KONDISI_BNG'] == substr($kondisi,0,2) ? 'selected'  : substr($kondisi,0,2) == "02" ? "selected" : ''?> value="<?=substr($kondisi,0,2)?>"><?=$kondisi?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Jenis Konstruksi</label>
                                    <select required name="JNS_KONSTRUKSI_BNG" class="p-2 mt-2 w-full border rounded">
                                        <option value="" selected readonly>- Pilih Jenis Konstruksi -</option>
                                        <?php foreach($konstruksis as $konstruksi):?>
                                            <option <?=isset($data) && $data['JNS_KONSTRUKSI_BNG'] && $data['JNS_KONSTRUKSI_BNG'] == substr($konstruksi,0,2) ? 'selected'  : substr($konstruksi,0,2) == "02" ? "selected" : ''?> value="<?=substr($konstruksi,0,2)?>"><?=$konstruksi?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                            </div>

                        </div>

                        <div>

                        <div class="form-group mb-2">
                                <label>Jenis Atap</label>
                                <select required name="JNS_ATAP_BNG" class="p-2 mt-2 w-full border rounded">
                                    <option value="" selected readonly>- Pilih Jenis Atap -</option>
                                    <?php foreach($ataps as $atap):?>
                                        <option <?=isset($data) && $data['JNS_ATAP_BNG'] && $data['JNS_ATAP_BNG'] == substr($atap,0,2) ? 'selected'  : substr($atap,0,2) == "05" ? "selected" : ''?> value="<?=substr($atap,0,2)?>"><?=$atap?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>Dinding</label>
                                <select required name="KD_DINDING" class="p-2 mt-2 w-full border rounded">
                                    <option value="" selected readonly>- Pilih Dinding -</option>
                                    <?php foreach($dindings as $dinding):?>
                                        <option <?=isset($data) && $data['KD_DINDING'] && $data['KD_DINDING'] == substr($dinding,0,2) ? 'selected'  : substr($dinding,0,2) == "02" ? "selected" : ''?> value="<?=substr($dinding,0,2)?>"><?=$dinding?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>Lantai</label>
                                <select required name="KD_LANTAI" class="p-2 mt-2 w-full border rounded">
                                    <option value="" selected readonly>- Pilih Lantai -</option>
                                    <?php foreach($lantais as $lantai):?>
                                        <option <?=isset($data) && $data['KD_LANTAI'] && $data['KD_LANTAI'] == substr($lantai,0,2) ? 'selected'  : substr($lantai,0,2) == "05" ? "selected" : ''?> value="<?=substr($lantai,0,2)?>"><?=$lantai?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>Langit - Langit</label>
                                <select required name="KD_LANGIT_LANGIT" class="p-2 mt-2 w-full border rounded">
                                    <option value="" selected readonly>- Pilih Langit - Langit -</option>
                                    <?php foreach($langits as $langit):?>
                                        <option <?=isset($data) && $data['KD_LANGIT_LANGIT'] && $data['KD_LANGIT_LANGIT'] == substr($langit,0,2) ? 'selected'  : substr($langit,0,2) == "02" ? "selected" : ''?> value="<?=substr($langit,0,2)?>"><?=$langit?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="bg-white shadow-md rounded my-6 p-8">

                    <h2 class="text-lg mb-10 text-center font-bold">Data Fasilitas</h2>

                    <div class="grid grid-cols-3 gap-4">

                        <div class="form-group mb-2">
                            <label class="text-lg">Listrik dan AC</label>

                            <div class="form-group my-2">
                                <label for="">Daya listrik (watt)</label>
                                <input type="text" required placeholder="Daya listrik (watt)" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tListrik']) ? $fasilitas['tListrik'] : '0'?>" name="L_AC[DAYA_LISTRIK]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Jumlah AC Split</label>
                                <input type="text" placeholder="Jumlah AC Split" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tAC1']) ? $fasilitas['tAC1'] : '0' ?>"  name="L_AC[AC_SPLIT]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Jumlah AC Window</label>
                                <input type="text" placeholder="Jumlah AC Window" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tAC2']) ? $fasilitas['tAC2'] : '0'?>" name="L_AC[AC_WINDOW]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">AC Central</label>
                                <select name="L_AC[AC_CENTRAL]" class="p-2 mt-2 w-full border rounded">
                                    <option value="" selected readonly>- Pilih AC Central -</option>
                                    <option <?= isset($fasilitas['cbo_ac']) && $fasilitas['cbo_ac'] == "01" ? 'selected' : ''?> value="01-Ada">01-Ada</option>
                                    <option <?= isset($fasilitas['cbo_ac']) && $fasilitas['cbo_ac'] == "02" ? 'selected' : 'selected'?> value="02-Tidak Ada">02-Tidak Ada</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-group mb-2">
                            <label class="text-lg">Luas Perkerasan Halaman (M2)</label>

                            <div class="form-group my-2">
                                <label for="">Ringan</label>
                                <input type="text" placeholder="Ringan" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tHal1']) ? $fasilitas['tHal1'] : '0'?>" name="LPH[RINGAN]">
                            </div>
                            
                            <div class="form-group my-2">
                                <label for="">Sedang</label>
                                <input type="text" placeholder="Sedang" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tHal2']) ? $fasilitas['tHal2'] : '0'?>" name="LPH[SEDANG]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Berat</label>
                                <input type="text" placeholder="Berat" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tHal3']) ? $fasilitas['tHal3'] : '0'?>" name="LPH[BERAT]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Penutup Lantai</label>
                                <input type="text" placeholder="Penutup Lantai" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tHal4']) ? $fasilitas['tHal4'] : '0'?>"  name="LPH[P_LANTAI]">
                            </div>

                        </div>

                        <div class="form-group mb-2">
                            <label class="text-lg">Jumlah Lapangan Tennis</label>

                            <div class="grid grid-cols-2 mt-6 gap-4">
                                <div class="form-group">
                                    <label>Dengan Lampu</label>

                                    <div class="form-group my-2">
                                        <label for="">Beton</label>
                                        <input type="text" placeholder="Beton" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLap_Beton1']) ? $fasilitas['tLap_Beton1'] : '0'?>" name="JLT_DL[BETON]">
                                    </div>

                                    <div class="form-group my-2">
                                        <label for="">Aspal</label>
                                        <input type="text" placeholder="Aspal" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLap_Aspal1']) ? $fasilitas['tLap_Aspal1'] : '0'?>" name="JLT_DL[ASPAL]">
                                    </div>

                                    <div class="form-group my-2">
                                        <label for="">Tanah/Rumput</label>
                                        <input type="text" placeholder="Tanah/Rumput" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLap_Tanah1']) ? $fasilitas['tLap_Tanah1'] : '0'?>" name="JLT_DL[TR]">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tanpa Lampu</label>

                                    <div class="form-group my-2">
                                        <label for="">Beton</label>
                                        <input type="text" placeholder="Beton" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLap_Beton2']) ? $fasilitas['tLap_Beton2'] : '0'?>" name="JLT_TL[BETON]">
                                    </div>

                                    <div class="form-group my-2">
                                        <label for="">Aspal</label>
                                        <input type="text" placeholder="Aspal" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLap_Aspal2']) ? $fasilitas['tLap_Aspal2'] : '0'?>" name="JLT_TL[ASPAL]">
                                    </div>

                                    <div class="form-group my-2">
                                        <label for="">Tanah/Rumput</label>
                                        <input type="text" placeholder="Tanah/Rumput" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLap_Tanah2']) ? $fasilitas['tLap_Tanah2'] : '0'?>" name="JLT_TL[TR]">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="grid grid-cols-3 gap-4 mt-4">

                        <div class="form-group mb-2">
                            <label class="text-lg">Pagar</label>

                            <div class="form-group my-2">
                                <label for="">Bahan Pagar</label>

                                <select name="PAGAR[BP]" class="p-2 mt-2 w-full border rounded">
                                    <option value="" readonly>- Pilih Bahan Pagar -</option>
                                    <option <?= isset($fasilitas['cbo_pagar']) && $fasilitas['cbo_pagar'] == "01" ? 'selected' : !isset($fasilitas['cbo_pagar']) ? 'selected' : ''?> value="01-Baja/Besi">01-Baja/Besi</option>
                                    <option <?= isset($fasilitas['cbo_pagar']) && $fasilitas['cbo_pagar'] == "02" ? 'selected' : ''?>  value="02-Bata/Batako">02-Bata/Batako</option>
                                </select>

                            </div>

                            <div class="form-group my-2">
                                <label for="">Panjang Pagar (M)</label>
                                <input type="text" placeholder="Panjang Pagar (M)" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tPagar']) ? $fasilitas['tPagar'] : '0'?>" name="PAGAR[PP]">
                            </div>

                        </div>

                        <div class="form-group mb-2">
                            <label class="text-lg">Lebar Tangga Berjalan</label>

                            <div class="form-group my-2">
                                <label for=""><= 0.80 M</label>
                                <input type="text" placeholder="<= 0.80 M" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tTangga1']) ? $fasilitas['tTangga1'] : '0'?>" name="LTB[LT]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">> 0.80 M</label>
                                <input type="text" placeholder="> 0.80 M" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tTangga2']) ? $fasilitas['tTangga2'] : '0'?>" name="LTB[MT]">
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label class="text-lg">Pemadam Kebakaran</label>

                            <!-- select -->

                            <div class="form-group my-2">
                                <label for="">Hydrant</label>

                                <select name="PK[HYDRAN]" class="p-2 mt-2 w-full border rounded">
                                    <option value="" readonly>- Pilih -</option>
                                    <option <?= isset($fasilitas['cbo_hydrant']) && $fasilitas['cbo_hydrant'] == "01" ? 'selected' : ''?> value="01">01-Ada</option>
                                    <option <?= isset($fasilitas['cbo_hydrant']) && $fasilitas['cbo_hydrant'] == "02" ? 'selected' : !isset($fasilitas['cbo_hydrant']) ? 'selected'  : ''?>  value="02">02-Tidak Ada</option>
                                </select>

                            </div>

                            <div class="form-group my-2">
                                <label for="">Springkler</label>

                                <select name="PK[SPRINGKLER]" class="p-2 mt-2 w-full border rounded">
                                    <option value="" readonly>- Pilih -</option>
                                    <option <?= isset($fasilitas['cbo_springkler']) && $fasilitas['cbo_springkler'] == "01" ? 'selected' : ''?> value="01">01-Ada</option>
                                    <option <?= isset($fasilitas['cbo_springkler']) && $fasilitas['cbo_springkler'] == "02" ? 'selected' : !isset($fasilitas['cbo_springkler']) ? 'selected'  : ''?>  value="02">02-Tidak Ada</option>
                                </select>

                            </div>

                            <div class="form-group my-2">
                                <label for="">Fire Alarm</label>

                                <select name="PK[FIRE_ALARM]" class="p-2 mt-2 w-full border rounded">
                                    <option value="" readonly>- Pilih -</option>
                                    <option <?= isset($fasilitas['cbo_fa']) && $fasilitas['cbo_fa'] == "01" ? 'selected' : ''?> value="01">01-Ada</option>
                                    <option <?= isset($fasilitas['cbo_fa']) && $fasilitas['cbo_fa'] == "02" ? 'selected' : !isset($fasilitas['cbo_fa']) ? 'selected' : ''?>  value="02">02-Tidak Ada</option>
                                </select>

                            </div>

                        </div>

                    </div>

                    
                    <div class="grid grid-cols-3 gap-4 mt-4">

                        <div class="form-group mb-2">
                            <label class="text-lg">Jumlah Lift</label>

                            <div class="form-group my-2">
                                <label for="">Penumpang</label>
                                <input type="text" placeholder="Penumpang" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLift1']) ? $fasilitas['tLift1'] : '0'?>" name="J_LIFT[PENUMPANG]">
                            </div>
                            
                            <div class="form-group my-2">
                                <label for="">Kapsul</label>
                                <input type="text" placeholder="Kapsul" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLift2']) ? $fasilitas['tLift2'] : '0'?>" name="J_LIFT[KAPSUL]">
                            </div>
                            
                            <div class="form-group my-2">
                                <label for="">Barang</label>
                                <input type="text" placeholder="Barang" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLift3']) ? $fasilitas['tLift3'] : '0'?>" name="J_LIFT[BARANG]">
                            </div>

                        </div>

                        <div class="form-group mb-2">
                            <label class="text-lg">Others</label>

                            <div class="form-group my-2">
                                <label for="">Jumlah Saluran PABX</label>
                                <input type="text"  placeholder="Jumlah Saluran PABX" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tPABX']) ? $fasilitas['tPABX'] : '0'?>" name="OTHERS[JLH_S_PABX]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Dalam Sumur Artesis</label>
                                <input type="text" placeholder="Dalam Sumur Artesis" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tSumur']) ? $fasilitas['tSumur'] : '0'?>" name="OTHERS[DLM_SUMUR_A]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Kapasitas Genset</label>
                                <input type="text"  placeholder="Kapasitas Genset" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tGenset']) ? $fasilitas['tGenset'] : '0'?>" name="OTHERS[K_GENSET]">
                            </div>

                        </div>

                        <div class="form-group mb-2">
                            <label class="text-lg">Kolam Renang</label>

                            <!-- select -->
                            
                            <div class="form-group my-2">
                                <label for="">Finishing Kolam</label>

                                <select name="KOLAM_RENANG[F_KOLAM]" class="p-2 mt-2 w-full border rounded">
                                    <option value="" selected readonly>- Pilih -</option>
                                    <option <?= isset($fasilitas['cbo_kolam']) && $fasilitas['cbo_kolam'] == "01" ? 'selected' : ''?> value="01">01-Displester</option>
                                    <option <?= isset($fasilitas['cbo_kolam']) && $fasilitas['cbo_kolam'] == "02" ? 'selected'  : ''?>  value="02">02-Dengan Pelapis</option>
                                </select>

                            </div>

                            <div class="form-group my-2">
                                <label for="">Luas (M2)</label>
                                <input type="text"  placeholder="Luas (M2)" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tKolam']) ? $fasilitas['tKolam'] : '0'?>" name="KOLAM_RENANG[LUAS]">
                            </div>
                            
                        </div>

                    </div>

                </div>

                <div class="bg-white shadow-md rounded my-6 p-8">

                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group mb-2">
                            <label>Keterangan</label>
                            <input required type="text" class="p-2 mt-2 w-full border rounded" name="KETERANGAN">
                        </div>
            
                        <div class="form-group mb-2">
                            <label>Nilai Individu</label>
                            <input required type="text" class="p-2 mt-2 w-full border rounded" value="<?= isset($INDIVIDU['NILAI_INDIVIDU']) ? $INDIVIDU['NILAI_INDIVIDU'] : '' ?>" name="NILAI_INDIVIDU">
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="w-full p-2 bg-indigo-800 text-white rounded" name="proses_bangunan">Proses</button>
                    </div>

                </div>

            </form>
        <?php else : ?>
            <form id="bangunan" action="" method="post" enctype="multipart/form-data" style="margin-left:auto;margin-right:auto;max-width:1000px;">

                <?php if($failed): ?>
                <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-6" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div class="flex items-center">
                        <p class="font-bold m-0"><?=$failed?></p>
                        </div>
                    </div>
                </div>
                <?php endif ?> 

                <div class="bg-white shadow-md rounded my-6 p-8">

                    <h2 class="text-lg mb-10 text-center font-bold">Nomor Formulir</h2>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="form-group mb-2">
                            <label>NOP</label>
                            <input type="text" required class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP" readonly>
                        </div>

                        <div class="form-group mb-2">
                            <label>NO LSPOP</label>
                            <input type="text" required class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NO_FORMULIR_LSPOP"] ? $old["NO_FORMULIR_LSPOP"] : ''?>" name="NO_FORMULIR_LSPOP">
                        </div>

                        <div class="form-group mb-2">
                            <label>Tahun Pajak</label>
                            <select required name="THN_PAJAK" class="p-2 mt-2 w-full border rounded">
                                <option value="" selected readonly>- Pilih Tahun -</option>
                                <?php foreach($years as $year):?>
                                    <option <?=isset($old) && $old['THN_PAJAK'] && $old['THN_PAJAK'] == $year ? 'selected'  : $year == date('Y') ? "selected" : ''?> value="<?=$year?>"><?=$year?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="bg-white shadow-md rounded my-6 p-8">

                    <h2 class="text-lg mb-10 text-center font-bold">Rincian Data Bangunan</h2>

                    <div class="grid grid-cols-2 gap-4">

                        <div>

                            <div class="grid grid-cols-3 gap-4">
                                <div class="form-group mb-2">
                                    <label>No Bangunan</label>
                                    <input required type="text" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NO_BNG"] ? $old["NO_BNG"] : ''?>" name="NO_BNG">
                                </div>
                
                                <div class="form-group mb-2">
                                    <label>Jumlah Lantai</label>
                                    <input required type="text" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["JML_LANTAI_BNG"] ? $old["JML_LANTAI_BNG"] : '1'?>" name="JML_LANTAI_BNG">
                                </div>
                
                                <div class="form-group mb-2">
                                    <label>Luas (M2)</label>
                                    <input required type="text" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["LUAS_BNG"] ? $old["LUAS_BNG"] : '0'?>" name="LUAS_BNG">
                                </div>
                            </div>
                        
                            <div class="form-group mb-2">
                                <label>Jenis Pajak Bangunan</label>
                                <select required name="KD_JPB" class="p-2 mt-2 w-full border rounded">
                                    <option value="" selected readonly>- Pilih Jenis Pajak Bangunan -</option>
                                    <?php foreach($jpbs as $jpb):?>
                                        <option <?=isset($old) && $old['KD_JPB'] && $old['KD_JPB'] == $jpb["KD_JPB"] ? 'selected'  : $jpb['KD_JPB'] == "01" ? "selected" : ''?> value="<?=$jpb['KD_JPB']?>"><?=$jpb['KD_JPB']." - ".$jpb['NM_JPB']?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                    
                                <div class="form-group mb-2">
                                    <label>Tahun Dibangun</label>
                                    <select required name="THN_DIBANGUN_BNG" class="p-2 mt-2 w-full border rounded">
                                        <option value="" selected readonly>- Pilih Tahun -</option>
                                        <?php foreach($years as $year):?>
                                            <option <?=isset($old) && $old['THN_DIBANGUN_BNG'] && $old['THN_DIBANGUN_BNG'] == $year ? 'selected'  : $year == $nYear ? "selected" : ''?> value="<?=$year?>"><?=$year?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                
                                <div class="form-group mb-2">
                                    <label>Tahun Renovasi</label>
                                    <select name="THN_RENOVASI_BNG" class="p-2 mt-2 w-full border rounded">
                                        <option value="" selected readonly>- Pilih Tahun -</option>
                                        <?php foreach($years as $year):?>
                                            <option <?=isset($old) && $old['THN_RENOVASI_BNG'] && $old['THN_RENOVASI_BNG'] == $year ? 'selected'  : ''?> value="<?=$year?>"><?=$year?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                            </div>  

                            <div class="grid grid-cols-2 gap-4">
            
                                <div class="form-group mb-2">
                                    <label>Kondisi Bangunan</label>
                                    <select required name="KONDISI_BNG" class="p-2 mt-2 w-full border rounded">
                                        <option value="" selected readonly>- Pilih Kondisi -</option>
                                        <?php foreach($kondisis as $kondisi):?>
                                            <option <?=isset($old) && $old['KONDISI_BNG'] && $old['KONDISI_BNG'] == substr($kondisi,0,2) ? 'selected'  : substr($kondisi,0,2) == "02" ? "selected" : ''?> value="<?=substr($kondisi,0,2)?>"><?=$kondisi?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Jenis Konstruksi</label>
                                    <select required name="JNS_KONSTRUKSI_BNG" class="p-2 mt-2 w-full border rounded">
                                        <option value="" selected readonly>- Pilih Jenis Konstruksi -</option>
                                        <?php foreach($konstruksis as $konstruksi):?>
                                            <option <?=isset($old) && $old['JNS_KONSTRUKSI_BNG'] && $old['JNS_KONSTRUKSI_BNG'] == substr($konstruksi,0,2) ? 'selected'  : substr($konstruksi,0,2) == "02" ? "selected" : ''?> value="<?=substr($konstruksi,0,2)?>"><?=$konstruksi?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                            </div>

                        </div>

                        <div>
            
                            <div class="form-group mb-2">
                                <label>Jenis Atap</label>
                                <select required name="JNS_ATAP_BNG" class="p-2 mt-2 w-full border rounded">
                                    <option value="" selected readonly>- Pilih Jenis Atap -</option>
                                    <?php foreach($ataps as $atap):?>
                                        <option <?=isset($old) && $old['JNS_ATAP_BNG'] && $old['JNS_ATAP_BNG'] == substr($atap,0,2) ? 'selected'  : substr($atap,0,2) == "05" ? "selected" : ''?> value="<?=substr($atap,0,2)?>"><?=$atap?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>Dinding</label>
                                <select required name="KD_DINDING" class="p-2 mt-2 w-full border rounded">
                                    <option value="" selected readonly>- Pilih Dinding -</option>
                                    <?php foreach($dindings as $dinding):?>
                                        <option <?=isset($old) && $old['KD_DINDING'] && $old['KD_DINDING'] == substr($dinding,0,2) ? 'selected'  : substr($dinding,0,2) == "02" ? "selected" : ''?> value="<?=substr($dinding,0,2)?>"><?=$dinding?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>Lantai</label>
                                <select required name="KD_LANTAI" class="p-2 mt-2 w-full border rounded">
                                    <option value="" selected readonly>- Pilih Lantai -</option>
                                    <?php foreach($lantais as $lantai):?>
                                        <option <?=isset($old) && $old['KD_LANTAI'] && $old['KD_LANTAI'] == substr($lantai,0,2) ? 'selected'  : substr($lantai,0,2) == "05" ? "selected" : ''?> value="<?=substr($lantai,0,2)?>"><?=$lantai?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>Langit - Langit</label>
                                <select required name="KD_LANGIT_LANGIT" class="p-2 mt-2 w-full border rounded">
                                    <option value="" selected readonly>- Pilih Langit - Langit -</option>
                                    <?php foreach($langits as $langit):?>
                                        <option <?=isset($old) && $old['KD_LANGIT_LANGIT'] && $old['KD_LANGIT_LANGIT'] == substr($langit,0,2) ? 'selected'  : substr($langit,0,2) == "02" ? "selected" : ''?> value="<?=substr($langit,0,2)?>"><?=$langit?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="bg-white shadow-md rounded my-6 p-8">

                    <h2 class="text-lg mb-10 text-center font-bold">Data Fasilitas</h2>

                    <div class="grid grid-cols-3 gap-4">

                        <div class="form-group mb-2">
                            <label class="text-lg">Listrik dan AC</label>

                            <div class="form-group my-2">
                                <label for="">Daya listrik (watt)</label>
                                <input type="text" required placeholder="Daya listrik (watt)" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["L_AC"]["DAYA_LISTRIK"] ? $old["L_AC"]["DAYA_LISTRIK"] : '0'?>" name="L_AC[DAYA_LISTRIK]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Jumlah AC Split</label>
                                <input type="text" placeholder="Jumlah AC Split" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["L_AC"]["AC_SPLIT"] ? $old["L_AC"]["AC_SPLIT"] : '0'?>" name="L_AC[AC_SPLIT]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Jumlah AC Window</label>
                                <input type="text" placeholder="Jumlah AC Window" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["L_AC"]["AC_WINDOW"] ? $old["L_AC"]["AC_WINDOW"] : '0'?>" name="L_AC[AC_WINDOW]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">AC Central</label>

                                <select name="L_AC[AC_CENTRAL]" class="p-2 mt-2 w-full border rounded">
                                    <option value="" readonly>- Pilih AC Central -</option>
                                    <option <?= isset($old) && $old["L_AC"]["AC_CENTRAL"] && $old["L_AC"]["AC_CENTRAL"] == "01-Ada" ?  'selected' : ''?> value="01-Ada">01-Ada</option>
                                    <option <?= isset($old) && $old["L_AC"]["AC_CENTRAL"] && $old["L_AC"]["AC_CENTRAL"] == "02-Tidak Ada" ? 'selected' : 'selected'?> value="02-Tidak Ada">02-Tidak Ada</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label class="text-lg">Luas Perkerasan Halaman (M2)</label>

                            <div class="form-group my-2">
                                <label for="">Ringan</label>
                                <input type="text" placeholder="Ringan" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["LPH"]["RINGAN"] ? $old["LPH"]["RINGAN"] : '0'?>" name="LPH[RINGAN]">
                            </div>
                            
                            <div class="form-group my-2">
                                <label for="">Sedang</label>
                                <input type="text" placeholder="Sedang" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["LPH"]["SEDANG"] ? $old["LPH"]["SEDANG"] : '0'?>" name="LPH[SEDANG]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Berat</label>
                                <input type="text" placeholder="Berat" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["LPH"]["BERAT"] ? $old["LPH"]["BERAT"] : '0'?>" name="LPH[BERAT]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Penutup Lantai</label>
                                <input type="text" placeholder="Penutup Lantai" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["LPH"]["P+LANTAI"] ? $old["LPH"]["P+LANTAI"] : '0'?>" name="LPH[P_LANTAI]">
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label class="text-lg">Jumlah Lapangan Tennis</label>

                            <div class="grid grid-cols-2 mt-6 gap-4">
                                <div class="form-group">
                                    <label>Dengan Lampu</label>

                                    <div class="form-group my-2">
                                        <label for="">Beton</label>
                                        <input type="text" placeholder="Beton" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["JLT_DL"]["BETON"] ? $old["JLT_DL"]["BETON"] : '0'?>" name="JLT_DL[BETON]">
                                    </div>

                                    <div class="form-group my-2">
                                        <label for="">Aspal</label>
                                        <input type="text" placeholder="Aspal" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["JLT_DL"]["ASPAL"] ? $old["JLT_DL"]["ASPAL"] : '0'?>" name="JLT_DL[ASPAL]">
                                    </div>

                                    <div class="form-group my-2">
                                        <label for="">Tanah/Rumput</label>
                                        <input type="text" placeholder="Tanah/Rumput" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["JLT_DL"]["TR"] ? $old["JLT_DL"]["TR"] : '0'?>" name="JLT_DL[TR]">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tanpa Lampu</label>

                                    <div class="form-group my-2">
                                        <label for="">Beton</label>
                                        <input type="text" placeholder="Beton" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["JLT_TL"]["BETON"] ? $old["JLT_TL"]["BETON"] : '0'?>" name="JLT_TL[BETON]">
                                    </div>

                                    <div class="form-group my-2">
                                        <label for="">Aspal</label>
                                        <input type="text" placeholder="Aspal" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["JLT_TL"]["ASPAL"] ? $old["JLT_TL"]["ASPAL"] : '0'?>" name="JLT_TL[ASPAL]">
                                    </div>

                                    <div class="form-group my-2">
                                        <label for="">Tanah/Rumput</label>
                                        <input type="text" placeholder="Tanah/Rumput" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["JLT_TL"]["TR"] ? $old["JLT_TL"]["TR"] : '0'?>" name="JLT_TL[TR]">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="grid grid-cols-3 gap-4 mt-4">

                        <div class="form-group mb-2">
                            <label class="text-lg">Pagar</label>

                            <div class="form-group my-2">
                                <label for="">Bahan Pagar</label>

                                <select name="PAGAR[BP]" class="p-2 mt-2 w-full border rounded">
                                    <option value="" readonly>- Pilih Bahan Pagar -</option>
                                    <option <?= isset($old) && $old["PAGAR"]["BP"] && $old["PAGAR"]["BP"] == "01-Baja/Besi" ? 'selected' : 'selected'?>  value="01-Baja/Besi">01-Baja/Besi</option>
                                    <option <?= isset($old) && $old["PAGAR"]["BP"] && $old["PAGAR"]["BP"] == "02-Bata/Batako" ? 'selected'  : ''?>  value="02-Bata/Batako">02-Bata/Batako</option>
                                </select>

                            </div>
                            
                            <div class="form-group my-2">
                                <label for="">Panjang Pagar (M)</label>
                                <input type="text" placeholder="Panjang Pagar (M)" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['PAGAR']["PP"] ? $old['PAGAR']["PP"] : '0'?>" name="PAGAR[PP]">
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label class="text-lg">Lebar Tangga Berjalan</label>

                            <div class="form-group my-2">
                                <label for=""><= 0.80 M</label>
                                <input type="text" placeholder="<= 0.80 M" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['LTB']["LT"] ? $old['LTB']["LT"] : '0'?>" name="LTB[LT]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">> 0.80 M</label>
                                <input type="text" placeholder="> 0.80 M" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['LTB']["MT"] ? $old['LTB']["MT"] : '0'?>" name="LTB[MT]">
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label class="text-lg">Pemadam Kebakaran</label>

                            <!-- select -->
                            
                            <div class="form-group my-2">
                                <label for="">Hydrant</label>

                                <select name="PK[HYDRAN]" class="p-2 mt-2 w-full border rounded">
                                    <option value="" selected readonly>- Pilih -</option>
                                    <option <?= isset($old) && $old["PK"]["HYDRAN"] && $old["PK"]["HYDRAN"] == "01" ?  : ''?> value="01">01-Ada</option>
                                    <option <?= isset($old) && $old["PK"]["HYDRAN"] && $old["PK"]["HYDRAN"] == "02" ?  : ''?> selected  value="02">02-Tidak Ada</option>
                                </select>

                            </div>

                            <div class="form-group my-2">
                                <label for="">Springkler</label>

                                <select name="PK[SPRINGKLER]" class="p-2 mt-2 w-full border rounded">
                                    <option value="" selected readonly>- Pilih -</option>
                                    <option <?= isset($old) && $old["PK"]["SPRINGKLER"] && $old["PK"]["SPRINGKLER"] == "01" ?  : ''?> value="01">01-Ada</option>
                                    <option <?= isset($old) && $old["PK"]["SPRINGKLER"] && $old["PK"]["SPRINGKLER"] == "02" ?  : ''?> selected value="02">02-Tidak Ada</option>
                                </select>

                            </div>

                            <div class="form-group my-2">
                                <label for="">Fire Alarm</label>

                                <select name="PK[FIRE_ALARM]" class="p-2 mt-2 w-full border rounded">
                                    <option value="" selected readonly>- Pilih -</option>
                                    <option <?= isset($old) && $old["PK"]["FIRE_ALARM"] && $old["PK"]["FIRE_ALARM"] == "01" ?  : ''?> value="01">01-Ada</option>
                                    <option <?= isset($old) && $old["PK"]["FIRE_ALARM"] && $old["PK"]["FIRE_ALARM"] == "02" ?  : ''?> selected value="02">02-Tidak Ada</option>
                                </select>

                            </div>

                        </div>

                    </div>

                    
                    <div class="grid grid-cols-3 gap-4 mt-4">

                        <div class="form-group mb-2">
                            <label class="text-lg">Jumlah Lift</label>

                            <div class="form-group my-2">
                                <label for="">Penumpang</label>
                                <input type="text" placeholder="Penumpang" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['J_LIFT']["PENUMPANG"] ? $old['J_LIFT']["PENUMPANG"] : '0'?>" name="J_LIFT[PENUMPANG]">
                            </div>
                            
                            <div class="form-group my-2">
                                <label for="">Kapsul</label>
                                <input type="text" placeholder="Kapsul" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['J_LIFT']["KAPSUL"] ? $old['J_LIFT']["KAPSUL"] : '0'?>" name="J_LIFT[KAPSUL]">
                            </div>
                            
                            <div class="form-group my-2">
                                <label for="">Barang</label>
                                <input type="text" placeholder="Barang" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['J_LIFT']["BARANG"] ? $old['J_LIFT']["BARANG"] : '0'?>" name="J_LIFT[BARANG]">
                            </div>

                        </div>

                        <div class="form-group mb-2">
                            <label class="text-lg">Others</label>

                            <div class="form-group my-2">
                                <label for="">Jumlah Saluran PABX</label>
                                <input type="text"  placeholder="Jumlah Saluran PABX" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['OTHERS']["JLH_S_PABX"] ? $old['OTHERS']["JLH_S_PABX"] : '0'?>" name="OTHERS[JLH_S_PABX]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Dalam Sumur Artesis</label>
                                <input type="text" placeholder="Dalam Sumur Artesis" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['OTHERS']["DLM_SUMUR_A"] ? $old['OTHERS']["DLM_SUMUR_A"] : '0'?>" name="OTHERS[DLM_SUMUR_A]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Kapasitas Genset</label>
                                <input type="text"  placeholder="Kapasitas Genset" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['OTHERS']["K_GENSET"] ? $old['OTHERS']["K_GENSET"] : '0'?>" name="OTHERS[K_GENSET]">
                            </div>

                        </div>

                        <div class="form-group mb-2">
                            <label class="text-lg">Kolam Renang</label>

                            <!-- select -->

                            <div class="form-group my-2">
                                <label for="">Finishing Kolam</label>

                                <select name="KOLAM_RENANG[F_KOLAM]" class="p-2 mt-2 w-full border rounded">
                                    <option value="" selected readonly>- Pilih -</option>
                                    <option <?= isset($old) && $old["KOLAM_RENANG"]["F_KOLAM"] && $old["KOLAM_RENANG"]["F_KOLAM"] == "01" ?  : ''?> value="01">01-Displester</option>
                                    <option <?= isset($old) && $old["KOLAM_RENANG"]["F_KOLAM"] && $old["KOLAM_RENANG"]["F_KOLAM"] == "02" ?  : ''?>  value="02">02-Dengan Pelapis</option>
                                </select>

                            </div>
                            
                            <div class="form-group my-2">
                                <label for="">Luas (M2)</label>
                                <input type="text"  placeholder="Luas (M2)" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['KOLAM_RENANG']["LUAS"] ? $old['KOLAM_RENANG']["LUAS"] : '0'?>" name="KOLAM_RENANG[LUAS]">
                            </div>

                        </div>

                    </div>

                </div>

                <div class="bg-white shadow-md rounded my-6 p-8">

                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group mb-2">
                            <label>Keterangan</label>
                            <input required type="text" class="p-2 mt-2 w-full border rounded" name="KETERANGAN">
                        </div>
            
                        <div class="form-group mb-2">
                            <label>Nilai Individu</label>
                            <input required type="text" class="p-2 mt-2 w-full border rounded" name="NILAI_INDIVIDU">
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="w-full p-2 bg-indigo-800 text-white rounded" name="proses_bangunan">Proses</button>
                    </div>

                </div>

            </form>
        <?php endif ?>
    <?php endif ?>
    
</main>

<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<script>
    $(document).ready(e => {
        var nopq = $("input[name='NOPQ']")
        var nop = $("input[name='NOP']")
        var status = $("[name='status']")
        var jenisOp = $("[name='jenis_op']")
        var submit = $("[name='submit']")
        var submit = $("[name='submit']")

        nopq.inputmask({mask:"12.12.999.999.999-9999.9"})
        nop.inputmask({mask:"12.12.999.999.999-9999.9"})

        status.change(function(e){
            if (e.target.value != '-') {
                if (e.target.value == 'Terdaftar') {
                    $("[name='ID']").parent().removeClass('hidden')
                } else {
                    $("[name='ID']").parent().addClass('hidden')
                }

                jenisOp.parent().removeClass('hidden')
            } else {
                jenisOp.parent().addClass('hidden')
            }
        })

        jenisOp.change(function(e){
            if (e.target.value == 'bangunan') {
                nopq.parent().removeClass('hidden')
                $("#op-bumi").addClass('hidden')
                submit.parent().removeClass('hidden')
            } else if(e.target.value == 'bumi') {
                nopq.parent().addClass('hidden')
                $("#op-bng").addClass('hidden')
                submit.parent().removeClass('hidden')
            } else {
                nopq.parent().addClass('hidden')
                $("#op-bumi").addClass('hidden')
                $("#op-bng").addClass('hidden')
                submit.parent().addClass('hidden')
            }
        })

        var jenis_op = <?= json_encode($jenis_op) ?>;
        if(jenis_op == 'bangunan') {
            var dt = <?= json_encode($dt) ?>;
            if(dt.hasOwnProperty('NO_BNG')){
                $("[name='NO_BNG']").val(dt.NO_BNG+1);
                nop.val(dt.NOP)

            }

            var data = <?= json_encode($data) ?>;
            if(data.hasOwnProperty('NO_BNG')){
                $("[name='NO_BNG']").val(data.NO_BNG);
                nop.val(data.NOP)

            }
                
        }


        // submit.click(function(){
        //     if (jenisOp.val() == 'bangunan') {

        //         $.post(document.URL, {check:'true',NOP:nop.val()}, function(data){
        //             if (data != 0) {
        //                 var res = JSON.parse(data)
        //                 $("#op-bng").removeClass('hidden')
        //                 $("[name='NO_BNG']").val(res.NO_BNG+1)
        //             } else {
        //                 alert('Data tidak ditemukan!')
        //                 $("#op-bng").addClass('hidden')
        //             }
        //         })

        //         $("#op-bumi").addClass('hidden')
        //     } else {
        //         $("#op-bumi").removeClass('hidden')
        //         $("#op-bng").addClass('hidden')
        //     }
        // })

        
    })
</script>

<?php load('partials/landing-bottom') ?>