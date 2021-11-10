<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">

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

        <div class="bg-white shadow-md rounded overflow-x-auto p-8">

            <div class="flex justify-start items-center mb-5">
                <h2 class="text-lg mr-3">Objek Pajak Bumi</h2>
                <a href="index.php?page=builder/subjek-pajak/objek-pajak-bumi/create&id=<?=$_GET['id']?>" class="p-2 bg-green-500 text-white rounded">+ Add New</a>
            </div>

            <table class="min-w-max w-full table-auto">
                <tbody class="text-gray-600 text-sm font-light">
                    <?php if(empty($opBumis)): ?>
                    <tr>
                        <td colspan="4" class="py-3 px-6 text-center font-semibold"><i>Empty</i></td>
                    </tr>
                    <?php else: ?>
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">No</th>
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
                            <th class="py-3 px-6 text-left">Action</th>
                        </tr>
                    </thead>
                    <?php foreach($opBumis as $key => $data): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">

                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$key+1?></span>
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
                                    }
                                    print_r($data['JNS_BUMI'])
                                    ?>
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
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <!-- <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div> -->
                                <a href="index.php?page=builder/subjek-pajak/objek-pajak-bumi/edit&id=<?=$_GET['id']?>&kecamatan=<?=$data['KD_KECAMATAN']?>&kelurahan=<?=$data['KD_KELURAHAN']?>&blok=<?=$data['KD_BLOK']?>&znt=<?=$data['KD_ZNT']?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <a href="index.php?action=builder/subjek-pajak/objek-pajak-bumi/delete&id=<?=$_GET['id']?>&kecamatan=<?=$data['KD_KECAMATAN']?>&kelurahan=<?=$data['KD_KELURAHAN']?>&blok=<?=$data['KD_BLOK']?>&znt=<?=$data['KD_ZNT']?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" onclick="if(confirm('Apakah anda yakin menghapus data ini')){return true}else{return false}">
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

        <div class="bg-white shadow-md rounded p-8 overflow-x-auto mt-5">
            
            <div class="flex justify-start items-center mb-5">
                <h2 class="text-lg mr-3">Objek Pajak Bangunan</h2>
                <a href="index.php?page=builder/subjek-pajak/objek-pajak-bangunan/create&id=<?=$_GET['id']?>" class="p-2 bg-green-500 text-white rounded">+ Add New</a>
            </div>

            <table class="min-w-max w-full table-auto">
                <tbody class="text-gray-600 text-sm font-light">
                    <?php if(empty($opBangunans)): ?>
                    <tr>
                        <td colspan="4" class="py-3 px-6 text-center font-semibold"><i>Empty</i></td>
                    </tr>
                    <?php else: ?>
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">No</th>
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
                    <?php foreach($opBangunans as $key => $data): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">

                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$key+1?></span>
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
                                <a href="index.php?page=builder/subjek-pajak/objek-pajak-bangunan/edit&id=<?=$_GET['id']?>&kecamatan=<?=$data['KD_KECAMATAN']?>&kelurahan=<?=$data['KD_KELURAHAN']?>&blok=<?=$data['KD_BLOK']?>&znt=<?=$data['KD_ZNT']?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <a href="index.php?action=builder/subjek-pajak/objek-pajak-bangunan/delete&id=<?=$_GET['id']?>&kecamatan=<?=$data['KD_KECAMATAN']?>&kelurahan=<?=$data['KD_KELURAHAN']?>&blok=<?=$data['KD_BLOK']?>&znt=<?=$data['KD_ZNT']?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" onclick="if(confirm('Apakah anda yakin menghapus data ini')){return true}else{return false}">
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

<?php load('builder/partials/bottom') ?>
