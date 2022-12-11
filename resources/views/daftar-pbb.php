<?php load('partials/landing-top') ?>
<style>
.group {
    margin-bottom:10px;
}
.control-expanded{
    margin:12px 0;
}
label {
    margin:6px 0;
    display:block;
}
.hidden{
    display:none;
}
.shadow-md{
    box-shadow:none;
}
</style>
<main style="padding-bottom:100px;">
    <h2 align="center">Daftar PBB</h2>
    <form id="form_master" action="" method="post">
        <div class="hero-form field" style="margin-left:auto;margin-right:auto;max-width:1000px;">
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
            <div class="control control-expanded">
                <label for="">Status Wajib Pajak</label>
                <select name="status" class="input">
                    <option value="" selected disabled>- Pilih Status -</option>
                    <option value="Baru">Baru</option>
                    <option value="Terdaftar">Terdaftar</option>
                </select>
            </div>
            <div class="control control-expanded hidden">
                <label for="">Jenis Objek Pajak</label>
                <select name="jenis_op" class="input">
                    <option value="-" selected disabled>- Pilih Jenis -</option>
                    <option value="Bangunan">Objek Pajak Bangunan</option>
                    <option value="Bumi">Objek Pajak Bumi</option>
                </select>
            </div>
            <div class="control control-expanded hidden">
                <label for="">ID Wajib Pajak</label>
                <input class="input" type="text" name="ID" placeholder="ID Wajib Pajak">
            </div>
            <div class="control control-expanded hidden">
                <label for="">NOP</label>
                <input class="input" type="text" name="NOP" placeholder="NOP">
            </div>
            <div class="control hidden">
                <button class="button button-primary button-block" name="submit">Lanjutkan</button>
            </div>
        </div>
    </form>

    <form id="form_subjek_pajak" action="" method="post" class="hidden" enctype="multipart/form-data" style="margin-left:auto;margin-right:auto;max-width:1000px;">

        <h3 align="center">Subjek Pajak</h3>

        <div class="form-group mb-2">
            <label>Pekerjaan</label>
            <select name="STATUS_PEKERJAAN_WP" class="p-2 w-full border rounded" required>
                <option value="" selected readonly>- Pilih Pekerjaan -</option>
                <?php foreach($pekerjaans as $key => $pekerjaan):?>
                    <option value="<?=$key?>"><?=$pekerjaan?></option>
                <?php endforeach ?>
            </select>
        </div>

        <?php
        foreach($subjekPajakFields as $key => $val): 
            $label = str_replace("_"," ",$val['column_name']);
            $label = str_replace("KD","KODE",$label);
            $label = str_replace("NM","NAMA",$label);
            $label = str_replace(" WP","",$label);
            $label = str_replace("SUBJEK PAJAK ID", "NIK", $label);
            $val['column_name'] = str_replace("SUBJEK_PAJAK_ID", "NIK", $val['column_name']);
            if (!in_array($label, ['NIK', 'RW', 'RT', 'NPWP'])) {
                $label = ucwords(strtolower($label));
            }
        ?>
        <div class="form-group mb-2">
            <label><?=ucwords($label)?></label>
            <?= Form::input($val['data_type'], $val['column_name'], ['class'=>"p-2 w-full border rounded","placeholder"=>$label,'maxlength'=>$val['character_maximum_length'], 'required'=>true ]) ?>
        </div>
        <?php endforeach ?>

        <div class="form-group hidden">
            <button class="button button-primary button-block">Lanjutkan</button>
        </div>
    </form>

    <form id="form_bumi" action="" method="post" class="hidden" enctype="multipart/form-data" style="margin-left:auto;margin-right:auto;max-width:1000px;">

        <div class="bg-white shadow-md rounded my-6 p-8">

            <h3 align="center">Objek Pajak Bumi</h3>

             <div class="grid grid-cols-2 gap-4">
                    
                <div class="form-group mb-2">
                    <label>No HP</label>
                    <input type="text" class="p-2 mt-2 w-full border rounded" required value="<?=@$_POST['NO_HP']?>" name="NO_HP">
                </div>

                <div class="form-group mb-2">
                    <label>Email</label>
                    <input type="text" class="p-2 mt-2 w-full border rounded" required value="<?=@$_POST['EMAIL']?>" name="EMAIL">
                </div>

            </div>

            <div class="form-group mb-2">
                <label>Tahun</label>
                <select name="TAHUN" class="p-2 mt-2 w-full border rounded" required>
                    <option value="" selected disabled>- Pilih Tahun -</option>
                    <?php foreach($years as $year):?>
                        <option <?=isset($old) && $old['TAHUN'] && $old['TAHUN'] == $year ? 'selected'  : ''?> value="<?=$year?>"><?=$year?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group mb-2">
                <label>Kecamatan</label>
                <select name="KD_KECAMATAN" class="p-2 w-full border rounded" onchange="kecamatanChange(this)" required>
                    <option value="" selected disabled>- Pilih Kecamatan -</option>
                    <?php foreach($kecamatans as $kecamatan):?>
                        <option value="<?=$kecamatan['KD_KECAMATAN']?>"><?=$kecamatan['KD_KECAMATAN']." - ".$kecamatan['NM_KECAMATAN']?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group mb-2" id="kelurahan">
                <label>Kelurahan</label>
                <select name="KD_KELURAHAN" class="p-2 w-full border rounded" onchange="kelurahanChange(this)" required>
                    <option value="" selected disabled>- Pilih Kelurahan -</option>
                </select>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="form-group mb-2" id="blok">
                    <label>Blok</label>
                    <select name="KD_BLOK" class="p-2 w-full border rounded" onchange="blokChange(this)" required>
                        <option value="" selected disabled>- Pilih Blok -</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label>Kode</label>
                    <select name="KODE" class="p-2 w-full border rounded" required>
                        <option value="" selected readonly>- Pilih Kode -</option>
                        <option <?= @$_POST['KODE'] == '0' ? 'selected' : 'selected'?>  value="0">0</option>
                        <option <?= @$_POST['KODE'] == '7' ? 'selected' : ''?> value="7">7</option>
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label>Status WP</label>
                    <select name="STATUS_WP" class="p-2 w-full border rounded" required>
                        <option value="" selected readonly>- Pilih Kode -</option>
                        <option <?= @$_POST['STATUS_WP'] == '1' ? 'selected' : ''?> value="1">1 Pemilik</option>
                        <option <?= @$_POST['STATUS_WP'] == '2' ? 'selected' : ''?> value="2">2 Penyewa</option>
                        <option <?= @$_POST['STATUS_WP'] == '3' ? 'selected' : ''?> value="3">3 Pemakai</option>
                        <option <?= @$_POST['STATUS_WP'] == '4' ? 'selected' : ''?> value="4">4 Pengelola</option>
                        <option <?= @$_POST['STATUS_WP'] == '5' ? 'selected' : ''?> value="5">5 Sengketa</option>
                    </select>
                </div>
            </div>

            <div class="form-group mb-2" style="visibility:hidden;height:0px">
                <label>No Urut</label>
                <input type="text" class="p-2 mt-2 w-full border rounded" value="<?=@$_POST['NO_URUT']?>" name="NO_URUT" required>
            </div>

        </div>

        <div class="bg-white shadow-md rounded my-6 p-8">

            <h2 class="text-lg mb-10 text-center font-bold">Lokasi</h2>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-group mb-2">
                    <label>Jalan</label>
                    <select name="JALAN" class="p-2 w-full border rounded" id="jalan" required onchange="fillZNT(this)">
                        <option value="" selected disabled>- Pilih Jalan -</option>
                    </select>
                </div>

                <div class="form-group mb-2" id="znt">
                    <label>ZNT</label>
                    <input type="text" class="p-2 w-full border rounded" name="KD_ZNT" id="KD_ZNT" readonly>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="form-group mb-2">
                    <label>RW</label>
                    <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=@$_POST['RW']?>" name="RW" required>
                </div>
                <div class="form-group mb-2">
                    <label>RT</label>
                    <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=@$_POST['RT']?>" name="RT" required>
                </div>
                <div class="form-group mb-2">
                    <label>No Persil</label>
                    <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=@$_POST['NO_PERSIL']?>" name="NO_PERSIL" required>
                </div>
            </div>
            
            <div class="form-group mb-2">
                <label>Jenis Objek</label>
                <select name="JNS_BUMI" class="p-2 w-full border rounded" required>
                    <option value="" selected disabled>- Pilih Jenis Bumi -</option>
                    <?php foreach($jenisBumis as $jenisBumi):?>
                        <option <?= @$_POST['JNS_BUMI'] == substr($jenisBumi,1,1) ? 'selected' : ''?> value="<?=substr($jenisBumi,1,1)?>"><?=$jenisBumi?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-group mb-2">
                    <label>Jumlah Bangunan</label>
                    <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=@$_POST['JLH_BNG']?>" name="JLH_BNG" required>
                </div>
                <div class="form-group mb-2">
                    <label>Luas Tanah</label>
                    <input type="number" class="p-2 mt-2 w-full border rounded" value="<?=@$_POST['LUAS_TANAH']?>" name="LUAS_TANAH" required>
                </div>
            </div>

        </div>

        <div class="bg-white shadow-md rounded my-6 p-8">

            <h2 class="text-lg mb-10 text-center font-bold">Lampiran</h2>

            <div class="form-group mb-2">
                <label>KTP</label>
                <input type="file" name="KTP" class="p-2 mt-2 w-full border rounded" required>
            </div>
            
            <div class="form-group mb-2">
                <label>Foto Objek</label>
                <input type="file" name="FOTO_OBJEK" class="p-2 mt-2 w-full border rounded" required>
            </div>
            
            <div class="form-group mb-2">
                <label>Surat Tanah</label>
                <input type="file" name="SURAT_TANAH" class="p-2 mt-2 w-full border rounded" required>
            </div>

        </div>
        
        <div class="bg-white shadow-md rounded my-6 p-8">

            <div class="form-group mb-2">
                <label>Keterangan</label>
                <input type="text" value="<?=@$_POST['KETERANGAN']?>" class="p-2 mt-2 w-full border rounded" name="KETERANGAN" required>
            </div>

            <div class="form-group">
                <button class="button button-primary button-block" name="submit">Submit</button>
            </div>

        </div>

    </form>

    <form id="form_bangunan" action="" method="post" class="hidden" enctype="multipart/form-data" style="margin-left:auto;margin-right:auto;max-width:1000px;">

        <div class="bg-white shadow-md rounded my-6 p-8">

            <h3 align="center">Objek Pajak Bangunan</h3>

            <div class="grid grid-cols-2 gap-4">
                    
                <div class="form-group mb-2">
                    <label>No HP</label>
                    <input type="text" class="p-2 mt-2 w-full border rounded" required value="<?=@$_POST['NO_HP']?>" name="NO_HP">
                </div>

                <div class="form-group mb-2">
                    <label>Email</label>
                    <input type="text" class="p-2 mt-2 w-full border rounded" required value="<?=@$_POST['EMAIL']?>" name="EMAIL">
                </div>

            </div>

            <div class="grid grid-cols-2 gap-4">

                <div class="form-group mb-2">
                    <label>NO LSPOP</label>
                    <input type="text" required class="p-2 mt-2 w-full border rounded" value="<?=@$_POST["NO_FORMULIR_LSPOP"]?>" name="NO_FORMULIR_LSPOP" required>
                </div>

                <div class="form-group mb-2">
                    <label>Tahun Pajak</label>
                    <select required name="THN_PAJAK" class="p-2 mt-2 w-full border rounded" required>
                        <option value="" selected readonly>- Pilih Tahun -</option>
                        <?php foreach($years as $year):?>
                            <option <?= @$_POST['THN_PAJAK'] == $year ? 'selected'  : ''?> value="<?=$year?>"><?=$year?></option>
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
                            <input required type="text" class="p-2 mt-2 w-full border rounded" value="1" readonly name="NO_BNG" required>
                        </div>
        
                        <div class="form-group mb-2">
                            <label>Jumlah Lantai</label>
                            <input required type="text" class="p-2 mt-2 w-full border rounded" value="<?=@$_POST['JML_LANTAI_BNG']?>" name="JML_LANTAI_BNG" required>
                        </div>
        
                        <div class="form-group mb-2">
                            <label>Luas (M2)</label>
                            <input required type="text" class="p-2 mt-2 w-full border rounded" value="<?=@$_POST['LUAS_BNG']?>" name="LUAS_BNG" required>
                        </div>
                    </div>
                
                    <div class="form-group mb-2">
                        <label>Jenis Pajak Bangunan</label>
                        <select required name="KD_JPB" class="p-2 mt-2 w-full border rounded" required>
                            <option value="" selected readonly>- Pilih Jenis Pajak Bangunan -</option>
                            <?php foreach($jpbs as $jpb):?>
                                <option <?=$jpb['KD_JPB'] == "01" ? "selected" : ''?> value="<?=$jpb['KD_JPB']?>"><?=$jpb['KD_JPB']." - ".$jpb['NM_JPB']?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
            
                        <div class="form-group mb-2">
                            <label>Tahun Dibangun</label>
                            <select required name="THN_DIBANGUN_BNG" class="p-2 mt-2 w-full border rounded" required>
                                <option value="" selected readonly>- Pilih Tahun -</option>
                                <?php foreach($years as $year):?>
                                    <option <?=@$_POST['THN_DIBANGUN_BNG'] == $year ? 'selected'  : ''?> value="<?=$year?>"><?=$year?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
        
                        <div class="form-group mb-2">
                            <label>Tahun Renovasi</label>
                            <select name="THN_RENOVASI_BNG" class="p-2 mt-2 w-full border rounded" required>
                                <option value="" selected readonly>- Pilih Tahun -</option>
                                <?php foreach($years as $year):?>
                                    <option <?=@$_POST['THN_RENOVASI_BNG'] == $year ? 'selected'  : ''?> value="<?=$year?>"><?=$year?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                    </div>  

                    <div class="grid grid-cols-2 gap-4">
    
                        <div class="form-group mb-2">
                            <label>Kondisi Bangunan</label>
                            <select required name="KONDISI_BNG" class="p-2 mt-2 w-full border rounded" required>
                                <option value="" selected readonly>- Pilih Kondisi -</option>
                                <?php foreach($kondisis as $kondisi):?>
                                    <option <?=substr($kondisi,0,2) == "02" ? "selected" : ''?> value="<?=substr($kondisi,0,2)?>"><?=$kondisi?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>Jenis Konstruksi</label>
                            <select required name="JNS_KONSTRUKSI_BNG" class="p-2 mt-2 w-full border rounded" required>
                                <option value="" selected readonly>- Pilih Jenis Konstruksi -</option>
                                <?php foreach($konstruksis as $konstruksi):?>
                                    <option <?=substr($konstruksi,0,2) == "02" ? "selected" : ''?> value="<?=substr($konstruksi,0,2)?>"><?=$konstruksi?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                    </div>

                </div>

                <div>
    
                    <div class="form-group mb-2">
                        <label>Jenis Atap</label>
                        <select required name="JNS_ATAP_BNG" class="p-2 mt-2 w-full border rounded" required>
                            <option value="" selected readonly>- Pilih Jenis Atap -</option>
                            <?php foreach($ataps as $atap):?>
                                <option <?=substr($atap,0,2) == "05" ? "selected" : ''?> value="<?=substr($atap,0,2)?>"><?=$atap?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Dinding</label>
                        <select required name="KD_DINDING" class="p-2 mt-2 w-full border rounded" required>
                            <option value="" selected readonly>- Pilih Dinding -</option>
                            <?php foreach($dindings as $dinding):?>
                                <option <?=substr($dinding,0,2) == "02" ? "selected" : ''?> value="<?=substr($dinding,0,2)?>"><?=$dinding?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Lantai</label>
                        <select required name="KD_LANTAI" class="p-2 mt-2 w-full border rounded" required>
                            <option value="" selected readonly>- Pilih Lantai -</option>
                            <?php foreach($lantais as $lantai):?>
                                <option <?=substr($lantai,0,2) == "05" ? "selected" : ''?> value="<?=substr($lantai,0,2)?>"><?=$lantai?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Langit - Langit</label>
                        <select required name="KD_LANGIT_LANGIT" class="p-2 mt-2 w-full border rounded" required>
                            <option value="" selected readonly>- Pilih Langit - Langit -</option>
                            <?php foreach($langits as $langit):?>
                                <option <?=substr($langit,0,2) == "02" ? "selected" : ''?> value="<?=substr($langit,0,2)?>"><?=$langit?></option>
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
                    <label class="text-lg">Listrik dan AC</label>

                    <div class="form-group my-2">
                        <label for="">Daya listrik (watt)</label>
                        <input type="text" placeholder="Daya listrik (watt)" class="p-2 mt-2 w-full border rounded" value="0" name="L_AC[DAYA_LISTRIK]">
                    </div>

                    <div class="form-group my-2">
                        <label for="">Jumlah AC Split</label>
                        <input type="text" placeholder="Jumlah AC Split" class="p-2 mt-2 w-full border rounded" value="0" name="L_AC[AC_SPLIT]">
                    </div>

                    <div class="form-group my-2">
                        <label for="">Jumlah AC Window</label>
                        <input type="text" placeholder="Jumlah AC Window" class="p-2 mt-2 w-full border rounded" value="0" name="L_AC[AC_WINDOW]">
                    </div>

                    <div class="form-group my-2">
                        <label for="">AC Central</label>

                        <select name="L_AC[AC_CENTRAL]" class="p-2 mt-2 w-full border rounded">
                            <option value="" disabled>- Pilih AC Central -</option>
                            <option value="01">01-Ada</option>
                            <option selected value="02">02-Tidak Ada</option>
                        </select>

                    </div>
                </div>

                <div class="form-group mb-2">
                    <label class="text-lg">Luas Perkerasan Halaman (M2)</label>

                    <div class="form-group my-2">
                        <label for="">Ringan</label>
                        <input type="text" placeholder="Ringan" class="p-2 mt-2 w-full border rounded" value="0" name="LPH[RINGAN]">
                    </div>
                    
                    <div class="form-group my-2">
                        <label for="">Sedang</label>
                        <input type="text" placeholder="Sedang" class="p-2 mt-2 w-full border rounded" value="0" name="LPH[SEDANG]">
                    </div>

                    <div class="form-group my-2">
                        <label for="">Berat</label>
                        <input type="text" placeholder="Berat" class="p-2 mt-2 w-full border rounded" value="0" name="LPH[BERAT]">
                    </div>

                    <div class="form-group my-2">
                        <label for="">Penutup Lantai</label>
                        <input type="text" placeholder="Penutup Lantai" class="p-2 mt-2 w-full border rounded" value="0" name="LPH[P_LANTAI]">
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label class="text-lg">Jumlah Lapangan Tennis</label>

                    <div class="grid grid-cols-2 mt-6 gap-4">
                        <div class="form-group">
                            <label>Dengan Lampu</label>

                            <div class="form-group my-2">
                                <label for="">Beton</label>
                                <input type="text" placeholder="Beton" class="p-2 mt-2 w-full border rounded" value="0" name="JLT_DL[BETON]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Aspal</label>
                                <input type="text" placeholder="Aspal" class="p-2 mt-2 w-full border rounded" value="0" name="JLT_DL[ASPAL]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Tanah/Rumput</label>
                                <input type="text" placeholder="Tanah/Rumput" class="p-2 mt-2 w-full border rounded" value="0" name="JLT_DL[TR]">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tanpa Lampu</label>

                            <div class="form-group my-2">
                                <label for="">Beton</label>
                                <input type="text" placeholder="Beton" class="p-2 mt-2 w-full border rounded" value="0" name="JLT_TL[BETON]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Aspal</label>
                                <input type="text" placeholder="Aspal" class="p-2 mt-2 w-full border rounded" value="0" name="JLT_TL[ASPAL]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Tanah/Rumput</label>
                                <input type="text" placeholder="Tanah/Rumput" class="p-2 mt-2 w-full border rounded" value="0" name="JLT_TL[TR]">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-3 gap-4 mt-4">

                <div class="form-group mb-2">
                    <label class="text-lg">Pagar</label>

                    <div class="form-group my-2">
                        <label for="">Bahan Pagar</label>

                        <select name="PAGAR[BP]" class="p-2 mt-2 w-full border rounded">
                            <option value="" selected disabled>- Pilih Bahan Pagar -</option>
                            <option value="01-Baja/Besi">01-Baja/Besi</option>
                            <option value="02-Bata/Batako">02-Bata/Batako</option>
                        </select>

                    </div>
                    
                    <div class="form-group my-2">
                        <label for="">Panjang Pagar (M)</label>
                        <input type="text" placeholder="Panjang Pagar (M)" class="p-2 mt-2 w-full border rounded" value="0" name="PAGAR[PP]">
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label class="text-lg">Lebar Tangga Berjalan</label>

                    <div class="form-group my-2">
                        <label for=""><= 0.80 M</label>
                        <input type="text" placeholder="<= 0.80 M" class="p-2 mt-2 w-full border rounded" value="0" name="LTB[LT]">
                    </div>

                    <div class="form-group my-2">
                        <label for="">> 0.80 M</label>
                        <input type="text" placeholder="> 0.80 M" class="p-2 mt-2 w-full border rounded" value="0" name="LTB[MT]">
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label class="text-lg">Pemadam Kebakaran</label>

                    <!-- select -->
                    
                    <div class="form-group my-2">
                        <label for="">Hydrant</label>

                        <select name="PK[HYDRAN]" class="p-2 mt-2 w-full border rounded">
                            <option value="" disabled>- Pilih -</option>
                            <option value="01">01-Ada</option>
                            <option selected value="02">02-Tidak Ada</option>
                        </select>

                    </div>

                    <div class="form-group my-2">
                        <label for="">Springkler</label>

                        <select name="PK[SPRINGKLER]" class="p-2 mt-2 w-full border rounded">
                            <option value="" disabled>- Pilih -</option>
                            <option value="01">01-Ada</option>
                            <option selected value="02">02-Tidak Ada</option>
                        </select>

                    </div>

                    <div class="form-group my-2">
                        <label for="">Fire Alarm</label>

                        <select name="PK[FIRE_ALARM]" class="p-2 mt-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih -</option>
                            <option value="01">01-Ada</option>
                            <option selected value="02">02-Tidak Ada</option>
                        </select>

                    </div>

                </div>

            </div>

            
            <div class="grid grid-cols-3 gap-4 mt-4">

                <div class="form-group mb-2">
                    <label class="text-lg">Jumlah Lift</label>

                    <div class="form-group my-2">
                        <label for="">Penumpang</label>
                        <input type="text" placeholder="Penumpang" class="p-2 mt-2 w-full border rounded" value="0" name="J_LIFT[PENUMPANG]">
                    </div>
                    
                    <div class="form-group my-2">
                        <label for="">Kapsul</label>
                        <input type="text" placeholder="Kapsul" class="p-2 mt-2 w-full border rounded" value="0" name="J_LIFT[KAPSUL]">
                    </div>
                    
                    <div class="form-group my-2">
                        <label for="">Barang</label>
                        <input type="text" placeholder="Barang" class="p-2 mt-2 w-full border rounded" value="0" name="J_LIFT[BARANG]">
                    </div>

                </div>

                <div class="form-group mb-2">
                    <label class="text-lg">Others</label>

                    <div class="form-group my-2">
                        <label for="">Jumlah Saluran PABX</label>
                        <input type="text" placeholder="Jumlah Saluran PABX" class="p-2 mt-2 w-full border rounded" value="0" name="OTHERS[JLH_S_PABX]">
                    </div>

                    <div class="form-group my-2">
                        <label for="">Dalam Sumur Artesis</label>
                        <input type="text" placeholder="Dalam Sumur Artesis" class="p-2 mt-2 w-full border rounded" value="0" name="OTHERS[DLM_SUMUR_A]">
                    </div>

                    <div class="form-group my-2">
                        <label for="">Kapasitas Genset</label>
                        <input type="text" placeholder="Kapasitas Genset" class="p-2 mt-2 w-full border rounded" value="0" name="OTHERS[K_GENSET]">
                    </div>

                </div>

                <div class="form-group mb-2">
                    <label class="text-lg">Kolam Renang</label>

                    <!-- select -->

                    <div class="form-group my-2">
                        <label for="">Finishing Kolam</label>

                        <select name="KOLAM_RENANG[F_KOLAM]" class="p-2 mt-2 w-full border rounded">
                            <option value="" selected disabled>- Pilih -</option>
                            <option value="01">01-Displester</option>
                            <option alue="02">02-Dengan Pelapis</option>
                        </select>

                    </div>
                    
                    <div class="form-group my-2">
                        <label for="">Luas (M2)</label>
                        <input type="text" placeholder="Luas (M2)" class="p-2 mt-2 w-full border rounded" value="0" name="KOLAM_RENANG[LUAS]">
                    </div>

                </div>

            </div>

        </div>

        <div class="bg-white shadow-md rounded my-6 p-8">

            <h2 class="text-lg mb-10 text-center font-bold">Lampiran</h2>

            <div class="form-group mb-2">
                <label>KTP</label>
                <input type="file" name="KTP" class="p-2 mt-2 w-full border rounded" required>
            </div>
            
            <div class="form-group mb-2">
                <label>Foto Objek</label>
                <input type="file" name="FOTO_OBJEK" class="p-2 mt-2 w-full border rounded" required>
            </div>
            
            <div class="form-group mb-2">
                <label>Surat Tanah</label>
                <input type="file" name="SURAT_TANAH" class="p-2 mt-2 w-full border rounded" required>
            </div>

        </div>

        <div class="bg-white shadow-md rounded my-6 p-8">

            <div class="grid grid-cols-2 gap-4">
                <div class="form-group mb-2">
                    <label>Keterangan</label>
                    <input required type="text" class="p-2 mt-2 w-full border rounded" name="KETERANGAN" value="<?=@$_POST['KETERANGAN']?>">
                </div>
    
                <div class="form-group mb-2">
                    <label>Nilai Individu</label>
                    <input required type="text" class="p-2 mt-2 w-full border rounded" name="NILAI_INDIVIDU" value="<?=@$_POST['NILAI_INDIVIDU']?>">
                </div>
            </div>

            <div class="form-group">
                <button class="button button-primary button-block" name="submit">Submit</button>
            </div>

        </div>

    </form>

