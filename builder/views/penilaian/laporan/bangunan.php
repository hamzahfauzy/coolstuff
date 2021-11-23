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
                    <button class="p-2 bg-green-500 text-white rounded" name="cetak">Cetak</button>
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
                            <th class="py-3 px-6 text-center">Alamat Objek</th>
                        </tr>
                    </thead>
                    <?php 
                    foreach($datas as $key => $data): 
                        $alamat_wp = $data['JALAN_OP']." <br> KEL/DESA :" . $data['NM_KELURAHAN']." <br> KEC :" . $data['NM_KECAMATAN'];
                        $alamat = $data['JALAN_OP'] . ' <br> Kel/Desa : ' . $data['NM_KELURAHAN'] . '<br> Kec : ' . $data['NM_KECAMATAN'];

                        $child_data = [
                            [
                                'Bangunan Ke' => $data['NO_BNG'],
                                'Biaya Komponen Utama' => number_format($data['K_UTAMA'])
                            ],
                            [
                                'JPB' => $data['KD_JPB'] . "-" . $data['NM_JPB'],
                                'Biaya Komponen Material' => number_format($data['K_UTAMA'])
                            ],
                            [
                                'Luas Bng (M2)' => $data['LUAS_BNG'],
                                'Biaya Komponen Fasilitas' => number_format($data['K_FASILITAS'])
                            ],
                            [
                                'JLH Lantai' => $data['JML_LANTAI_BNG'],
                                'Jumlah' => number_format($data['K_UTAMA']+$data['K_MATERIAL']+$data['K_FASILITAS'])
                            ],
                            [
                                'Kondisi' => $data['KONDISI_BNG'],
                                'Nilai Penyusutan' => $data['J_SUSUT'].'% X '.number_format($data['K_UTAMA']+$data['K_MATERIAL']+$data['K_FASILITAS']).' = '.number_format($data['K_SUSUT'])
                            ],
                            [
                                'Konstruksi' => $data['JNS_KONSTRUKSI_BNG'],
                                'Biaya Non Susut' => number_format($data['K_NON_SUSUT'])
                            ],
                            [
                                'THN Bangun' => $data['THN_DIBANGUN_BNG'],
                                'Total' => number_format($data['NILAI_SISTEM_BNG'])
                            ],
                            [
                                'THN Renovasi' => $data['THN_RENOVASI_BNG'],
                                'Nilai Sistem Per M2' => number_format($data['NILAI_SISTEM_BNG']/$data['LUAS_BNG'])
                            ],
                        ];
                    ?>
                    <tr class="border-b border-gray-200 bg-gray-100">
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
                                <span class="font-medium">
                                    <?=$data['NM_WP']?><br>
                                    <?=$alamat_wp?>
                                </span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?= $alamat ?></span>
                            </div>
                        </td>
                    </tr>
                    <?php foreach($child_data as $child): ?>
                    <tr>
                        <?php foreach($child as $key => $value): ?>
                        <td class="py-3 px-6 text-left border" colspan="2">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$key?> : <?=$value?></span>
                            </div>
                        </td>
                        <?php endforeach ?>
                    </tr>
                    <?php endforeach ?>
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
