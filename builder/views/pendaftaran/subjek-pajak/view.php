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

    <?php if($data['reg_note']): ?>
        <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-6" role="alert">
            <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div class="flex items-center">
                <p class="font-bold m-0">Alasan Penolakan : <?=$data['reg_note']?></p>
                </div>
            </div>
        </div>
    <?php endif ?>

    <a href="index.php?page=builder/pendaftaran/subjek-pajak/index" class="p-2 bg-green-500 text-white rounded">Kembali</a>

    <?php $span_status = ['MENUNGGU'=>'yellow','DITERIMA'=>'blue','DITOLAK'=>'red']; ?>
    <span class="p-2 bg-<?=$span_status[$data['reg_status']]?>-500 text-white rounded">STATUS : <?=$data['reg_status']?></span>

    <?php if($data['reg_status'] == 'MENUNGGU'): ?>
    <a href="index.php?page=builder/pendaftaran/subjek-pajak/view&act=accept&code=<?=$_GET['code']?>" class="p-2 bg-blue-500 text-white rounded" onclick="if(confirm('Apakah anda yakin menerima pendaftaran ini ?')){return true}else{return false}">TERIMA</a>
    <a href="index.php?page=builder/pendaftaran/subjek-pajak/view&act=reject&code=<?=$_GET['code']?>" class="p-2 bg-red-500 text-white rounded" onclick="tolak(this)">TOLAK</a>
    <?php endif ?>

    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white shadow-md rounded my-6 p-8">
            <div class="flex justify-between">
                <p>NIK</p>
                
                <b><?= $data['NIK'] ? $data['NIK'] : "-"?></b>
            </div>

            <div class="flex justify-between">
                <p>Kelurahan</p>
                
                <b><?= $data['KELURAHAN_WP'] ? $data['KELURAHAN_WP'] : "-"?></b>
            </div>
            
            <div class="flex justify-between">
                <p>Blok</p>
                
                <b><?= $data['BLOK_KAV_NO_WP'] ? $data['BLOK_KAV_NO_WP'] : "-"?></b>
            </div>

            <div class="flex justify-between">
                <p>Nama</p>
                
                <b><?= $data['NM_WP'] ? $data['NM_WP'] : "-"?></b>
            </div>

            <div class="flex justify-between">
                <p>Jalan</p>
                
                <b><?= $data['JALAN_WP'] ? $data['JALAN_WP'] : "-"?></b>
            </div>

            <div class="flex justify-between">
                <p>RW</p>
                
                <b><?= $data['RW_WP'] ? $data['RW_WP'] : "-"?></b>
            </div>
        </div>

        <div class="bg-white shadow-md rounded my-6 p-8">
            <div class="flex justify-between">
                <p>RT</p>
                
                <b><?= $data['RT_WP'] ? $data['RT_WP'] : "-"?></b>
            </div>

            <div class="flex justify-between">
                <p>Kota</p>
                
                <b><?= $data['KOTA_WP'] ? $data['KOTA_WP'] : "-"?></b>
            </div>
            
            <div class="flex justify-between">
                <p>Kode Pos</p>
                
                <b><?= $data['KD_POS_WP'] ? $data['KD_POS_WP'] : "-"?></b>
            </div>

            <div class="flex justify-between">
                <p>Telepon</p>
                
                <b><?= $data['TELP_WP'] ? $data['TELP_WP'] : "-"?></b>
            </div>

            <div class="flex justify-between">
                <p>NPWP</p>
                
                <b><?= $data['NPWP'] ? $data['NPWP'] : "-"?></b>
            </div>

            <div class="flex justify-between">
                <p>Status Pekerjaan</p>
                
                <b><?= $data['STATUS_PEKERJAAN_WP'] ? $pekerjaans[$data['STATUS_PEKERJAAN_WP']] : "-"?></b>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded overflow-x-auto p-8">
        <div class="flex justify-start items-center mb-5">
            <h2 class="text-xl mr-3">Detail Objek Pajak</h2>
        </div>

        <?php if(!empty($opBumis)): ?>

        <div class="flex justify-start items-center mb-5">
            <h2 class="text-lg mr-3">Objek Pajak Bumi</h2>
        </div>

        <?php foreach($opBumis as $key => $data): 
            $kecamatan = $qb->select('REF_KECAMATAN')->where('KD_KECAMATAN', $data['KD_KECAMATAN'])->first();
            $kelurahan = $qb->select('REF_KELURAHAN')->where('KD_KELURAHAN', $data['KD_KELURAHAN'])->first();
        ?>
        <table class="min-w-max w-full table-auto">
            <tbody class="text-gray-600 text-sm font-light">
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">NO SPOP</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$data['NO_SPOP']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Tahun</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$data['TAHUN']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Kecamatan</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$data['KD_KECAMATAN']?> - <?=$kecamatan['NM_KECAMATAN']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Kelurahan</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$data['KD_KELURAHAN']?> - <?=$kelurahan['NM_KELURAHAN']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Blok</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$data['KD_BLOK']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ZNT</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$data['KD_ZNT']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">No Urut</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$data['NO_URUT']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Kode</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$data['KODE']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">No Persil</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$data['NO_PERSIL']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Luas</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$data['LUAS_TANAH']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Jenis Bumi</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium">
                                <?php foreach($jenisBumi as $bumi){
                                    echo $data['JNS_BUMI'] == substr($bumi,0,2) ? $bumi : '';
                                }
                                ?>
                            </span>
                        </div>
                    </td>
                </tr>
                
            </tbody>
        </table>

        <div class="flex justify-start items-center my-5">
            <h2 class="text-lg mr-3">Lampiran</h2>
        </div>
        
        <table class="min-w-max w-full table-auto">
            <tbody class="text-gray-600 text-sm font-light">
            <tr class="text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">KTP</th>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <a href="<?=get_file_storage('ktp/'.$data['KTP'])?>" class="font-medium p-2 bg-green-500 text-white rounded" target="_blank">Lihat</a>
                    </div>
                </td>
            </tr>
            <tr class="text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">FOTO OBJEK</th>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <a href="<?=get_file_storage('foto-objek/'.$data['FOTO_OBJEK'])?>" class="font-medium p-2 bg-green-500 text-white rounded" target="_blank">Lihat</a>
                    </div>
                </td>
            </tr>
            <tr class="text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">SURAT TANAH</th>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <a href="<?=get_file_storage('surat-tanah/'.$data['SURAT_TANAH'])?>" class="font-medium p-2 bg-green-500 text-white rounded" target="_blank">Lihat</a></li>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <?php endforeach ?>

        <?php endif ?>

        <?php if(!empty($opBangunans)): ?>
            
        <div class="flex justify-start items-center my-5">
            <h2 class="text-lg mr-3">Objek Pajak Bangunan</h2>
        </div>

        <?php foreach($opBangunans as $key => $data): 
            $NOP = explode(".", $data['NOP']);
            $BLOK = explode("-", $NOP[4]);
            $kecamatan = $qb->select('REF_KECAMATAN')->where('KD_KECAMATAN', $NOP[2])->first();
            $kelurahan = $qb->select('REF_KELURAHAN')->where('KD_KELURAHAN', $NOP[3])->first();
        ?>
        <table class="min-w-max w-full table-auto">
            <tbody class="text-gray-600 text-sm font-light">
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">NOP</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$data['NOP']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Kecamatan</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$kecamatan['KD_KECAMATAN']?> - <?=$kecamatan['NM_KECAMATAN']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Kelurahan</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$kelurahan['KD_KELURAHAN']?> - <?=$kelurahan['NM_KELURAHAN']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Blok</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$BLOK[0]?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">No Urut</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$BLOK[1]?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Jenis OP</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$NOP[5]?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">No Bangunan</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$data['NO_BNG']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">No Formulir LSPOP</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$data['NO_FORMULIR_LSPOP']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Tahun Dibangun</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$data['THN_DIBANGUN_BNG']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Tahun Renovasi</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$data['THN_RENOVASI_BNG']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Luas</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$data['LUAS_BNG']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Jumlah Lantai</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium"><?=$data['JML_LANTAI_BNG']?></span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Kondisi</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium">
                                <?php foreach($kondisi as $k){
                                    echo $data['KONDISI_BNG'] == substr($k,0,2) ? $k : '';
                                }?>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Jenis Konstruksi</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium">
                                <?php foreach($konstruksi as $k){
                                    echo $data['JNS_KONSTRUKSI_BNG'] == substr($k,0,2) ? $k : '';
                                }?>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Jenis Atap</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium">
                                <?php foreach($atap as $k){
                                    echo $data['JNS_ATAP_BNG'] == substr($k,0,2) ? $k : '';
                                }?>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Kode Dinding</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium">
                                <?php foreach($dinding as $k){
                                    echo $data['KD_DINDING'] == substr($k,0,2) ? $k : '';
                                }?>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Kode Lantai</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium">
                                <?php foreach($lantai as $k){
                                    echo $data['KD_LANTAI'] == substr($k,0,2) ? $k : '';
                                }?>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr class="text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Kode Langit-Langit</th>
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="font-medium">
                                <?php foreach($langit as $k){
                                    echo $data['KD_LANGIT_LANGIT'] == substr($k,0,2) ? $k : '';
                                }?>
                            </span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="flex justify-start items-center my-5">
            <h2 class="text-lg mr-3">Lampiran</h2>
        </div>
        
        <table class="min-w-max w-full table-auto">
            <tbody class="text-gray-600 text-sm font-light">
            <tr class="text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">KTP</th>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <a href="<?=get_file_storage('ktp/'.$data['KTP'])?>" class="font-medium p-2 bg-green-500 text-white rounded" target="_blank">Lihat</a>
                    </div>
                </td>
            </tr>
            <tr class="text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">FOTO OBJEK</th>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <a href="<?=get_file_storage('foto-objek/'.$data['FOTO_OBJEK'])?>" class="font-medium p-2 bg-green-500 text-white rounded" target="_blank">Lihat</a>
                    </div>
                </td>
            </tr>
            <tr class="text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">SURAT TANAH</th>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <a href="<?=get_file_storage('surat-tanah/'.$data['SURAT_TANAH'])?>" class="font-medium p-2 bg-green-500 text-white rounded" target="_blank">Lihat</a></li>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <?php endforeach ?>
        <?php endif ?>
    </div>
</div>

<script>
function tolak(el)
{
    event.preventDefault()
    var reason = prompt('Masukkan Alasan Penolakan')
    if(reason)
    {
        location=el.href+'&reason='+reason
    }
}
</script>

<?php load('builder/partials/bottom') ?>