</main>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.serializeJSON/3.2.1/jquery.serializejson.min.js" integrity="sha512-SdWDXwOhhVS/wWMRlwz3wZu3O5e4lm2/vKK3oD0E5slvGFg/swCYyZmts7+6si8WeJYIUsTrT3KZWWCknSopjg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(() => {

        var status = $("[name='status']")
        var jenisOp = $("[name='jenis_op']")
        var nop = $("[name='NOP']")
        var id = $("[name='ID']")

        nop.inputmask({mask:"12.12.999.999.999-9{1,4}.9"})

        var formSubjekPajak = $("#form_subjek_pajak")
        var formBumi = $("#form_bumi")
        var formBangunan = $("#form_bangunan")
        
        var formMaster = $("#form_master")
        var submitMaster = formMaster.find("button")

        var submitSubjekPajak = formSubjekPajak.find("button")
        var submitBumi = formBumi.find("button")
        var submitBangunan = formBangunan.find("button")

        formMaster.on("submit", async function(e) {
            e.preventDefault()

            if (status.val() == "Baru") {
                formSubjekPajak.removeClass('hidden')
                formMaster.addClass('hidden')
                
                if (jenisOp.val() == "Bumi" || (status.val() == "Baru" && jenisOp.val() == "Bangunan")) {

                    if(jenisOp.val() == "Bangunan") {
                        submitBumi.addClass('hidden')
                    } else {
                        submitBumi.removeClass('hidden')
                    }

                    formBumi.removeClass('hidden')
                } else {
                    formBumi.addClass('hidden')
                }

                if (jenisOp.val() == "Bangunan") {
                    formBangunan.removeClass('hidden')
                } else {
                    formBangunan.addClass('hidden')
                }
            
            } else {

                formSubjekPajak.addClass('hidden')

                submitMaster.attr('disabled', true)
                submitMaster.text('Loading...')

                var res = await $.post('<?=url()?>/index.php?page=daftar-pbb&type=terdaftar', formMaster.serializeJSON())
                var response = JSON.parse(res)

                if(response.status == 'success') {

                    swal('Data ditemukan!', 'Silahkan isi formulir', 'success').then(() => {
                        formMaster.addClass('hidden')
                        formSubjekPajak.removeClass('hidden')

                        var data = response.data

                        document.querySelector('input[name=NIK]').value = data.SUBJEK_PAJAK_ID
                        document.querySelector('select[name=STATUS_PEKERJAAN_WP]').value = data.STATUS_PEKERJAAN_WP
                        document.querySelector('input[name=NM_WP]').value = data.NM_WP
                        document.querySelector('input[name=JALAN_WP]').value = data.JALAN_WP
                        document.querySelector('input[name=BLOK_KAV_NO_WP]').value = data.BLOK_KAV_NO_WP
                        document.querySelector('input[name=RW_WP]').value = data.RW_WP
                        document.querySelector('input[name=RT_WP]').value = data.RT_WP
                        document.querySelector('input[name=KELURAHAN_WP]').value = data.KELURAHAN_WP
                        document.querySelector('input[name=KOTA_WP]').value = data.KOTA_WP
                        document.querySelector('input[name=KD_POS_WP]').value = data.KD_POS_WP
                        document.querySelector('input[name=TELP_WP]').value = data.TELP_WP
                        document.querySelector('input[name=NPWP]').value = data.NPWP

                        document.querySelector('input[name=NIK]').setAttribute('readonly','readonly')
                        document.querySelector('select[name=STATUS_PEKERJAAN_WP]').style.pointerEvents = 'none'
                        document.querySelector('input[name=NM_WP]').setAttribute('readonly','readonly')
                        document.querySelector('input[name=JALAN_WP]').setAttribute('type','hidden')
                        document.querySelector('input[name=JALAN_WP]').previousSibling.previousSibling.style.visibility = "hidden"
                        document.querySelector('input[name=JALAN_WP]').previousSibling.previousSibling.style.height = "0px"
                        document.querySelector('input[name=BLOK_KAV_NO_WP]').setAttribute('type','hidden')
                        document.querySelector('input[name=BLOK_KAV_NO_WP]').previousSibling.previousSibling.style.visibility = "hidden"
                        document.querySelector('input[name=BLOK_KAV_NO_WP]').previousSibling.previousSibling.style.height = "0px"
                        document.querySelector('input[name=RW_WP]').setAttribute('type','hidden')
                        document.querySelector('input[name=RW_WP]').previousSibling.previousSibling.style.visibility = "hidden"
                        document.querySelector('input[name=RW_WP]').previousSibling.previousSibling.style.height = "0px"
                        document.querySelector('input[name=RT_WP]').setAttribute('type','hidden')
                        document.querySelector('input[name=RT_WP]').previousSibling.previousSibling.style.visibility = "hidden"
                        document.querySelector('input[name=RT_WP]').previousSibling.previousSibling.style.height = "0px"
                        document.querySelector('input[name=KELURAHAN_WP]').setAttribute('type','hidden')
                        document.querySelector('input[name=KELURAHAN_WP]').previousSibling.previousSibling.style.visibility = "hidden"
                        document.querySelector('input[name=KELURAHAN_WP]').previousSibling.previousSibling.style.height = "0px"
                        document.querySelector('input[name=KOTA_WP]').setAttribute('type','hidden')
                        document.querySelector('input[name=KOTA_WP]').previousSibling.previousSibling.style.visibility = "hidden"
                        document.querySelector('input[name=KOTA_WP]').previousSibling.previousSibling.style.height = "0px"
                        document.querySelector('input[name=KD_POS_WP]').setAttribute('type','hidden')
                        document.querySelector('input[name=KD_POS_WP]').previousSibling.previousSibling.style.visibility = "hidden"
                        document.querySelector('input[name=KD_POS_WP]').previousSibling.previousSibling.style.height = "0px"
                        document.querySelector('input[name=TELP_WP]').setAttribute('type','hidden')
                        document.querySelector('input[name=TELP_WP]').previousSibling.previousSibling.style.visibility = "hidden"
                        document.querySelector('input[name=TELP_WP]').previousSibling.previousSibling.style.height = "0px"
                        document.querySelector('input[name=NPWP]').setAttribute('type','hidden')
                        document.querySelector('input[name=NPWP]').previousSibling.previousSibling.style.visibility = "hidden"
                        document.querySelector('input[name=NPWP]').previousSibling.previousSibling.style.height = "0px"


                        if (jenisOp.val() == "Bumi") {
                            formBumi.removeClass('hidden')
                        } else {
                            formBumi.addClass('hidden')
                        }
        
                        if (jenisOp.val() == "Bangunan") {
                            $('[name=NO_BNG]').val(parseInt(response.data.NO_URUT)+1)
                            formBangunan.removeClass('hidden')
                        } else {
                            formBangunan.addClass('hidden')
                        }
                    })
                    
                } else {
                    swal('Data tidak ditemukan!', response.message, 'error').then(() => {
                        submitMaster.attr('disabled', false)
                        submitMaster.text('Lanjutkan')
                    })
                }
            }
        })

        formSubjekPajak.on("submit", async function(e) {
            e.preventDefault()
        })

        formBumi.on("submit", async function(e) {
            e.preventDefault()

            if(status.val() == "Baru") {

                if(document.forms.form_subjek_pajak.checkValidity()) {
                    submitBumi.attr('disabled', true)
                    submitBumi.text('Loading...')

                    var body = new FormData()
                    var subjekPajakdata = formSubjekPajak.serializeJSON()
                    var bumiData = formBumi.serializeJSON()

                    for(var key in subjekPajakdata){
                        body.append('subjek_pajak['+key+']', subjekPajakdata[key])
                    }

                    for(var key in bumiData){
                        body.append('bumi['+key+']', bumiData[key])
                    }

                    var KTP = formBumi.find('[name=KTP]')[0].files[0]
                    var FOTO_OBJEK = formBumi.find('[name=FOTO_OBJEK]')[0].files[0]
                    var SURAT_TANAH = formBumi.find('[name=SURAT_TANAH]')[0].files[0]

                    if (KTP) {
                        body.append('KTP', KTP)
                    }

                    if (FOTO_OBJEK) {
                        body.append('FOTO_OBJEK', FOTO_OBJEK)
                    }

                    if (SURAT_TANAH) {
                        body.append('SURAT_TANAH', SURAT_TANAH)
                    }

                    body.append('status', status.val())
                    body.append('jenis_op', jenisOp.val())

                    var request = await fetch("<?=url()?>/index.php?page=daftar-pbb&type=bumi",{
                        method:"POST",
                        body: body
                    })

                    var res = await request.json()

                    if(res.status == 'success') { 
                        submitBumi.text('Berhasil')
                        swal('Berhasil Mendaftar!', res.message, 'success').then(() => {
                            location.reload()
                        })
                    } else {
                        submitBumi.text('Gagal')
                        swal('Gagal Mendaftar!', res.message, 'error').then(() => {
                            submitBumi.attr('disabled', false)
                            submitBumi.text('Submit')
                        })

                    }
                } else {
                    submitSubjekPajak.click()
                }


            } else if(status.val() == "Terdaftar") {

                submitBumi.attr('disabled', true)
                submitBumi.text('Loading...')

                var body = new FormData()
                var subjekPajakdata = formSubjekPajak.serializeJSON()
                var bumiData = formBumi.serializeJSON()

                for(var key in subjekPajakdata){
                    body.append('subjek_pajak['+key+']', subjekPajakdata[key])
                }

                for(var key in bumiData){
                    body.append('bumi['+key+']', bumiData[key])
                }

                var KTP = formBumi.find('[name=KTP]')[0].files[0]
                var FOTO_OBJEK = formBumi.find('[name=FOTO_OBJEK]')[0].files[0]
                var SURAT_TANAH = formBumi.find('[name=SURAT_TANAH]')[0].files[0]

                if (KTP) {
                    body.append('KTP', KTP)
                }

                if (FOTO_OBJEK) {
                    body.append('FOTO_OBJEK', FOTO_OBJEK)
                }

                if (SURAT_TANAH) {
                    body.append('SURAT_TANAH', SURAT_TANAH)
                }

                body.append('status', status.val())
                body.append('jenis_op', jenisOp.val())
                body.append('ID', id.val())

                var request = await fetch("<?=url()?>/index.php?page=daftar-pbb&type=bumi",{
                    method:"POST",
                    body: body
                })

                var res = await request.json()

                if(res.status == 'success') { 
                    submitBumi.text('Berhasil')
                    swal('Berhasil Mendaftar!', res.message, 'success').then(() => {
                        location.reload()
                    })
                } else {
                    submitBumi.text('Gagal')
                    swal('Gagal Mendaftar!', res.message, 'error').then(() => {
                        submitBumi.attr('disabled', false)
                        submitBumi.text('Submit')
                    })

                }
            }
            
            
        })

        formBangunan.on("submit", async function(e) {
            e.preventDefault()

            if(status.val() == "Baru") {

                if(document.forms.form_subjek_pajak.checkValidity()) {
                    if(document.forms.form_bumi.checkValidity()) {
                        submitBangunan.attr('disabled', true)
                        submitBangunan.text('Loading...')

                        var body = new FormData()
                        var subjekPajakdata = formSubjekPajak.serializeJSON()
                        var bumiData = formBumi.serializeJSON()
                        var bangunanData = formBangunan.serializeJSON()

                        for(var key in subjekPajakdata){
                            body.append('subjek_pajak['+key+']', subjekPajakdata[key])
                        }

                        for(var key in bumiData){
                            body.append('bumi['+key+']', bumiData[key])
                        }
                        
                        for(var key in bangunanData){
                            if(typeof bangunanData[key] === 'object') {
                                for(var k in bangunanData[key]) {
                                    body.append('bangunan['+key+']['+k+']', bangunanData[key][k])
                                }
                            } else {
                                body.append('bangunan['+key+']', bangunanData[key])
                            }
                        }

                        var KTP = formBangunan.find('[name=KTP]')[0].files[0]
                        var FOTO_OBJEK = formBangunan.find('[name=FOTO_OBJEK]')[0].files[0]
                        var SURAT_TANAH = formBangunan.find('[name=SURAT_TANAH]')[0].files[0]

                        var KTP_BUMI = formBumi.find('[name=KTP]')[0].files[0]
                        var FOTO_OBJEK_BUMI = formBumi.find('[name=FOTO_OBJEK]')[0].files[0]
                        var SURAT_TANAH_BUMI = formBumi.find('[name=SURAT_TANAH]')[0].files[0]

                        if (KTP) {
                            body.append('KTP', KTP)
                        }

                        if (FOTO_OBJEK) {
                            body.append('FOTO_OBJEK', FOTO_OBJEK)
                        }

                        if (SURAT_TANAH) {
                            body.append('SURAT_TANAH', SURAT_TANAH)
                        }

                        if (KTP_BUMI) {
                            body.append('KTP_BUMI', KTP_BUMI)
                        }

                        if (FOTO_OBJEK_BUMI) {
                            body.append('FOTO_OBJEK_BUMI', FOTO_OBJEK_BUMI)
                        }

                        if (SURAT_TANAH_BUMI) {
                            body.append('SURAT_TANAH_BUMI', SURAT_TANAH_BUMI)
                        }

                        body.append('status', status.val())
                        body.append('jenis_op', jenisOp.val())

                        var request = await fetch("<?=url()?>/index.php?page=daftar-pbb&type=bangunan",{
                            method:"POST",
                            body: body
                        })

                        var res = await request.json()

                        if(res.status == 'success') { 
                            submitBangunan.text('Berhasil')
                            swal('Berhasil Mendaftar!', res.message, 'success').then(() => {
                                location.reload()
                            })
                        } else {
                            submitBangunan.text('Gagal')
                            swal('Gagal Mendaftar!', res.message, 'error').then(() => {
                                submitBangunan.attr('disabled', false)
                                submitBangunan.text('Submit')
                            })

                        }
                    } else {
                        submitBumi.click()
                    }
                    
                } else {
                    submitSubjekPajak.click()
                }


            } else if(status.val() == "Terdaftar") {

                submitBangunan.attr('disabled', true)
                submitBangunan.text('Loading...')

                var body = new FormData()
                var subjekPajakdata = formSubjekPajak.serializeJSON()
                var bangunanData = formBangunan.serializeJSON()

                for(var key in subjekPajakdata){
                    body.append('subjek_pajak['+key+']', subjekPajakdata[key])
                }

                for(var key in bangunanData){
                    if(typeof bangunanData[key] === 'object') {
                        for(var k in bangunanData[key]) {
                            body.append('bangunan['+key+']['+k+']', bangunanData[key][k])
                        }
                    } else {
                        body.append('bangunan['+key+']', bangunanData[key])
                    }
                }

                var KTP = formBangunan.find('[name=KTP]')[0].files[0]
                var FOTO_OBJEK = formBangunan.find('[name=FOTO_OBJEK]')[0].files[0]
                var SURAT_TANAH = formBangunan.find('[name=SURAT_TANAH]')[0].files[0]

                if (KTP) {
                    body.append('KTP', KTP)
                }

                if (FOTO_OBJEK) {
                    body.append('FOTO_OBJEK', FOTO_OBJEK)
                }

                if (SURAT_TANAH) {
                    body.append('SURAT_TANAH', SURAT_TANAH)
                }

                body.append('status', status.val())
                body.append('jenis_op', jenisOp.val())
                body.append('NOP', nop.val())

                var request = await fetch("<?=url()?>/index.php?page=daftar-pbb&type=bangunan",{
                    method:"POST",
                    body: body
                })

                var res = await request.json()

                if(res.status == 'success') { 
                    submitBangunan.text('Berhasil')
                    swal('Berhasil Mendaftar!', res.message, 'success').then(() => {
                        location.reload()
                    })
                } else {
                    submitBangunan.text('Gagal')
                    swal('Gagal Mendaftar!', res.message, 'error').then(() => {
                        submitBangunan.attr('disabled', false)
                        submitBangunan.text('Submit')
                    })

                }
            }
        })

        status.change(function(e) {
            var value = e.target.value

            jenisOp.parent().removeClass('hidden')
            if (value == 'Terdaftar') {
                if (jenisOp.val() == 'Bumi') {
                    id.parent().removeClass("hidden")
                    id.attr('required', true)
                    nop.parent().addClass("hidden")
                    nop.attr('required', false)
                } else if (jenisOp.val() == 'Bangunan') {
                    id.parent().addClass("hidden")
                    id.attr('required', false)
                    nop.parent().removeClass("hidden")
                    nop.attr('required', true)
                }
            } else {
                id.parent().addClass('hidden')
                nop.parent().addClass('hidden')
                id.attr('required', false)
                nop.attr('required', false)
            }
        })

        jenisOp.change(function(e) {
            var value = e.target.value

            if (status.val() == 'Terdaftar') {
                if (jenisOp.val() == 'Bumi') {
                    id.parent().removeClass("hidden")
                    id.attr('required', true)
                    nop.parent().addClass("hidden")
                    nop.attr('required', false)
                } else if (jenisOp.val() == 'Bangunan') {
                    id.parent().addClass("hidden")
                    id.attr('required', false)
                    nop.parent().removeClass("hidden")
                    nop.attr('required', true)
                }
            }

            submitMaster.parent().removeClass('hidden')

        })

    })

    function kecamatanChange(el){
        fetch("index.php?page=daftar-pbb&filter-kecamatan="+el.value).then(response => response.json()).then(data => {

                var html = '<option value="-">- Pilih Kelurahan -</option>'

                data.map(dt=>{
                    html += `<option value="${dt.KD_KELURAHAN}">${dt.KD_KELURAHAN} - ${dt.NM_KELURAHAN}</option>`
                })

                var kelurahan = document.querySelector("#kelurahan")

                kelurahan.querySelector('select').innerHTML = html

                kelurahan.classList.remove("hidden")

        }); 
    }    

    function kelurahanChange(el){
        var kecamatan = document.querySelector("select[name='KD_KECAMATAN']")

        fetch("index.php?page=daftar-pbb&filter-kelurahan="+el.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

                var html = '<option value="-">- Pilih Blok -</option>'

                data.map(dt=>{
                    html += `<option value="${dt.KD_BLOK}">${dt.KD_BLOK}</option>`
                })

                var blok = document.querySelector("#blok")

                blok.querySelector('select').innerHTML = html

                blok.classList.remove("hidden")

        }); 

        fetch("index.php?page=daftar-pbb&get-jalan=true&filter-kelurahan="+el.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

            var html = '<option value="-">- Pilih Jalan -</option>'

            data.map(dt=>{
                html += `<option value="${dt.NM_JLN}">${dt.KD_ZNT} - ${dt.NM_JLN}</option>`
            })

            var jalan = document.querySelector("#jalan")

            jalan.innerHTML = html

            jalan.classList.remove("hidden")

        }); 
    }    

    function blokChange(el){
        var kecamatan = document.querySelector("select[name='KD_KECAMATAN']")
        var kelurahan = document.querySelector("select[name='KD_KELURAHAN']")

        // fetch("index.php?page=daftar-pbb&filter-blok="+el.value+"&filter-kelurahan="+kelurahan.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

        //         var html = '<option value="-">- Pilih ZNT -</option>'

        //         data.map(dt=>{
        //             html += `<option value="${dt.KD_ZNT}">${dt.KD_ZNT}</option>`
        //         })

        //         var znt = document.querySelector("#znt")

        //         znt.querySelector('select').innerHTML = html

        //         znt.classList.remove("hidden")

        // }); 

        fetch("index.php?page=daftar-pbb&get-no-urut=true&blok="+el.value+"&kelurahan="+kelurahan.value+"&kecamatan="+kecamatan.value).then(response => response.json()).then(data => {
            document.querySelector("[name='NO_URUT']").value = data
        })
    }   

    function fillZNT(el){
        var ZNT = el.selectedOptions[0].innerHTML.split(' - ')[0]
        document.querySelector("#KD_ZNT").value = ZNT
    }
</script>

<?php load('partials/landing-bottom') ?>