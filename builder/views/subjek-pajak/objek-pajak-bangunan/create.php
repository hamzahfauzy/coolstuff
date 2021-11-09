<?php load('builder/partials/top') ?>
<?php load('builder/subjek-pajak/objek-pajak-bangunan/modal') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-lg mr-3">Add Objek Pajak Bangunan : <?=$subjekPajak['NM_WP']?></h2>
        <a href="index.php?page=builder/subjek-pajak/view&id=<?=$_GET['id']?>" class="p-2 bg-green-500 text-white rounded">Kembali</a>
    </div>

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

    <form id="login-form" action="index.php?page=<?=$_GET['page']?>&id=<?=$_GET['id']?>" method="post" enctype="multipart/form-data">

        <div class="bg-white shadow-md rounded my-6 p-8">

            <h2 class="text-lg mb-10 text-center font-bold">Nomor Formulir</h2>

            <div class="grid grid-cols-3 gap-4">
                <div class="form-group mb-2">
                    <label>NOP</label>
                    <input type="text" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                </div>

                <div class="form-group mb-2">
                    <label>NO LSPOP</label>
                    <input type="text" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NO_FORMULIR_LSPOP"] ? $old["NO_FORMULIR_LSPOP"] : ''?>" name="NO_FORMULIR_LSPOP">
                </div>

                <div class="form-group mb-2">
                    <label>Tahun Pajak</label>
                    <select name="THN_PAJAK" class="p-2 mt-2 w-full border rounded">
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
                            <input type="text" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NOP"] ? $old["NOP"] : ''?>" name="NOP">
                        </div>
        
                        <div class="form-group mb-2">
                            <label>Jumlah Lantai</label>
                            <input type="text" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["JML_LANTAI_BNG"] ? $old["JML_LANTAI_BNG"] : ''?>" name="JML_LANTAI_BNG">
                        </div>
        
                        <div class="form-group mb-2">
                            <label>Luas (M2)</label>
                            <input type="text" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["NO_BNG"] ? $old["NO_BNG"] : ''?>" name="NO_BNG">
                        </div>
                    </div>
                
                    <div class="form-group mb-2">
                        <label>Jenis Pajak Bangunan</label>
                        <select name="KD_JPB" class="p-2 mt-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Jenis Pajak Bangunan -</option>
                            <?php foreach($jpbs as $jpb):?>
                                <option <?=isset($old) && $old['KD_JPB'] && $old['KD_JPB'] == $jpb["KD_JPB"] ? 'selected'  : ''?> value="<?=$jpb['KD_JPB']?>"><?=$jpb['KD_JPB']." - ".$jpb['NM_JPB']?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
            
                        <div class="form-group mb-2">
                            <label>Tahun Dibangun</label>
                            <select name="THN_DIBANGUN_BNG" class="p-2 mt-2 w-full border rounded">
                                <option value="" selected readonly>- Pilih Tahun -</option>
                                <?php foreach($years as $year):?>
                                    <option <?=isset($old) && $old['THN_DIBANGUN_BNG'] && $old['THN_DIBANGUN_BNG'] == $year ? 'selected'  : ''?> value="<?=$year?>"><?=$year?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
        
                        <div class="form-group mb-2">
                            <label>Tahun Renovasi</label>
                            <select name="THN_RENOVASI_BNG" class="p-2 mt-2 w-full border rounded">
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
                            <select name="KONDISI_BNG" class="p-2 mt-2 w-full border rounded">
                                <option value="" selected readonly>- Pilih Kondisi -</option>
                                <?php foreach($kondisis as $kondisi):?>
                                    <option <?=isset($old) && $old['KONDISI_BNG'] && $old['KONDISI_BNG'] == substr($kondisi,0,2) ? 'selected'  : ''?> value="<?=substr($kondisi,1,1)?>"><?=$kondisi?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>Jenis Konstruksi</label>
                            <select name="JNS_KONSTRUKSI_BNG" class="p-2 mt-2 w-full border rounded">
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
                        <select name="JNS_ATAP_BNG" class="p-2 mt-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Jenis Atap -</option>
                            <?php foreach($ataps as $atap):?>
                                <option <?=isset($old) && $old['JNS_ATAP_BNG'] && $old['JNS_ATAP_BNG'] == substr($atap,0,2) ? 'selected'  : ''?> value="<?=substr($atap,1,1)?>"><?=$atap?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Dinding</label>
                        <select name="KD_DINDING" class="p-2 mt-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Dinding -</option>
                            <?php foreach($dindings as $dinding):?>
                                <option <?=isset($old) && $old['KD_DINDING'] && $old['KD_DINDING'] == substr($dinding,0,2) ? 'selected'  : ''?> value="<?=substr($dinding,1,1)?>"><?=$dinding?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Lantai</label>
                        <select name="KD_LANTAI" class="p-2 mt-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Lantai -</option>
                            <?php foreach($lantais as $lantai):?>
                                <option <?=isset($old) && $old['KD_LANTAI'] && $old['KD_LANTAI'] == substr($lantai,0,2) ? 'selected'  : ''?> value="<?=substr($lantai,1,1)?>"><?=$lantai?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Langit - Langit</label>
                        <select name="KD_LANGIT_LANGIT" class="p-2 mt-2 w-full border rounded">
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
                    <input type="text" placeholder="Daya listrik (watt)" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["L_AC"]["DAYA_LISTRIK"] ? $old["L_AC"]["DAYA_LISTRIK"] : ''?>" name="L_AC[DAYA_LISTRIK]">
                    <input type="text" placeholder="Jumlah AC Split" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["L_AC"]["AC_SPLIT"] ? $old["L_AC"]["AC_SPLIT"] : ''?>" name="L_AC[AC_SPLIT]">
                    <input type="text" placeholder="Jumlah AC Window" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["L_AC"]["AC_WINDOW"] ? $old["L_AC"]["AC_WINDOW"] : ''?>" name="L_AC[AC_WINDOW]">

                    <select name="L_AC[AC_CENTRAL]" class="p-2 mt-2 w-full border rounded">
                        <option value="" selected readonly>- Pilih AC Central -</option>
                        <option <?= isset($old) && $old["L_AC"]["AC_CENTRAL"] && $old["L_AC"]["AC_CENTRAL"] == "01-Ada" ?  : ''?> value="01-Ada">01-Ada</option>
                        <option <?= isset($old) && $old["L_AC"]["AC_CENTRAL"] && $old["L_AC"]["AC_CENTRAL"] == "02-Tidak Ada" ?  : ''?>  value="02-Tidak Ada">02-Tidak Ada</option>
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label>Luas Perkerasan Halaman (M2)</label>
                    <input type="text" placeholder="Ringan" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["LPH"]["RINGAN"] ? $old["LPH"]["RINGAN"] : ''?>" name="LPH[RINGAN]">
                    <input type="text" placeholder="Sedang" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["LPH"]["SEDANG"] ? $old["LPH"]["SEDANG"] : ''?>" name="LPH[SEDANG]">
                    <input type="text" placeholder="Berat" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["LPH"]["BERAT"] ? $old["LPH"]["BERAT"] : ''?>" name="LPH[BERAT]">
                    <input type="text" placeholder="Penutup Lantai" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["LPH"]["P+LANTAI"] ? $old["LPH"]["P+LANTAI"] : ''?>" name="LPH[P_LANTAI]">
                </div>

                <div class="form-group mb-2">
                    <label>Jumlah Lapangan Tennis</label>

                    <div class="grid grid-cols-2 mt-6 gap-4">
                        <div class="form-group">
                            <label>Dengan Lampu</label>
                            <input type="text" placeholder="Beton" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["JLT_DL"]["BETON"] ? $old["JLT_DL"]["BETON"] : ''?>" name="JLT_DL[BETON]">
                            <input type="text" placeholder="Aspal" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["JLT_DL"]["ASPAL"] ? $old["JLT_DL"]["ASPAL"] : ''?>" name="JLT_DL[ASPAL]">
                            <input type="text" placeholder="Tanah/Rumput" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["JLT_DL"]["TR"] ? $old["JLT_DL"]["TR"] : ''?>" name="JLT_DL[TR]">
                        </div>
                        <div class="form-group">
                            <label>Tanpa Lampu</label>
                            <input type="text" placeholder="Beton" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["JLT_TL"]["BETON"] ? $old["JLT_TL"]["BETON"] : ''?>" name="JLT_TL[BETON]">
                            <input type="text" placeholder="Aspal" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["JLT_TL"]["ASPAL"] ? $old["JLT_TL"]["ASPAL"] : ''?>" name="JLT_TL[ASPAL]">
                            <input type="text" placeholder="Tanah/Rumput" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old["JLT_TL"]["TR"] ? $old["JLT_TL"]["TR"] : ''?>" name="JLT_TL[TR]">
                        </div>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-3 gap-4 mt-4">

                <div class="form-group mb-2">
                    <label>Pagar</label>

                    <select name="PAGAR[BP]" class="p-2 mt-2 w-full border rounded">
                        <option value="" selected readonly>- Pilih Bahan Pagar -</option>
                        <option <?= isset($old) && $old["PAGAR"]["BP"] && $old["PAGAR"]["BP"] == "01-Baja/Besi" ?  : ''?> value="01-Baja/Besi">01-Baja/Besi</option>
                        <option <?= isset($old) && $old["PAGAR"]["BP"] && $old["PAGAR"]["BP"] == "02-Bata/Batako" ?  : ''?>  value="02-Bata/Batako">02-Bata/Batako</option>
                    </select>

                    <input type="text" placeholder="Panjang Pagar (M)" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['PAGAR']["PP"] ? $old['PAGAR']["PP"] : ''?>" name="PAGAR[PP]">
                </div>

                <div class="form-group mb-2">
                    <label>Lebar Tangga Berjalan</label>
                    <input type="text" placeholder="<= 0.80 M" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['LTB']["LT"] ? $old['LTB']["LT"] : ''?>" name="LTB[LT]">
                    <input type="text" placeholder="> 0.80 M" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['LTB']["MT"] ? $old['LTB']["MT"] : ''?>" name="LTB[MT]">
                </div>

                <div class="form-group mb-2">
                    <label>Pemadam Kebakaran</label>

                    <!-- select -->

                    <select name="PK[HYDRAN]" class="p-2 mt-2 w-full border rounded">
                        <option value="" selected readonly>- Pilih -</option>
                        <option <?= isset($old) && $old["PK"]["HYDRAN"] && $old["PK"]["HYDRAN"] == "01-Ada" ?  : ''?> value="01-Ada">01-Ada</option>
                        <option <?= isset($old) && $old["PK"]["HYDRAN"] && $old["PK"]["HYDRAN"] == "02-Tidak Ada" ?  : ''?>  value="02-Tidak Ada">02-Tidak Ada</option>
                    </select>

                    <select name="PK[SPRINGKLER]" class="p-2 mt-2 w-full border rounded">
                        <option value="" selected readonly>- Pilih -</option>
                        <option <?= isset($old) && $old["PK"]["SPRINGKLER"] && $old["PK"]["SPRINGKLER"] == "01-Ada" ?  : ''?> value="01-Ada">01-Ada</option>
                        <option <?= isset($old) && $old["PK"]["SPRINGKLER"] && $old["PK"]["SPRINGKLER"] == "02-Tidak Ada" ?  : ''?>  value="02-Tidak Ada">02-Tidak Ada</option>
                    </select>

                    <select name="PK[FIRE_ALARM]" class="p-2 mt-2 w-full border rounded">
                        <option value="" selected readonly>- Pilih -</option>
                        <option <?= isset($old) && $old["PK"]["FIRE_ALARM"] && $old["PK"]["FIRE_ALARM"] == "01-Ada" ?  : ''?> value="01-Ada">01-Ada</option>
                        <option <?= isset($old) && $old["PK"]["FIRE_ALARM"] && $old["PK"]["FIRE_ALARM"] == "02-Tidak Ada" ?  : ''?>  value="02-Tidak Ada">02-Tidak Ada</option>
                    </select>
                </div>

            </div>

            
            <div class="grid grid-cols-3 gap-4 mt-4">

                <div class="form-group mb-2">
                    <label>Jumlah Lift</label>
                    <input type="text" placeholder="Penumpang" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['J_LIFT']["PENUMPANG"] ? $old['J_LIFT']["PENUMPANG"] : ''?>" name="J_LIFT[PENUMPANG]">
                    <input type="text" placeholder="Kapsul" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['J_LIFT']["KAPSUL"] ? $old['J_LIFT']["KAPSUL"] : ''?>" name="J_LIFT[KAPSUL]">
                    <input type="text" placeholder="Barang" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['J_LIFT']["BARANG"] ? $old['J_LIFT']["BARANG"] : ''?>" name="J_LIFT[BARANG]">
                </div>

                <div class="form-group mb-2">
                    <label>&nbsp;</label>
                    <input type="text"  placeholder="Jumlah Saluran PABX" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['OTHERS']["JLH_S_PABX"] ? $old['OTHERS']["JLH_S_PABX"] : ''?>" name="OTHERS[JLH_S_PABX]">
                    <input type="text" placeholder="Dalam Sumur Artesis" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['OTHERS']["DLM_SUMUR_A"] ? $old['OTHERS']["DLM_SUMUR_A"] : ''?>" name="OTHERS[DLM_SUMUR_A]">
                    <input type="text"  placeholder="Kapasitas Genset" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['OTHERS']["K_GENSET"] ? $old['OTHERS']["K_GENSET"] : ''?>" name="OTHERS[K_GENSET]">
                </div>

                <div class="form-group mb-2">
                    <label>Kolam Renang</label>

                    <!-- select -->
                    <select name="KOLAM_RENANG[F_KOLAM]" class="p-2 mt-2 w-full border rounded">
                        <option value="" selected readonly>- Pilih -</option>
                        <option <?= isset($old) && $old["KOLAM_RENANG"]["F_KOLAM"] && $old["KOLAM_RENANG"]["F_KOLAM"] == "01-Displester" ?  : ''?> value="01-Displester">01-Displester</option>
                        <option <?= isset($old) && $old["KOLAM_RENANG"]["F_KOLAM"] && $old["KOLAM_RENANG"]["F_KOLAM"] == "02-Dengan Pelapis" ?  : ''?>  value="02-Dengan Pelapis">02-Dengan Pelapis</option>
                    </select>
                    
                    <input type="text"  placeholder="Luas (M2)" class="p-2 mt-2 w-full border rounded" value="<?=isset($old) && $old['KOLAM_RENANG']["LUAS"] ? $old['KOLAM_RENANG']["LUAS"] : ''?>" name="KOLAM_RENANG[LUAS]">
                </div>

            </div>

        </div>

        <div class="bg-white shadow-md rounded my-6 p-8">
             <div class="grid grid-cols-2 gap-4 mt-4">

                <div class="form-group mb-2">
                    <label>Tanggal Pendataan</label>
                    <input type="date" class="p-2 mt-2 w-full border rounded" name="TGL_PENDATAAN_BNG">
                </div>

                <div class="form-group mb-2">
                    <label>NIP Pendata</label>
                    <input type="text" class="p-2 mt-2 w-full border rounded" name="NIP_PENDATA_BNG">
                </div>

                <div class="form-group mb-2">
                    <label>Tanggal Pemeriksaan</label>
                    <input type="date" class="p-2 mt-2 w-full border rounded" name="TGL_PEMERIKSAAN_BNG">
                </div>

                <div class="form-group mb-2">
                    <label>NIP Pemeriksa</label>
                    <input type="text" class="p-2 mt-2 w-full border rounded" name="NIP_PEMERIKSA_BNG">
                </div>

                <div class="form-group mb-2">
                    <label>Tanggal Perekam</label>
                    <input type="date" class="p-2 mt-2 w-full border rounded" name="TGL_PEREKAM_BNG">
                </div>

                <div class="form-group mb-2">
                    <label>NIP Perekam</label>
                    <input type="text" class="p-2 mt-2 w-full border rounded" name="NIP_PEREKAM_BNG">
                </div>

            </div>
        </div>

        <div class="bg-white shadow-md rounded my-6 p-8">

            <div class="form-group mb-2">
                <label>Keterangan</label>
                <input type="text" class="p-2 mt-2 w-full border rounded" name="KETERANGAN">
            </div>

            <div class="form-group">
                <button type="button" class="w-full p-2 bg-indigo-800 text-white rounded" id="btn-login">Proses</button>
            </div>

        </div>

    </form>
</div>

<script>

    var nop = $("input[name='NOP']");

    nop.inputmask({mask:"12.12.999.999.999-999.9"})

    $("#btn-login").on('click',function(){
        $("#modal").removeClass("hidden")
    })
      
</script>

<?php load('builder/partials/bottom') ?>
