<?php load('builder/partials/top'); ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">Laporan Penilaian Objek Pajak Bumi</h2>
    <div class="my-6">
        <div class="mt-5">
            <form action="" method="get">

                <input type="hidden" name="page" value="<?=$_GET['page']?>">
                
                <div class="form-group inline-block">
                    <select class="p-2 w-full border rounded" name="tahun" id="">
                        <option value="" selected readonly>- Tahun -</option>
                        <?php for($i = date('Y'); $i >= 1990;$i--):?>
                            <option <?= (isset($_GET['tahun']) && $_GET['tahun'] == $i) ? "selected" : ""?> value="<?=$i?>"><?=$i?></option>";
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

                <div class="form-group inline-block">
                    <button class="p-2 bg-green-500 text-white rounded" name="filter">Tampilkan</button>
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
                            <th class="py-3 px-6 text-center">No</th>
                            <th class="py-3 px-6 text-center">NOP</th>
                            <th class="py-3 px-6 text-center">Nama Wajib Pajak</th>
                            <th class="py-3 px-6 text-center">Jenis Bumi<br>Alamat Objek Pajak</th>
                            <th class="py-3 px-6 text-center">Luas Bumi<br>Kode ZNT</th>
                            <th class="py-3 px-6 text-center">NIR</th>
                            <th class="py-3 px-6 text-center">Nilai Sistem</th>
                        </tr>
                    </thead>
                    <?php 
                    foreach($datas as $key => $data): 
                        $nir = $data['NIR']*1000;
                        $nilai_sistem_bumi = $data['TOTAL_LUAS_BUMI']*$nir;
                        $jenis_bumi = [
                            0 => '',
                            1 => '01-Tanah dan Bangunan',
                            2 => '02-Kavling Siang Bangun',
                            3 => '03-Tanah Kosong'
                        ];
                        $jns_bumi = isset($jenis_bumi[$data['JNS_BUMI']]) ? $jenis_bumi[$data['JNS_BUMI']] : '04-Fasilitas Umum';
                        $alamat = $data['JALAN_OP'] . ' Kel/Desa : ' . $data['NM_KELURAHAN'] . '<br> Kec : ' . $data['NM_KECAMATAN'];
                    ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">

                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$key+1?></span>
                            </div>
                        </td>
                        
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NOPQ']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NM_WP']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$jns_bumi?><br><?= $alamat ?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['TOTAL_LUAS_BUMI']?><br><?=$data['KD_ZNT']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=number_format($nir,0,',','.')?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=number_format($nilai_sistem_bumi,0,',','.')?></span>
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
        fetch("index.php?page=builder/penilaian/laporan/bumi&filter-kecamatan="+el.value).then(response => response.json()).then(data => {

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
</script>
<?php load('builder/partials/bottom') ?>
