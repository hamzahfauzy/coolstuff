<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-2xl">Add Objek Pajak Bangunan : <?=$subjekPajak['NM_WP']?></h2>

    <?php if($old): ?>
        <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-6" role="alert">
            <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div class="flex items-center">
                <p class="font-bold m-0">NOP Sudah Terdaftar</p>
                </div>
            </div>
        </div>
    <?php endif ?>

    <!-- <div class="bg-white shadow-md rounded my-6 p-8"> -->
        <form id="login-form" action="index.php?page=<?=$_GET['page']?>&id=<?=$_GET['id']?>" method="post" enctype="multipart/form-data">

        <div class="bg-white shadow-md rounded my-6 p-8">

            <div class="form-group mb-2">
                <label>NOP</label>
                <input type="text" class="p-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
            </div>
            <!-- <div class="form-group mb-2">
                <label>Kecamatan</label>
                <select name="KD_KECAMATAN" class="p-2 w-full border rounded" onchange="kecamatanChange(this)">
                    <option value="" selected readonly>- Pilih Kecamatan -</option>
                    <?php foreach($kecamatans as $kecamatan):?>
                        <option <?=isset($old) && $old['KD_KECAMATAN'] && $old['KD_KECAMATAN'] == $kecamatan["KD_KECAMATAN"] ? 'selected'  : ''?> value="<?=$kecamatan['KD_KECAMATAN']?>"><?=$kecamatan['KD_KECAMATAN']." - ".$kecamatan['NM_KECAMATAN']?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2 <?=isset($old) && $old["KD_KELURAHAN"] ? '' : 'hidden'?>" id="kelurahan">
                <label>Kelurahan</label>
                <select name="KD_KELURAHAN" class="p-2 w-full border rounded" onchange="kelurahanChange(this)">
                    <option value="" selected readonly>- Pilih Kelurahan -</option>
                    <?php foreach($kelurahans as $kelurahan):?>
                        <option <?=isset($old) && $old['KD_KELURAHAN'] && $old['KD_KELURAHAN'] == $kelurahan["KD_KELURAHAN"] ? 'selected'  : ''?> value="<?=$kelurahan['KD_KELURAHAN']?>"><?=$kelurahan['KD_KELURAHAN']." - ".$kelurahan['NM_KELURAHAN']?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2 <?=isset($old) && $old["KD_BLOK"] ? '' : 'hidden'?>" id="blok">
                <label>Blok</label>
                <select name="KD_BLOK" class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih Kecamatan -</option>
                    <?php foreach($bloks as $blok):?>
                        <option <?=isset($old) && $old['KD_BLOK'] && $old['KD_BLOK'] == $blok["KD_BLOK"] ? 'selected'  : ''?> value="<?=$blok['KD_BLOK']?>"><?=$blok['KD_BLOK']?></option>
                    <?php endforeach ?>
                </select>
            </div> -->
            <div class="form-group mb-2">
                <label>Jenis Pajak Bangunan</label>
                <select name="KD_JPB" class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih Jenis Pajak Bangunan -</option>
                    <?php foreach($jpbs as $jpb):?>
                        <option <?=isset($old) && $old['KD_JPB'] && $old['KD_JPB'] == $jpb["KD_JPB"] ? 'selected'  : ''?> value="<?=$jpb['KD_JPB']?>"><?=$jpb['KD_JPB']." - ".$jpb['NM_JPB']?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2">
                <label>Kondisi</label>
                <select name="KONDISI_BNG" class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih Kondisi -</option>
                    <?php foreach($kondisis as $kondisi):?>
                        <option <?=isset($old) && $old['KONDISI_BNG'] && $old['KONDISI_BNG'] == substr($kondisi,0,2) ? 'selected'  : ''?> value="<?=substr($kondisi,1,1)?>"><?=$kondisi?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2">
                <label>Jenis Konstruksi</label>
                <select name="JNS_KONSTRUKSI_BNG" class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih Jenis Konstruksi -</option>
                    <?php foreach($konstruksis as $konstruksi):?>
                        <option <?=isset($old) && $old['JNS_KONSTRUKSI_BNG'] && $old['JNS_KONSTRUKSI_BNG'] == substr($konstruksi,0,2) ? 'selected'  : ''?> value="<?=substr($konstruksi,1,1)?>"><?=$konstruksi?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2">
                <label>Jenis Atap</label>
                <select name="JNS_ATAP_BNG" class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih Jenis Atap -</option>
                    <?php foreach($ataps as $atap):?>
                        <option <?=isset($old) && $old['JNS_ATAP_BNG'] && $old['JNS_ATAP_BNG'] == substr($atap,0,2) ? 'selected'  : ''?> value="<?=substr($atap,1,1)?>"><?=$atap?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2">
                <label>Dinding</label>
                <select name="KD_DINDING" class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih Dinding -</option>
                    <?php foreach($dindings as $dinding):?>
                        <option <?=isset($old) && $old['KD_DINDING'] && $old['KD_DINDING'] == substr($dinding,0,2) ? 'selected'  : ''?> value="<?=substr($dinding,1,1)?>"><?=$dinding?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2">
                <label>Lantai</label>
                <select name="KD_LANTAI" class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih Lantai -</option>
                    <?php foreach($lantais as $lantai):?>
                        <option <?=isset($old) && $old['KD_LANTAI'] && $old['KD_LANTAI'] == substr($lantai,0,2) ? 'selected'  : ''?> value="<?=substr($lantai,1,1)?>"><?=$lantai?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2">
                <label>Langit - Langit</label>
                <select name="KD_LANGIT_LANGIT" class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih Langit - Langit -</option>
                    <?php foreach($langits as $langit):?>
                        <option <?=isset($old) && $old['KD_LANGIT_LANGIT'] && $old['KD_LANGIT_LANGIT'] == substr($langit,0,2) ? 'selected'  : ''?> value="<?=substr($langit,1,1)?>"><?=$langit?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <?php 
            foreach($fields as $key => $val): 
                $label = str_replace("_"," ",$val['column_name']);
                $label = str_replace("KD","KODE",$label);
                $label = str_replace("NM","NAMA",$label);
                $label = str_replace("JNS","JENIS",$label);
            ?>
            <div class="form-group mb-2">
                <label><?=ucwords($label)?></label>
                <?php 

                if(isset($old) && $old[$val['column_name']]){
                    echo Form::input($val['data_type'], $val['column_name'], ['class'=>"p-2 w-full border rounded","value"=>$old[$val['column_name']],"placeholder"=>$label,'maxlength'=>$val['character_maximum_length']]);
                }else{
                    echo Form::input($val['data_type'], $val['column_name'], ['class'=>"p-2 w-full border rounded","placeholder"=>$label,'maxlength'=>$val['character_maximum_length']]);
                }
                
                
                ?>
            </div>
            <?php endforeach ?>

        </div>

        <div class="bg-white shadow-md rounded my-6 p-8">

            <h2 class="text-lg mb-10 text-center font-bold">Nomor Formulir</h2>

            <div class="grid grid-cols-3 gap-4">
                <div class="form-group mb-2">
                    <label>NOP</label>
                    <input type="text" class="p-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                </div>

                <div class="form-group mb-2">
                    <label>NO LSPOP</label>
                    <input type="text" class="p-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                </div>

                <div class="form-group mb-2">
                    <label>Tahun Pajak</label>
                    <select name="THN_PAJAK" class="p-2 w-full border rounded">
                        <option value="" selected readonly>- Pilih Tahun -</option>
                        <?php foreach($years as $year):?>
                            <option <?=isset($old) && $old['THN_PAJAK'] && $old['THN_PAJAK'] == $year ? 'selected'  : ''?> value="<?=$year?>"><?=$year?></option>
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
                            <input type="text" class="p-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                        </div>
        
                        <div class="form-group mb-2">
                            <label>Jumlah Lantai</label>
                            <input type="text" class="p-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                        </div>
        
                        <div class="form-group mb-2">
                            <label>Luas (M2)</label>
                            <input type="text" class="p-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                        </div>
                    </div>
                
                    <div class="form-group mb-2">
                        <label>Jenis Pajak Bangunan</label>
                        <select name="KD_JPB" class="p-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Jenis Pajak Bangunan -</option>
                            <?php foreach($jpbs as $jpb):?>
                                <option <?=isset($old) && $old['KD_JPB'] && $old['KD_JPB'] == $jpb["KD_JPB"] ? 'selected'  : ''?> value="<?=$jpb['KD_JPB']?>"><?=$jpb['KD_JPB']." - ".$jpb['NM_JPB']?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
            
                        <div class="form-group mb-2">
                            <label>Tahun Dibangun</label>
                            <select name="THN_DIBANGUN_BNG" class="p-2 w-full border rounded">
                                <option value="" selected readonly>- Pilih Tahun -</option>
                                <?php foreach($years as $year):?>
                                    <option <?=isset($old) && $old['THN_DIBANGUN_BNG'] && $old['THN_DIBANGUN_BNG'] == $year ? 'selected'  : ''?> value="<?=$year?>"><?=$year?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
        
                        <div class="form-group mb-2">
                            <label>Tahun Renovasi</label>
                            <select name="THN_RENOVASI_BNG" class="p-2 w-full border rounded">
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
                            <select name="KONDISI_BNG" class="p-2 w-full border rounded">
                                <option value="" selected readonly>- Pilih Kondisi -</option>
                                <?php foreach($kondisis as $kondisi):?>
                                    <option <?=isset($old) && $old['KONDISI_BNG'] && $old['KONDISI_BNG'] == substr($kondisi,0,2) ? 'selected'  : ''?> value="<?=substr($kondisi,1,1)?>"><?=$kondisi?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>Jenis Konstruksi</label>
                            <select name="JNS_KONSTRUKSI_BNG" class="p-2 w-full border rounded">
                                <option value="" selected readonly>- Pilih Jenis Konstruksi -</option>
                                <?php foreach($konstruksis as $konstruksi):?>
                                    <option <?=isset($old) && $old['JNS_KONSTRUKSI_BNG'] && $old['JNS_KONSTRUKSI_BNG'] == substr($konstruksi,0,2) ? 'selected'  : ''?> value="<?=substr($konstruksi,1,1)?>"><?=$konstruksi?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                    </div>

                </div>

                <div>
    
                    <div class="form-group mb-2">
                        <label>Jenis Atap</label>
                        <select name="JNS_ATAP_BNG" class="p-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Jenis Atap -</option>
                            <?php foreach($ataps as $atap):?>
                                <option <?=isset($old) && $old['JNS_ATAP_BNG'] && $old['JNS_ATAP_BNG'] == substr($atap,0,2) ? 'selected'  : ''?> value="<?=substr($atap,1,1)?>"><?=$atap?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Dinding</label>
                        <select name="KD_DINDING" class="p-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Dinding -</option>
                            <?php foreach($dindings as $dinding):?>
                                <option <?=isset($old) && $old['KD_DINDING'] && $old['KD_DINDING'] == substr($dinding,0,2) ? 'selected'  : ''?> value="<?=substr($dinding,1,1)?>"><?=$dinding?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Lantai</label>
                        <select name="KD_LANTAI" class="p-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Lantai -</option>
                            <?php foreach($lantais as $lantai):?>
                                <option <?=isset($old) && $old['KD_LANTAI'] && $old['KD_LANTAI'] == substr($lantai,0,2) ? 'selected'  : ''?> value="<?=substr($lantai,1,1)?>"><?=$lantai?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Langit - Langit</label>
                        <select name="KD_LANGIT_LANGIT" class="p-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Langit - Langit -</option>
                            <?php foreach($langits as $langit):?>
                                <option <?=isset($old) && $old['KD_LANGIT_LANGIT'] && $old['KD_LANGIT_LANGIT'] == substr($langit,0,2) ? 'selected'  : ''?> value="<?=substr($langit,1,1)?>"><?=$langit?></option>
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
                    <label>Listrik dan AC</label>
                    <input type="text" placeholder="Daya listrik (watt)" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                    <input type="text" placeholder="Jumlah AC Split" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                    <input type="text" placeholder="Jumlah AC Window" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                    <input type="text" placeholder="AC Central" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                </div>

                <div class="form-group mb-2">
                    <label>Luas Perkerasan Halaman (M2)</label>
                    <input type="text" placeholder="Ringan" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                    <input type="text" placeholder="Sedang" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                    <input type="text" placeholder="Berat" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                    <input type="text" placeholder="Penutup Lantai" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                </div>

                <div class="form-group mb-2">
                    <label>Jumlah Lapangan Tennis</label>

                    <div class="grid grid-cols-2 mt-6 gap-4">
                        <div class="form-group">
                            <label>Dengan Lampu</label>
                            <input type="text" placeholder="Beton" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                            <input type="text" placeholder="Aspal" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                            <input type="text" placeholder="Tanah/Rumput" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                        </div>
                        <div class="form-group">
                            <label>Tanpa Lampu</label>
                            <input type="text" placeholder="Beton" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                            <input type="text" placeholder="Aspal" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                            <input type="text" placeholder="Tanah/Rumput" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                        </div>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-3 gap-4 mt-4">

                <div class="form-group mb-2">
                    <label>Pagar</label>
                    <input type="text" placeholder="Bahan Pagar" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                    <input type="text" placeholder="Panjang Pagar (M)" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                </div>

                <div class="form-group mb-2">
                    <label>Lebar Tangga Berjalan</label>
                    <input type="text" placeholder="<= 0.80 M" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                    <input type="text" placeholder="> 0.80 M" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                </div>

                <div class="form-group mb-2">
                    <label>Pemadam Kebakaran</label>
                    <input type="text" placeholder="Hydran" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                    <input type="text" placeholder="Springkler" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                    <input type="text" placeholder="Fire Alarm" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                </div>

            </div>

            
            <div class="grid grid-cols-3 gap-4 mt-4">

                <div class="form-group mb-2">
                    <label>Jumlah Lift</label>
                    <input type="text" placeholder="Penumpang" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                    <input type="text" placeholder="Kapsul" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                    <input type="text" placeholder="Barang" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                </div>

                <div class="form-group mb-2">
                    <label>&nbsp;</label>
                    <input type="text"  placeholder="Jumlah Saluran PABX" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                    <input type="text" placeholder="Dalam Sumur Artesis" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                    <input type="text"  placeholder="Kapasitas Genset" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                </div>

                <div class="form-group mb-2">
                    <label>Kolam Renang</label>
                    <input type="text" placeholder="Finishing Kolam" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                    <input type="text"  placeholder="Luas (M2)" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                </div>

            </div>

        </div>

        <div class="bg-white shadow-md rounded my-6 p-8">

            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" id="btn-login">Insert</button>
            </div>

        </div>

        </form>
    <!-- </div> -->
</div>

<script>

    function kecamatanChange(el){
        fetch("index.php?page=builder/subjek-pajak/objek-pajak-bangunan/index&filter-kecamatan="+el.value).then(response => response.json()).then(data => {

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

        fetch("index.php?page=builder/subjek-pajak/objek-pajak-bangunan/index&filter-kelurahan="+el.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

                var html = `
                        <label>Blok</label>
                        <select name="KD_BLOK" class="p-2 w-full border rounded">
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
