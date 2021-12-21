<?php load('builder/partials/top');
?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">Cetak SPPT</h2>
    <div class="my-6">
        <?php if(!empty($datas)): ?>
        <div class="flex items-center">
            <a href="index.php?page=builder/laporan/sppt/cetak-all&kecamatan=<?=$kecamatan['KD_KECAMATAN']?>&kelurahan=<?=$kelurahan['KD_KELURAHAN']?>&tahun_pajak=<?=$_GET['tahun_pajak']?>&tanggal_terbit=<?=$_GET['tanggal_terbit']?>&tanggal_cetak=<?=$_GET['tanggal_cetak']?>&nip_pencetak=<?=$_GET['nip_pencetak']?>" target="_blank" class="p-2 bg-green-500 text-white rounded">
                Cetak Semua
            </a>
            &nbsp;
            <a href="index.php?page=builder/laporan/sppt/index" class="p-2 bg-yellow-500 text-white rounded block text-center">Kembali</a>
        </div>
        <?php if(!empty($kecamatan) || !empty($kelurahan)): ?>
        <div class="bg-white shadow-md rounded my-3 py-3 px-6">
            <?php if($kecamatan): ?>
            <h3 class="text-2xl">Kecamatan : <?=$kecamatan['NM_KECAMATAN']?></h3>
            <?php endif ?>
            <?php if($kelurahan): ?>
            <h3 class="text-2xl">Kelurahan : <?=$kelurahan['NM_KELURAHAN']?></h3>
            <?php endif ?>
        </div>
        <?php endif ?>
        <?php endif ?>
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
                            <?php 
                            /*
                            foreach($datas[0] as $key => $value): 
                                if(is_object($value)) continue;
                            ?>
                            <th class="py-3 px-6 text-left"><?=$key?></th>
                            <?php endforeach */ ?>
                            <th class="py-3 px-6 text-left">NOP</th>
                            <th class="py-3 px-6 text-left">Nama WP</th>
                            <th class="py-3 px-6 text-left">Alamat WP</th>
                            <th class="py-3 px-6 text-left">Jumlah PBB</th>
                            <th class="py-3 px-6 text-left">Tempat Pembayaran</th>
                            <th class="py-3 px-6 text-center">Action</th>
                        </tr>
                    </thead>
                    <?php foreach($datas as $key => $data): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$key+1?></span>
                            </div>
                        </td>

                        <?php /* foreach($data as $key => $value): if(is_object($value)) continue; ?>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$value?></span>
                            </div>
                        </td>
                        <?php endforeach */ ?>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NOPQ']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NM_WP_SPPT']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium">
                                    <?=$data['JLN_WP_SPPT']?>,
                                    <?=$data['KELURAHAN_WP_SPPT']?>,
                                    <?=$data['KOTA_WP_SPPT']?>
                                </span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=number_format($data['PBB_YG_HARUS_DIBAYAR_SPPT'])?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NM_TP']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <a href="index.php?page=builder/laporan/sppt/cetak&NOP=<?=$data['NOPQ']?>&tahun_pajak=<?=$_GET['tahun_pajak']?>&tanggal_terbit=<?=$_GET['tanggal_terbit']?>&tanggal_cetak=<?=$_GET['tanggal_cetak']?>&nip_pencetak=<?=$_GET['nip_pencetak']?>" target="_blank" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 114.13" style="enable-background:new 0 0 122.88 114.13" xml:space="preserve">
                                        <g>
                                            <path d="M23.2,29.44V3.35V0.53C23.2,0.24,23.44,0,23.73,0h2.82h54.99c0.09,0,0.17,0.02,0.24,0.06l1.93,0.8l-0.2,0.49l0.2-0.49 c0.08,0.03,0.14,0.08,0.2,0.14l12.93,12.76l0.84,0.83l-0.37,0.38l0.37-0.38c0.1,0.1,0.16,0.24,0.16,0.38v1.18v13.31 c0,0.29-0.24,0.53-0.53,0.53h-5.61c-0.29,0-0.53-0.24-0.53-0.53v-6.88H79.12H76.3c-0.29,0-0.53-0.24-0.53-0.53 c0-0.02,0-0.03,0-0.05v-2.77h0V6.69H29.89v22.75c0,0.29-0.24,0.53-0.53,0.53h-5.64C23.44,29.97,23.2,29.73,23.2,29.44L23.2,29.44z M30.96,67.85h60.97h0c0.04,0,0.08,0,0.12,0.01c0.83,0.02,1.63,0.19,2.36,0.49c0.79,0.33,1.51,0.81,2.11,1.41 c0.59,0.59,1.07,1.31,1.4,2.1c0.3,0.73,0.47,1.52,0.49,2.35c0.01,0.04,0.01,0.08,0.01,0.12v0v9.24h13.16h0c0.04,0,0.07,0,0.11,0.01 c0.57-0.01,1.13-0.14,1.64-0.35c0.57-0.24,1.08-0.59,1.51-1.02c0.43-0.43,0.78-0.94,1.02-1.51c0.21-0.51,0.34-1.07,0.35-1.65 c-0.01-0.03-0.01-0.07-0.01-0.1v0V43.55v0c0-0.04,0-0.07,0.01-0.11c-0.01-0.57-0.14-1.13-0.35-1.64c-0.24-0.56-0.59-1.08-1.02-1.51 c-0.43-0.43-0.94-0.78-1.51-1.02c-0.51-0.22-1.07-0.34-1.65-0.35c-0.03,0.01-0.07,0.01-0.1,0.01h0H11.31h0 c-0.04,0-0.08,0-0.11-0.01c-0.57,0.01-1.13,0.14-1.64,0.35C9,39.51,8.48,39.86,8.05,40.29c-0.43,0.43-0.78,0.94-1.02,1.51 c-0.21,0.51-0.34,1.07-0.35,1.65c0.01,0.03,0.01,0.07,0.01,0.1v0v35.41v0c0,0.04,0,0.08-0.01,0.11c0.01,0.57,0.14,1.13,0.35,1.64 c0.24,0.57,0.59,1.08,1.02,1.51C8.48,82.65,9,83,9.56,83.24c0.51,0.22,1.07,0.34,1.65,0.35c0.03-0.01,0.07-0.01,0.1-0.01h0h13.16 v-9.24v0c0-0.04,0-0.08,0.01-0.12c0.02-0.83,0.19-1.63,0.49-2.35c0.31-0.76,0.77-1.45,1.33-2.03c0.02-0.03,0.04-0.06,0.07-0.08 c0.59-0.59,1.31-1.07,2.1-1.4c0.73-0.3,1.52-0.47,2.36-0.49C30.87,67.85,30.91,67.85,30.96,67.85L30.96,67.85L30.96,67.85z M98.41,90.27v17.37v0c0,0.04,0,0.08-0.01,0.12c-0.02,0.83-0.19,1.63-0.49,2.36c-0.33,0.79-0.81,1.51-1.41,2.11 c-0.59,0.59-1.31,1.07-2.1,1.4c-0.73,0.3-1.52,0.47-2.35,0.49c-0.04,0.01-0.08,0.01-0.12,0.01h0H30.96h0 c-0.04,0-0.08-0.01-0.12-0.01c-0.83-0.02-1.62-0.19-2.35-0.49c-0.79-0.33-1.5-0.81-2.1-1.4c-0.6-0.6-1.08-1.31-1.41-2.11 c-0.3-0.73-0.47-1.52-0.49-2.35c-0.01-0.04-0.01-0.08-0.01-0.12v0V90.27H11.31h0c-0.04,0-0.08,0-0.12-0.01 c-1.49-0.02-2.91-0.32-4.2-0.85c-1.39-0.57-2.63-1.41-3.67-2.45c-1.04-1.04-1.88-2.28-2.45-3.67c-0.54-1.3-0.84-2.71-0.85-4.2 C0,79.04,0,79,0,78.96v0V43.55v0c0-0.04,0-0.08,0.01-0.12c0.02-1.49,0.32-2.9,0.85-4.2c0.57-1.39,1.41-2.63,2.45-3.67 c1.04-1.04,2.28-1.88,3.67-2.45c1.3-0.54,2.71-0.84,4.2-0.85c0.04-0.01,0.08-0.01,0.12-0.01h0h100.25h0c0.04,0,0.08,0,0.12,0.01 c1.49,0.02,2.91,0.32,4.2,0.85c1.39,0.57,2.63,1.41,3.67,2.45c1.04,1.04,1.88,2.28,2.45,3.67c0.54,1.3,0.84,2.71,0.85,4.2 c0.01,0.04,0.01,0.08,0.01,0.12v0v35.41v0c0,0.04,0,0.08-0.01,0.12c-0.02,1.49-0.32,2.9-0.85,4.2c-0.57,1.39-1.41,2.63-2.45,3.67 c-1.04,1.04-2.28,1.88-3.67,2.45c-1.3,0.54-2.71,0.84-4.2,0.85c-0.04,0.01-0.08,0.01-0.12,0.01h0H98.41L98.41,90.27z M89.47,15.86 l-7-6.91v6.91H89.47L89.47,15.86z M91.72,74.54H31.16v32.89h60.56V74.54L91.72,74.54z"/>
                                        </g>
                                    </svg>
                                </a>
                                <!-- <a href="index.php?page=builder/kelurahan/edit&kecamatan=<?=$data['KD_KECAMATAN']?>&kelurahan=<?=$data['KD_KELURAHAN']?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <a href="index.php?action=builder/kelurahan/delete&kecamatan=<?=$data['KD_KECAMATAN']?>&kelurahan=<?=$data['KD_KELURAHAN']?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" onclick="if(confirm('Apakah anda yakin menghapus data ini')){return true}else{return false}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a> -->
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
<?php load('builder/partials/bottom') ?>
