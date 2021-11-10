<?php load('builder/partials/top');
?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">DBKB Fasilitas</h2>
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
        <div class="flex justify-between items-center">
            <!-- <a href="index.php?page=builder/roles/create" class="p-2 bg-green-500 text-white rounded inline-block">+ Add New</a> -->

            <div>
                <form action="" method="get" class="inline-block">

                    <input type="hidden" name="page" value="<?=$_GET['page']?>">

                    <div class="form-group inline-block">
                        <select class="p-2 w-full border rounded" name="year" id="">
                            <option value="" selected readonly>- Pilih Tahun -</option>
                            <?php foreach($years as $Y):?>
                                <option <?= (isset($year) && $year == $Y) ? "selected" : ""?> value="<?=$Y?>"><?=$Y?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group inline-block">
                        <select class="p-2 w-full border rounded" name="fasilitas" id="">
                            <option value="" readonly>- Pilih Fasilitas -</option>
                            <option <?= (isset($_GET['fasilitas']) && $_GET['fasilitas'] == 'k1') ? "selected" : ""?> value="k1" selected>K1</option>
                            <option <?= (isset($_GET['fasilitas']) && $_GET['fasilitas'] == 'k2') ? "selected" : ""?> value="k2">K2</option>
                            <option <?= (isset($_GET['fasilitas']) && $_GET['fasilitas'] == 'k3') ? "selected" : ""?> value="k3">K3</option>
                        </select>
                    </div>

                    <div class="form-group inline-block">
                        <input type="text" class="p-2 w-full border rounded" placeholder="Cari.." name="dbkb" value="<?=isset($_GET['dbkb']) && $_GET['dbkb'] ? $_GET['dbkb'] : '' ?>">
                    </div>

                    <div class="form-group inline-block">
                        <button class="p-2 bg-green-500 text-white rounded" name="filter">Filter</button>
                    </div>

                </form>
                
                <div class="form-group inline-block">
                    <button class="p-2 bg-purple-700 text-white rounded" id="btn-submit" onclick="update.submit()">Save</button>
                </div>
                
            </div>
        </div>
        <form class="bg-white shadow-md rounded my-3 overflow-x-auto" method="post" name="update">
            <table class="min-w-max w-full table-auto">
                <tbody class="text-gray-600 text-sm font-light">
                    <?php if(empty($datas)): ?>
                    <tr>
                        <td colspan="3" class="py-3 px-6 text-center font-semibold"><i>Empty</i></td>
                    </tr>
                    <?php else: ?>
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">No</th>
                            <th class="py-3 px-6 text-left">Kode Fasilitas</th>

                            <?php if(isset($_GET['fasilitas']) && $_GET['fasilitas'] == 'k2'):?>
                                <th class="py-3 px-6 text-left">Kode JPB</th>
                                <th class="py-3 px-6 text-left">Kelas</th>
                            <?php endif?>

                            <th class="py-3 px-6 text-left">Nama</th>
                            
                            <?php if(isset($_GET['fasilitas']) && $_GET['fasilitas'] == 'k3'):?>
                                <th class="py-3 px-6 text-left">Kelas Dep Min</th>
                                <th class="py-3 px-6 text-left">Kelas Dep Max</th>
                            <?php endif?>

                            <th class="py-3 px-6 text-left">Satuan</th>
                            <th class="py-3 px-6 text-left">Harga Lama</th>
                            <th class="py-3 px-6 text-left">Harga Baru</th>
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

                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['KD_FASILITAS']?></span>
                            </div>
                        </td>

                        <?php if(isset($_GET['fasilitas']) && $_GET['fasilitas'] == 'k2'):?>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium"><?=$data['KD_JPB']?></span>
                                </div>
                            </td>

                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium"><?=$data['KLS_BINTANG']?></span>
                                </div>
                            </td>
                        <?php endif ?>

                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NM_FASILITAS']?></span>
                            </div>
                        </td>

                        <?php if(isset($_GET['fasilitas']) && $_GET['fasilitas'] == 'k3'):?>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium"><?=$data['KLS_DEP_MIN']?></span>
                                </div>
                            </td>

                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium"><?=$data['KLS_DEP_MAX']?></span>
                                </div>
                            </td>
                        <?php endif ?>
                        
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['SATUAN_FASILITAS']?></span>
                            </div>
                        </td>

                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=number_format($data['NILAI_NON_DEP'] ?? $data['NILAI_FASILITAS_KLS_BINTANG'] ?? $data['NILAI_DEP_MIN_MAX'],2)?></span>
                            </div>
                        </td>

                        
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="form-group inline-block">
                                <input type="text" class="p-2 w-full border rounded" placeholder="Harga Baru" name="HARGA_BARU[<?=$data['KD_FASILITAS']?><?=isset($data['KD_JPB']) ? '-'.$data['KD_JPB'] : ''?><?=isset($data['KLS_DEP_MIN']) ? '-'.$data['KLS_DEP_MIN'] : ''?><?=isset($data['KLS_DEP_MAX']) ? '-'.$data['KLS_DEP_MAX'] : ''?>]">
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
                                <!-- <a href="index.php?page=builder/roles/edit&roles=<?=$data['KD_WEWENANG']?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a> -->
                                <a href="index.php?action=builder/dbkb-fasilitas/delete&year=<?=$_GET['year'] ?? $year?>&fasilitas=<?=$_GET['fasilitas'] ?? 'k1'?>&dbkb=<?=$data['KD_FASILITAS']?><?=isset($data['KD_JPB']) ? '-'.$data['KD_JPB'] : ''?><?=isset($data['KLS_DEP_MIN']) ? '-'.$data['KLS_DEP_MIN'] : ''?><?=isset($data['KLS_DEP_MAX']) ? '-'.$data['KLS_DEP_MAX'] : ''?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" onclick="if(confirm('Apakah anda yakin menghapus data ini')){return true}else{return false}">
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
        </form>
    </div>
</div>
<?php load('builder/partials/bottom') ?>
