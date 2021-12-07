<?php load('builder/partials/top');
?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">Objek Pajak Bumi</h2>
    <div class="my-6">
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
        <div class="mt-5">
            <form action="" method="get">

                <input type="hidden" name="page" value="<?=$_GET['page']?>">
                
                <div class="form-group inline-block">
                    <select class="p-2 w-full border rounded" name="limit" id="">
                        <option value="" selected readonly>- Tampilkan jumlah data -</option>
                        <option <?= (isset($_GET['limit']) && $_GET['limit'] == $limits['count']) ? "selected" : ""?> value="<?=$limits['count']?>">Tampilkan Semua</option>
                        <?php for($i = 10; $i <= $limits['count'];$i+=10):?>
                            <option <?= (isset($_GET['limit']) && $_GET['limit'] == $i) ? "selected" : ""?> value="<?=$i?>"><?=$i?></option>";
                        <?php endfor ?>
                    </select>
                </div>

                <div class="form-group inline-block">
                    <select name="kecamatan" class="p-2 w-full border rounded" onchange="kecamatanChange(this)">
                        <option value="" selected readonly>- Pilih Kecamatan -</option>
                        <?php foreach($kecamatans as $kecamatan):?>
                            <option <?= isset($_GET['kecamatan']) && $_GET['kecamatan'] == $kecamatan['KD_KECAMATAN'] ? 'selected' : ''?> value="<?=$kecamatan['KD_KECAMATAN']?>"><?=$kecamatan['KD_KECAMATAN']." - ".$kecamatan['NM_KECAMATAN']?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group inline-block <?=(isset($_GET['kelurahan']) && $_GET['kelurahan']) || (isset($_GET['kecamatan']) && $_GET['kecamatan']) ? '' : 'hidden' ?>" id="kelurahan">
                    <select name="kelurahan" class="p-2 w-full border rounded" onchange="kelurahanChange(this)">
                        <option value="" selected readonly>- Pilih Kelurahan -</option>
                        <?php foreach($kelurahans as $kelurahan):?>
                            <option <?= isset($_GET['kelurahan']) && $_GET['kelurahan'] == $kelurahan['KD_KELURAHAN'] && $_GET['kecamatan'] == $kelurahan['KD_KECAMATAN']  ? 'selected' : ''?> value="<?=$kelurahan['KD_KELURAHAN']?>"><?=$kelurahan['KD_KELURAHAN']." - ".$kelurahan['NM_KELURAHAN']?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group inline-block <?=(isset($_GET['blok']) && $_GET['blok']) || (isset($_GET['kelurahan']) && $_GET['kelurahan']) ? '' : 'hidden' ?>" id="blok">
                    <select name="blok" class="p-2 w-full border rounded" onchange="blokChange(this)">
                        <option value="" selected readonly>- Pilih Blok -</option>
                        <?php foreach($bloks as $blok):?>
                            <option <?= isset($_GET['blok']) && $_GET['blok'] == $blok['KD_BLOK'] && $_GET['kelurahan'] == $blok['KD_KELURAHAN']  && $_GET['kecamatan'] == $blok['KD_KECAMATAN']  ? 'selected' : ''?> value="<?=$blok['KD_BLOK']?>"><?=$blok['KD_BLOK']?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group inline-block <?=(isset($_GET['znt']) && $_GET['znt']) || (isset($_GET['blok']) && $_GET['blok']) ? '' : 'hidden' ?>" id="znt">
                    <select name="znt" class="p-2 w-full border rounded">
                        <option value="" selected readonly>- Pilih Znt -</option>
                        <?php foreach($znts as $znt):?>
                            <option <?= isset($_GET['znt']) && $_GET['znt'] == $znt['KD_ZNT'] && $_GET['blok'] == $znt['KD_BLOK']  &&  $_GET['kelurahan'] == $znt['KD_KELURAHAN']  && $_GET['kecamatan'] == $znt['KD_KECAMATAN']  ? 'selected' : ''?> value="<?=$znt['KD_ZNT']?>"><?=$znt['KD_ZNT']?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group inline-block">
                    <input type="text" class="p-2 w-full border rounded" placeholder="Cari.." name="nama" value="<?=isset($_GET['nama']) && $_GET['nama'] ? $_GET['nama'] : '' ?>">
                </div>

                <div class="form-group inline-block">
                    <button class="p-2 bg-green-500 text-white rounded" name="filter">Filter</button>
                </div>

            </form>
        </div>
        <div class="bg-white shadow-md rounded my-3 overflow-x-auto">
            <table class="min-w-max w-full table-auto">
                <tbody class="text-gray-600 text-sm font-light">
                    <?php if(empty($datas)): ?>
                    <tr>
                        <td colspan="4" class="py-3 px-6 text-center font-semibold"><i>Empty</i></td>
                    </tr>
                    <?php else: ?>
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">No</th>
                            <th class="py-3 px-6 text-left">Nama</th>
                            <th class="py-3 px-6 text-left">Kecamatan</th>
                            <th class="py-3 px-6 text-left">Kelurahan</th>
                            <th class="py-3 px-6 text-left">Blok</th>
                            <th class="py-3 px-6 text-left">No Urut</th>
                            <th class="py-3 px-6 text-left">Jenis OP</th>
                            <th class="py-3 px-6 text-left">No Bumi</th>
                            <th class="py-3 px-6 text-left">ZNT</th>
                            <th class="py-3 px-6 text-left">Luas</th>
                            <th class="py-3 px-6 text-left">Jenis Bumi</th>
                            <th class="py-3 px-6 text-left">Nilai Sistem Bumi</th>
                            <th class="py-3 px-6 text-left">N0 Formulir</th>
                            <th class="py-3 px-6 text-left">Status Jadi</th>
                            <th class="py-3 px-6 text-left">Subjek Pajak ID</th>
                        </tr>
                    </thead>
                    <?php foreach($datas as $key => $data): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">

                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$key+1?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NM_WP']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['KD_KECAMATAN']." - "?><?= $data['NM_KECAMATAN'] ?? "[NO NAME]" ?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['KD_KELURAHAN']." - "?><?= $data['NM_KELURAHAN'] ?? "[NO NAME]" ?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['KD_BLOK']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NO_URUT']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['KD_JNS_OP']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NO_BUMI']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['KD_ZNT']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['LUAS_BUMI']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium">
                                    <?php foreach($jenisBumi as $bumi){
                                        echo $data['JNS_BUMI'] == substr($bumi,0,2) ? $bumi : '';
                                    }?>
                                </span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NILAI_SISTEM_BUMI']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NO_FORMULIR']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['STATUS_JADI']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['SUBJEK_PAJAK_ID']?></span>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>

    function kecamatanChange(el){
        fetch("index.php?page=builder/objek-pajak-bumi/index&filter-kecamatan="+el.value).then(response => response.json()).then(data => {

                var html = `<select name="kelurahan" class="p-2 w-full border rounded" onchange="kelurahanChange(this)">
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
        var kecamatan = document.querySelector("select[name='kecamatan']")

        fetch("index.php?page=builder/objek-pajak-bumi/index&filter-kelurahan="+el.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

                var html = `<select name="blok" class="p-2 w-full border rounded" onchange="blokChange(this)">
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
        var kecamatan = document.querySelector("select[name='kecamatan']")
        var kelurahan = document.querySelector("select[name='kelurahan']")

        fetch("index.php?page=builder/objek-pajak-bumi/index&filter-blok="+el.value+"&filter-kelurahan="+kelurahan.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

                var html = `<select name="znt" class="p-2 w-full border rounded">
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
