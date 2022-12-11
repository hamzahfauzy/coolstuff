<?php load('builder/partials/top');
?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">Objek Pajak Bangunan</h2>
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
                    <select name="blok" class="p-2 w-full border rounded">
                        <option value="" selected readonly>- Pilih Blok -</option>
                        <?php foreach($bloks as $blok):?>
                            <option <?= isset($_GET['blok']) && $_GET['blok'] == $blok['KD_BLOK'] && $_GET['kelurahan'] == $blok['KD_KELURAHAN']  && $_GET['kecamatan'] == $blok['KD_KECAMATAN']  ? 'selected' : ''?> value="<?=$blok['KD_BLOK']?>"><?=$blok['KD_BLOK']?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group inline-block">
                    <input type="text" class="p-2 w-full border rounded" placeholder="Cari Nama.." name="nama" value="<?=isset($_GET['nama']) && $_GET['nama'] ? $_GET['nama'] : '' ?>">
                </div>

                <div class="form-group inline-block">
                    <input type="text" class="p-2 w-full border rounded" placeholder="Cari NOP.." name="NOP" value="<?=isset($_GET['NOP']) && $_GET['NOP'] ? $_GET['NOP'] : '' ?>">
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
                            <th class="py-3 px-6 text-left">NOP</th>
                            <th class="py-3 px-6 text-left">Nama</th>
                            <th class="py-3 px-6 text-left">Kecamatan</th>
                            <th class="py-3 px-6 text-left">Kelurahan</th>
                            <th class="py-3 px-6 text-left">Blok</th>
                            <th class="py-3 px-6 text-left">No Urut</th>
                            <th class="py-3 px-6 text-left">Jenis OP</th>
                            <th class="py-3 px-6 text-left">No Bangunan</th>
                            <th class="py-3 px-6 text-left">JPB</th>
                            <th class="py-3 px-6 text-left">No Formulir LSPOP</th>
                            <th class="py-3 px-6 text-left">Tahun Dibangun</th>
                            <th class="py-3 px-6 text-left">Tahun Renovasi</th>
                            <th class="py-3 px-6 text-left">Luas</th>
                            <th class="py-3 px-6 text-left">Jumlah Lantai</th>
                            <th class="py-3 px-6 text-left">Kondisi</th>
                            <th class="py-3 px-6 text-left">Jenis Konstruksi</th>
                            <th class="py-3 px-6 text-left">Jenis Atap</th>
                            <th class="py-3 px-6 text-left">Kode Dinding</th>
                            <th class="py-3 px-6 text-left">Kode Lantai</th>
                            <th class="py-3 px-6 text-left">Kode Langit-Langit</th>
                            <th class="py-3 px-6 text-left">Nilai Sistem</th>
                            <th class="py-3 px-6 text-left">Jenis Transaksi</th>
                            <th class="py-3 px-6 text-left">Tanggal Pendataan</th>
                            <th class="py-3 px-6 text-left">Tanggal Pemeriksaan</th>
                            <th class="py-3 px-6 text-left">Tanggal Perekaman</th>
                            <th class="py-3 px-6 text-left">K Utama</th>
                            <th class="py-3 px-6 text-left">K Material</th>
                            <th class="py-3 px-6 text-left">K Fasilitas</th>
                            <th class="py-3 px-6 text-left">J Susut</th>
                            <th class="py-3 px-6 text-left">K Susut</th>
                            <th class="py-3 px-6 text-left">K Non Susut</th>
                            <th class="py-3 px-6 text-left">NIP Perekam</th>
                            <th class="py-3 px-6 text-left">NIP Pemeriksa</th>
                            <th class="py-3 px-6 text-left">NIP Pendata</th>
                            <th class="py-3 px-6 text-left">Action</th>
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
                                <span class="font-medium"><?= $data['NOPQ'] ?></span>
                            </div>
                        </td>
                        
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?= $data['NM_WP'] ?? "[NO NAME]" ?></span>
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
                                <span class="font-medium"><?=$data['NO_BNG']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NM_JPB_JPT']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NO_FORMULIR_LSPOP']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['THN_DIBANGUN_BNG']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['THN_RENOVASI_BNG']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['LUAS_BNG']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['JML_LANTAI_BNG']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium">
                                    <?php foreach($kondisi as $k){
                                        echo $data['KONDISI_BNG'] == substr($k,0,2) ? $k : '';
                                    }?>
                                </span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium">
                                    <?php foreach($konstruksi as $k){
                                        echo $data['JNS_KONSTRUKSI_BNG'] == substr($k,0,2) ? $k : '';
                                    }?>
                                </span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium">
                                    <?php foreach($atap as $k){
                                        echo $data['JNS_ATAP_BNG'] == substr($k,0,2) ? $k : '';
                                    }?>
                                </span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium">
                                    <?php foreach($dinding as $k){
                                        echo $data['KD_DINDING'] == substr($k,0,2) ? $k : '';
                                    }?>
                                </span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium">
                                    <?php foreach($lantai as $k){
                                        echo $data['KD_LANTAI'] == substr($k,0,2) ? $k : '';
                                    }?>
                                </span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium">
                                    <?php foreach($langit as $k){
                                        echo $data['KD_LANGIT_LANGIT'] == substr($k,0,2) ? $k : '';
                                    }?>
                                </span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NILAI_SISTEM_BNG']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['JNS_TRANSAKSI_BNG']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['TGL_PENDATAAN_BNG']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['TGL_PEMERIKSAAN_BNG']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['TGL_PEREKAMAN_BNG']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['K_UTAMA']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['K_MATERIAL']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['K_FASILITAS']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['J_SUSUT']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['K_SUSUT']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['K_NON_SUSUT']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NIP_PEREKAM_BNG']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NIP_PEMERIKSA_BNG']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NIP_PENDATA_BNG']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <!-- <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div> -->
                                <a href="index.php?page=builder/subjek-pajak/objek-pajak-bangunan/edit&id=<?=$data['SUBJEK_PAJAK_ID']?>&NOP=<?=$data['NOPQ']?>&NO_BNG=<?=$data['NO_BNG']?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <a href="index.php?action=builder/subjek-pajak/objek-pajak-bangunan/delete&id=<?=$data['SUBJEK_PAJAK_ID']?>&NOP=<?=$data['NOPQ']?>&KD_JPB=<?=$data['KD_JPB']?>&NO_BNG=<?=$data['NO_BNG']?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" onclick="if(confirm('Apakah anda yakin menghapus data ini')){return true}else{return false}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a>
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
        fetch("index.php?page=builder/objek-pajak-bangunan/index&filter-kecamatan="+el.value).then(response => response.json()).then(data => {

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

        fetch("index.php?page=builder/objek-pajak-bangunan/index&filter-kelurahan="+el.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

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
</script>

<?php load('builder/partials/bottom') ?>
