<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-xl mr-3">Add Objek Pajak Bumi : <?=$subjekPajak['NM_WP']?></h2>
        <a href="index.php?page=builder/subjek-pajak/view&id=<?=$_GET['id']?>" class="p-2 bg-green-500 text-white rounded">Kembali</a>
    </div>

    <?php if($old): ?>
        <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-6" role="alert">
            <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div class="flex items-center">
                <p class="font-bold m-0">Data Sudah Ada</p>
                </div>
            </div>
        </div>
    <?php endif ?>

     <form id="login-form" action="index.php?page=<?=$_GET['page']?>&id=<?=$_GET['id']?>" method="post" enctype="multipart/form-data">

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
            <div class="grid grid-cols-2 gap-4 mt-4">

                <div class="form-group mb-2">
                    <label>Tanggal Pendataan</label>
                    <input type="date" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["TGL_PENDATAAN"] ? $old["TGL_PENDATAAN"] : ''?>" name="TGL_PENDATAAN">
                </div>

                <div class="form-group mb-2">
                    <label>NIP Pendata</label>
                    <input type="text" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NIP_PENDATA"] ? $old["NIP_PENDATA"] : ''?>" name="NIP_PENDATA">
                </div>

                <div class="form-group mb-2">
                    <label>Tanggal Pemeriksaan</label>
                    <input type="date" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["TGL_PEMERIKSAAN"] ? $old["TGL_PEMERIKSAAN"] : ''?>" name="TGL_PEMERIKSAAN">
                </div>

                <div class="form-group mb-2">
                    <label>NIP Pemeriksa</label>
                    <input type="text" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NIP_PEMERIKSA"] ? $old["NIP_PEMERIKSA"] : ''?>" name="NIP_PEMERIKSA">
                </div>

                <div class="form-group mb-2">
                    <label>Tanggal Perekam</label>
                    <input type="date" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["TGL_PEREKAMAN"] ? $old["TGL_PEREKAMAN"] : ''?>" name="TGL_PEREKAMAN">
                </div>

                <div class="form-group mb-2">
                    <label>NIP Perekam</label>
                    <input type="text" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NIP_PEREKAM"] ? $old["NIP_PEREKAM"] : ''?>" name="NIP_PEREKAM">
                </div>

            </div>
        </div>

        
        <div class="bg-white shadow-md rounded my-6 p-8">

            <div class="form-group mb-2">
                <label>Keterangan</label>
                <input type="text" value="<?=isset($old) && $old["KETERANGAN"] ? $old["KETERANGAN"] : ''?>" class="p-2 mt-2 w-full border rounded" name="KETERANGAN">
            </div>

            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" id="btn-login">Create</button>
            </div>

        </div>

    </form>

</div>

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

<?php load('builder/partials/bottom') ?>
