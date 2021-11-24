<?php load('builder/partials/top') ?>
<?php load('builder/subjek-pajak/objek-pajak-bangunan/modal') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    
    <div class="flex justify-between items-center mb-5">

        <h2 class="text-lg mr-3">Edit Objek Pajak Bangunan : <?=$subjekPajak['NM_WP']?></h2>
        <a href="index.php?page=builder/subjek-pajak/view&id=<?=$_GET['id']?>" class="p-2 bg-green-500 text-white rounded">Kembali</a>
        
    </div>

    <form id="bangunan" action="index.php?page=<?=$_GET['page']?>&id=<?=$_GET['id']?>&NOP=<?=$_GET['NOP']?>&NO_BNG=<?=$_GET['NO_BNG']?>" method="post" enctype="multipart/form-data">

        <div class="bg-white shadow-md rounded my-6 p-8">

            <h2 class="text-lg mb-10 text-center font-bold">Nomor Formulir</h2>

            <div class="grid grid-cols-3 gap-4">
                <div class="form-group mb-2">
                    <label>NOP</label>
                    <input type="text" readonly required class="p-2 mt-2 w-full border rounded" value="<?=$data["NOP"] ? $data["NOP"] : $data['NOP']?>" name="NOP">
                </div>

                <div class="form-group mb-2">
                    <label>NO LSPOP</label>
                    <input type="text" required class="p-2 mt-2 w-full border rounded" value="<?=$data["NO_FORMULIR_LSPOP"] ? $data["NO_FORMULIR_LSPOP"] : $data["NO_FORMULIR_LSPOP"]?>" name="NO_FORMULIR_LSPOP">
                </div>

                <div class="form-group mb-2">
                    <label>Tahun Pajak</label>
                    <select required name="THN_PAJAK" class="p-2 mt-2 w-full border rounded">
                        <option value="" selected readonly>- Pilih Tahun -</option>
                        <?php foreach($years as $year):?>
                            <option <?=isset($old) && $old['THN_PAJAK'] && $old['THN_PAJAK'] == $year ? 'selected'  : $year == $nYear ? "selected" : ''?> value="<?=$year?>"><?=$year?></option>
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
                            <input required type="text" class="p-2 mt-2 w-full border rounded" value="<?=$data["NO_BNG"] ? $data["NO_BNG"] : ''?>" name="NO_BNG">
                        </div>
        
                        <div class="form-group mb-2">
                            <label>Jumlah Lantai</label>
                            <input required type="text" class="p-2 mt-2 w-full border rounded" value="<?=$data["JML_LANTAI_BNG"] ? $data["JML_LANTAI_BNG"] : ''?>" name="JML_LANTAI_BNG">
                        </div>
        
                        <div class="form-group mb-2">
                            <label>Luas (M2)</label>
                            <input required type="text" class="p-2 mt-2 w-full border rounded" value="<?=$data["LUAS_BNG"] ? $data["LUAS_BNG"] : ''?>" name="LUAS_BNG">
                        </div>
                    </div>
                
                    <div class="form-group mb-2">
                        <label>Jenis Pajak Bangunan</label>
                        <select required name="KD_JPB" class="p-2 mt-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Jenis Pajak Bangunan -</option>
                            <?php foreach($jpbs as $jpb):?>
                                <option <?=isset($data) && $data['KD_JPB'] && $data['KD_JPB'] == $jpb["KD_JPB"] ? 'selected'  : $jpb['KD_JPB'] == "01" ? "selected" : ''?> value="<?=$jpb['KD_JPB']?>"><?=$jpb['KD_JPB']." - ".$jpb['NM_JPB']?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">

                        <div class="form-group mb-2">
                            <label>Tahun Dibangun</label>
                            <select required name="THN_DIBANGUN_BNG" class="p-2 mt-2 w-full border rounded">
                                <option value="" selected readonly>- Pilih Tahun -</option>
                                <?php foreach($years as $year):?>
                                    <option <?=isset($data) && $data['THN_DIBANGUN_BNG'] && $data['THN_DIBANGUN_BNG'] == $year ? 'selected'  : $year == $nYear ? "selected" : ''?> value="<?=$year?>"><?=$year?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
        
                        <div class="form-group mb-2">
                            <label>Tahun Renovasi</label>
                            <select name="THN_RENOVASI_BNG" class="p-2 mt-2 w-full border rounded">
                                <option value="" selected readonly>- Pilih Tahun -</option>
                                <?php foreach($years as $year):?>
                                    <option <?=isset($data) && $data['THN_RENOVASI_BNG'] && $data['THN_RENOVASI_BNG'] == $year ? 'selected'  : ''?> value="<?=$year?>"><?=$year?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                    </div>  

                    <div class="grid grid-cols-2 gap-4">

                     <div class="form-group mb-2">
                            <label>Kondisi Bangunan</label>
                            <select required name="KONDISI_BNG" class="p-2 mt-2 w-full border rounded">
                                <option value="" selected readonly>- Pilih Kondisi -</option>
                                <?php foreach($kondisis as $kondisi):?>
                                    <option <?=isset($data) && $data['KONDISI_BNG'] && $data['KONDISI_BNG'] == substr($kondisi,0,2) ? 'selected'  : substr($kondisi,0,2) == "02" ? "selected" : ''?> value="<?=substr($kondisi,0,2)?>"><?=$kondisi?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label>Jenis Konstruksi</label>
                            <select required name="JNS_KONSTRUKSI_BNG" class="p-2 mt-2 w-full border rounded">
                                <option value="" selected readonly>- Pilih Jenis Konstruksi -</option>
                                <?php foreach($konstruksis as $konstruksi):?>
                                    <option <?=isset($data) && $data['JNS_KONSTRUKSI_BNG'] && $data['JNS_KONSTRUKSI_BNG'] == substr($konstruksi,0,2) ? 'selected'  : substr($konstruksi,0,2) == "02" ? "selected" : ''?> value="<?=substr($konstruksi,0,2)?>"><?=$konstruksi?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                    </div>

                </div>

                <div>

                <div class="form-group mb-2">
                        <label>Jenis Atap</label>
                        <select required name="JNS_ATAP_BNG" class="p-2 mt-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Jenis Atap -</option>
                            <?php foreach($ataps as $atap):?>
                                <option <?=isset($data) && $data['JNS_ATAP_BNG'] && $data['JNS_ATAP_BNG'] == substr($atap,0,2) ? 'selected'  : substr($atap,0,2) == "05" ? "selected" : ''?> value="<?=substr($atap,0,2)?>"><?=$atap?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Dinding</label>
                        <select required name="KD_DINDING" class="p-2 mt-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Dinding -</option>
                            <?php foreach($dindings as $dinding):?>
                                <option <?=isset($data) && $data['KD_DINDING'] && $data['KD_DINDING'] == substr($dinding,0,2) ? 'selected'  : substr($dinding,0,2) == "02" ? "selected" : ''?> value="<?=substr($dinding,0,2)?>"><?=$dinding?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Lantai</label>
                        <select required name="KD_LANTAI" class="p-2 mt-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Lantai -</option>
                            <?php foreach($lantais as $lantai):?>
                                <option <?=isset($data) && $data['KD_LANTAI'] && $data['KD_LANTAI'] == substr($lantai,0,2) ? 'selected'  : substr($lantai,0,2) == "05" ? "selected" : ''?> value="<?=substr($lantai,0,2)?>"><?=$lantai?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Langit - Langit</label>
                        <select required name="KD_LANGIT_LANGIT" class="p-2 mt-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Langit - Langit -</option>
                            <?php foreach($langits as $langit):?>
                                <option <?=isset($data) && $data['KD_LANGIT_LANGIT'] && $data['KD_LANGIT_LANGIT'] == substr($langit,0,2) ? 'selected'  : substr($langit,0,2) == "02" ? "selected" : ''?> value="<?=substr($langit,0,2)?>"><?=$langit?></option>
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
                        <input type="text" required placeholder="Daya listrik (watt)" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tListrik']) ? $fasilitas['tListrik'] : '0'?>" name="L_AC[DAYA_LISTRIK]">
                    </div>

                    <div class="form-group my-2">
                        <label for="">Jumlah AC Split</label>
                        <input type="text" placeholder="Jumlah AC Split" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tAC1']) ? $fasilitas['tAC1'] : '0' ?>"  name="L_AC[AC_SPLIT]">
                    </div>

                    <div class="form-group my-2">
                        <label for="">Jumlah AC Window</label>
                        <input type="text" placeholder="Jumlah AC Window" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tAC2']) ? $fasilitas['tAC2'] : '0'?>" name="L_AC[AC_WINDOW]">
                    </div>

                    <div class="form-group my-2">
                        <label for="">AC Central</label>
                        <select name="L_AC[AC_CENTRAL]" class="p-2 mt-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih AC Central -</option>
                            <option <?= isset($fasilitas['cbo_ac']) && $fasilitas['cbo_ac'] == "01" ? 'selected' : ''?> value="01-Ada">01-Ada</option>
                            <option <?= isset($fasilitas['cbo_ac']) && $fasilitas['cbo_ac'] == "02" ? 'selected' : 'selected'?> value="02-Tidak Ada">02-Tidak Ada</option>
                        </select>
                    </div>

                </div>

                <div class="form-group mb-2">
                    <label class="text-lg">Luas Perkerasan Halaman (M2)</label>

                    <div class="form-group my-2">
                        <label for="">Ringan</label>
                        <input type="text" placeholder="Ringan" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tHal1']) ? $fasilitas['tHal1'] : '0'?>" name="LPH[RINGAN]">
                    </div>
                    
                    <div class="form-group my-2">
                        <label for="">Sedang</label>
                        <input type="text" placeholder="Sedang" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tHal2']) ? $fasilitas['tHal2'] : '0'?>" name="LPH[SEDANG]">
                    </div>

                    <div class="form-group my-2">
                        <label for="">Berat</label>
                        <input type="text" placeholder="Berat" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tHal3']) ? $fasilitas['tHal3'] : '0'?>" name="LPH[BERAT]">
                    </div>

                    <div class="form-group my-2">
                        <label for="">Penutup Lantai</label>
                        <input type="text" placeholder="Penutup Lantai" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tHal4']) ? $fasilitas['tHal4'] : '0'?>"  name="LPH[P_LANTAI]">
                    </div>

                </div>

                <div class="form-group mb-2">
                    <label class="text-lg">Jumlah Lapangan Tennis</label>

                    <div class="grid grid-cols-2 mt-6 gap-4">
                        <div class="form-group">
                            <label>Dengan Lampu</label>

                            <div class="form-group my-2">
                                <label for="">Beton</label>
                                <input type="text" placeholder="Beton" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLap_Beton1']) ? $fasilitas['tLap_Beton1'] : '0'?>" name="JLT_DL[BETON]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Aspal</label>
                                <input type="text" placeholder="Aspal" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLap_Aspal1']) ? $fasilitas['tLap_Aspal1'] : '0'?>" name="JLT_DL[ASPAL]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Tanah/Rumput</label>
                                <input type="text" placeholder="Tanah/Rumput" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLap_Tanah1']) ? $fasilitas['tLap_Tanah1'] : '0'?>" name="JLT_DL[TR]">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tanpa Lampu</label>

                            <div class="form-group my-2">
                                <label for="">Beton</label>
                                <input type="text" placeholder="Beton" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLap_Beton2']) ? $fasilitas['tLap_Beton2'] : '0'?>" name="JLT_TL[BETON]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Aspal</label>
                                <input type="text" placeholder="Aspal" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLap_Aspal2']) ? $fasilitas['tLap_Aspal2'] : '0'?>" name="JLT_TL[ASPAL]">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Tanah/Rumput</label>
                                <input type="text" placeholder="Tanah/Rumput" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLap_Tanah2']) ? $fasilitas['tLap_Tanah2'] : '0'?>" name="JLT_TL[TR]">
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
                            <option value="" readonly>- Pilih Bahan Pagar -</option>
                            <option <?= isset($fasilitas['cbo_pagar']) && $fasilitas['cbo_pagar'] == "01" ? 'selected' : !isset($fasilitas['cbo_pagar']) ? 'selected' : ''?> value="01-Baja/Besi">01-Baja/Besi</option>
                            <option <?= isset($fasilitas['cbo_pagar']) && $fasilitas['cbo_pagar'] == "02" ? 'selected' : ''?>  value="02-Bata/Batako">02-Bata/Batako</option>
                        </select>

                    </div>

                    <div class="form-group my-2">
                        <label for="">Panjang Pagar (M)</label>
                        <input type="text" placeholder="Panjang Pagar (M)" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tPagar']) ? $fasilitas['tPagar'] : '0'?>" name="PAGAR[PP]">
                    </div>

                </div>

                <div class="form-group mb-2">
                    <label class="text-lg">Lebar Tangga Berjalan</label>

                     <div class="form-group my-2">
                        <label for=""><= 0.80 M</label>
                        <input type="text" placeholder="<= 0.80 M" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tTangga1']) ? $fasilitas['tTangga1'] : '0'?>" name="LTB[LT]">
                    </div>

                    <div class="form-group my-2">
                        <label for="">> 0.80 M</label>
                        <input type="text" placeholder="> 0.80 M" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tTangga2']) ? $fasilitas['tTangga2'] : '0'?>" name="LTB[MT]">
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label class="text-lg">Pemadam Kebakaran</label>

                    <!-- select -->

                    <div class="form-group my-2">
                        <label for="">Hydrant</label>

                        <select name="PK[HYDRAN]" class="p-2 mt-2 w-full border rounded">
                            <option value="" readonly>- Pilih -</option>
                            <option <?= isset($fasilitas['cbo_hydrant']) && $fasilitas['cbo_hydrant'] == "01" ? 'selected' : ''?> value="01">01-Ada</option>
                            <option <?= isset($fasilitas['cbo_hydrant']) && $fasilitas['cbo_hydrant'] == "02" ? 'selected' : !isset($fasilitas['cbo_hydrant']) ? 'selected'  : ''?>  value="02">02-Tidak Ada</option>
                        </select>

                    </div>

                    <div class="form-group my-2">
                        <label for="">Springkler</label>

                        <select name="PK[SPRINGKLER]" class="p-2 mt-2 w-full border rounded">
                            <option value="" readonly>- Pilih -</option>
                            <option <?= isset($fasilitas['cbo_springkler']) && $fasilitas['cbo_springkler'] == "01" ? 'selected' : ''?> value="01">01-Ada</option>
                            <option <?= isset($fasilitas['cbo_springkler']) && $fasilitas['cbo_springkler'] == "02" ? 'selected' : !isset($fasilitas['cbo_springkler']) ? 'selected'  : ''?>  value="02">02-Tidak Ada</option>
                        </select>

                    </div>

                    <div class="form-group my-2">
                        <label for="">Fire Alarm</label>

                        <select name="PK[FIRE_ALARM]" class="p-2 mt-2 w-full border rounded">
                            <option value="" readonly>- Pilih -</option>
                            <option <?= isset($fasilitas['cbo_fa']) && $fasilitas['cbo_fa'] == "01" ? 'selected' : ''?> value="01">01-Ada</option>
                            <option <?= isset($fasilitas['cbo_fa']) && $fasilitas['cbo_fa'] == "02" ? 'selected' : !isset($fasilitas['cbo_fa']) ? 'selected' : ''?>  value="02">02-Tidak Ada</option>
                        </select>

                    </div>

                </div>

            </div>

            
            <div class="grid grid-cols-3 gap-4 mt-4">

                <div class="form-group mb-2">
                    <label class="text-lg">Jumlah Lift</label>

                    <div class="form-group my-2">
                        <label for="">Penumpang</label>
                        <input type="text" placeholder="Penumpang" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLift1']) ? $fasilitas['tLift1'] : '0'?>" name="J_LIFT[PENUMPANG]">
                    </div>
                    
                    <div class="form-group my-2">
                        <label for="">Kapsul</label>
                        <input type="text" placeholder="Kapsul" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLift2']) ? $fasilitas['tLift2'] : '0'?>" name="J_LIFT[KAPSUL]">
                    </div>
                    
                    <div class="form-group my-2">
                        <label for="">Barang</label>
                        <input type="text" placeholder="Barang" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tLift3']) ? $fasilitas['tLift3'] : '0'?>" name="J_LIFT[BARANG]">
                    </div>

                </div>

                <div class="form-group mb-2">
                    <label class="text-lg">Others</label>

                    <div class="form-group my-2">
                        <label for="">Jumlah Saluran PABX</label>
                        <input type="text"  placeholder="Jumlah Saluran PABX" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tPABX']) ? $fasilitas['tPABX'] : '0'?>" name="OTHERS[JLH_S_PABX]">
                    </div>

                    <div class="form-group my-2">
                        <label for="">Dalam Sumur Artesis</label>
                        <input type="text" placeholder="Dalam Sumur Artesis" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tSumur']) ? $fasilitas['tSumur'] : '0'?>" name="OTHERS[DLM_SUMUR_A]">
                    </div>

                    <div class="form-group my-2">
                        <label for="">Kapasitas Genset</label>
                        <input type="text"  placeholder="Kapasitas Genset" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tGenset']) ? $fasilitas['tGenset'] : '0'?>" name="OTHERS[K_GENSET]">
                    </div>

                </div>

                <div class="form-group mb-2">
                    <label class="text-lg">Kolam Renang</label>

                    <!-- select -->
                    
                    <div class="form-group my-2">
                        <label for="">Finishing Kolam</label>

                        <select name="KOLAM_RENANG[F_KOLAM]" class="p-2 mt-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih -</option>
                            <option <?= isset($fasilitas['cbo_kolam']) && $fasilitas['cbo_kolam'] == "01" ? 'selected' : ''?> value="01">01-Displester</option>
                            <option <?= isset($fasilitas['cbo_kolam']) && $fasilitas['cbo_kolam'] == "02" ? 'selected'  : ''?>  value="02">02-Dengan Pelapis</option>
                        </select>

                    </div>

                    <div class="form-group my-2">
                        <label for="">Luas (M2)</label>
                        <input type="text"  placeholder="Luas (M2)" class="p-2 mt-2 w-full border rounded" value="<?=isset($fasilitas['tKolam']) ? $fasilitas['tKolam'] : '0'?>" name="KOLAM_RENANG[LUAS]">
                    </div>
                    
                </div>

            </div>

        </div>

        <div class="bg-white shadow-md rounded my-6 p-8">
             <div class="grid grid-cols-2 gap-4 mt-4">

                <div class="form-group mb-2">
                    <label>Tanggal Pendataan</label>
                    <input required type="date" class="p-2 mt-2 w-full border rounded" value="<?=$data['TGL_PENDATAAN_BNG']?>" name="TGL_PENDATAAN_BNG">
                </div>

                <div class="form-group mb-2">
                    <label>NIP Pendata</label>
                    <input required type="text" class="p-2 mt-2 w-full border rounded" value="<?=$data['NIP_PENDATA_BNG']?>" name="NIP_PENDATA_BNG">
                </div>

                <div class="form-group mb-2">
                    <label>Tanggal Pemeriksaan</label>
                    <input required type="date" class="p-2 mt-2 w-full border rounded" value="<?=$data['TGL_PEMERIKSAAN_BNG']?>" name="TGL_PEMERIKSAAN_BNG">
                </div>

                <div class="form-group mb-2">
                    <label>NIP Pemeriksa</label>
                    <input required type="text" class="p-2 mt-2 w-full border rounded" value="<?=$data['NIP_PEMERIKSA_BNG']?>" name="NIP_PEMERIKSA_BNG">
                </div>

                <div class="form-group mb-2">
                    <label>Tanggal Perekam</label>
                    <input required type="date" class="p-2 mt-2 w-full border rounded" value="<?=$data['TGL_PEREKAMAN_BNG']?>" name="TGL_PEREKAM_BNG">
                </div>

                <div class="form-group mb-2">
                    <label>NIP Perekam</label>
                    <input required type="text" class="p-2 mt-2 w-full border rounded" value="<?=$data['NIP_PEREKAM_BNG']?>" name="NIP_PEREKAM_BNG">
                </div>

            </div>
        </div>

        <div class="bg-white shadow-md rounded my-6 p-8">

            <div class="grid grid-cols-2 gap-4">
                <div class="form-group mb-2">
                    <label>Keterangan</label>
                    <input required type="text" class="p-2 mt-2 w-full border rounded" name="KETERANGAN">
                </div>
    
                <div class="form-group mb-2">
                    <label>Nilai Individu</label>
                    <input required type="text" class="p-2 mt-2 w-full border rounded" value="<?= isset($INDIVIDU['NILAI_INDIVIDU']) ? $INDIVIDU['NILAI_INDIVIDU'] : '' ?>" name="NILAI_INDIVIDU">
                </div>
            </div>

            <div class="form-group">
                <button type="button" class="w-full p-2 bg-indigo-800 text-white rounded" id="btn-login">Proses</button>
            </div>

        </div>

    </form>
</div>

<script>

    var nop = $("input[name='NOP']");

    var mask = "<?=$_GET['NOP']?>"

    // nop.inputmask({mask:mask})

    nop.val(mask)

    $("#btn-login").on('click',async function(){

        var dataOld = $(document.forms.bangunan).serializeArray()

        var data = {};
        for (var i = 0; i < dataOld.length; i++){
            data[dataOld[i]['name']]=dataOld[i]['value']
        }
        

        if(!data['NOP']){
            alert("NOP Tidak boleh Kosong")
        }

        if(!data['NO_BNG']){
            alert("No Bangunan Tidak boleh Kosong")
        }
        
        // var response = await fetch("index.php?page=<?=$_GET['page']?>&check=true&NOP="+data['NOP']+"&NO_BNG="+data['NO_BNG'])
        // var result = await response.json()

        // if(result){

        //     alert("NOP Sudah Digunakan")

        // }else{

            var bangunanForm = document.forms.bangunan
            
            if(bangunanForm.checkValidity()){

                var formData = new FormData(document.forms.bangunan)
                formData.append('hitung',true)

                var request = await fetch("index.php?page=<?=$_GET['page']?>&id=<?=$_GET['id']?>&NOP=<?=$_GET['NOP']?>&NO_BNG=<?=$_GET['NO_BNG']?>",{
                    method:"POST",
                    body:formData
                })

                var result = await request.json()

                $("#modal").removeClass("hidden")

                $("#NOP").html(data['NOP'])
                $("#NO_FORM").html(data['NO_FORMULIR_LSPOP'])

                $("#JPB").html(data['KD_JPB'])
                $("#LSB").html(data['LUAS_BNG'])
                $("#JLH_LANTAI").html(data['JML_LANTAI_BNG'])

                $("#THN_PAJAK").html(data['THN_PAJAK'])
                $("#THN_DIBANGUN").html(data['THN_DIBANGUN_BNG'])
                $("#THN_RENOVASI").html(data['THN_RENOVASI_BNG'])

                $("#BNG_KE").html(data['NO_BNG'])
                $("#KONDISI").html(data['KONDISI_BNG'])
                $("#KONSTRUKSI").html(data['JNS_KONSTRUKSI_BNG'])

                $("#BAHAN_PAGAR").html(data['PAGAR[BP]'])

                // BKU

                    var JUM1 = 0

                    var BKU_SKU = `<p>${data['LUAS_BNG']} M2 x <span class="font-bold">Rp.${result.LDBKB}</span> </p>`;
                    $("#BKU_SKU").html(BKU_SKU)

                    var BKU_SKU_HASIL = data['LUAS_BNG'] * result.LDBKB

                    JUM1 += BKU_SKU_HASIL
                    
                    BKU_SKU_HASIL = `Rp.${BKU_SKU_HASIL}`;
                    $("#BKU_SKU_HASIL").html(BKU_SKU_HASIL)

                    var BKU_M = `<p>${0} M2 x <span class="font-bold">Rp.${result.nMezanine}</span> </p>`;
                    $("#BKU_M").html(BKU_M)

                    var BKU_M_HASIL = 0 * result.nMezanine

                    JUM1 += BKU_M_HASIL
                    
                    BKU_M_HASIL = `Rp.${BKU_M_HASIL}`;
                    $("#BKU_M_HASIL").html(BKU_M_HASIL)

                    var BKU_DKL = `<p>${data['LUAS_BNG']} M2 x <span class="font-bold">Rp.${result.nDUKUNG}</span> </p>`;
                    $("#BKU_DKL").html(BKU_DKL)

                    var BKU_DKL_HASIL = data['LUAS_BNG'] * result.nDUKUNG

                    JUM1 += BKU_DKL_HASIL
                    
                    BKU_DKL_HASIL = `Rp.${BKU_DKL_HASIL}`;
                    $("#BKU_DKL_HASIL").html(BKU_DKL_HASIL)

                    var BKU_TOTAL = `Rp.${JUM1}`;
                    $("#BKU_TOTAL").html(BKU_TOTAL)
                    

                // BKM

                    var JUM2 = 0

                    var BKM_ATAM = `<p>${data['LUAS_BNG']} M2 x <span class="font-bold">Rp.${result.xAtap}</span> </p>`;
                    $("#BKM_ATAP").html(BKM_ATAM)

                    var BKM_ATAP_HASIL = data['LUAS_BNG'] * result.xAtap

                    JUM2 += BKM_ATAP_HASIL

                    BKM_ATAP_HASIL = `Rp.${BKM_ATAP_HASIL}`;
                    $("#BKM_ATAP_HASIL").html(BKM_ATAP_HASIL)
                    
                    var BKM_DINDING = `<p>${data['LUAS_BNG']} M2 x <span class="font-bold">Rp.${result.xDinding}</span> </p>`;
                    $("#BKM_DINDING").html(BKM_DINDING)

                    var BKM_DINDING_HASIL = data['LUAS_BNG'] * result.xDinding

                    JUM2 += BKM_DINDING_HASIL

                    BKM_DINDING_HASIL = `Rp.${BKM_DINDING_HASIL}`;
                    $("#BKM_DINDING_HASIL").html(BKM_DINDING_HASIL)
                    
                    var BKM_LANTAI = `<p>${data['LUAS_BNG']} M2 x <span class="font-bold">Rp.${result.xLantai}</span> </p>`;
                    $("#BKM_LANTAI").html(BKM_LANTAI)

                    var BKM_LANTAI_HASIL = data['LUAS_BNG'] * result.xLantai

                    JUM2 += BKM_LANTAI_HASIL

                    BKM_LANTAI_HASIL = `Rp.${BKM_LANTAI_HASIL}`;
                    $("#BKM_LANTAI_HASIL").html(BKM_LANTAI_HASIL)
                    
                    var BKM_LANGIT = `<p>${data['LUAS_BNG']} M2 x <span class="font-bold">Rp.${result.xLangit2}</span> </p>`;
                    $("#BKM_LANGIT").html(BKM_LANGIT)

                    var BKM_LANGIT_HASIL = data['LUAS_BNG'] * result.xLangit2

                    JUM2 += BKM_LANGIT_HASIL

                    BKM_LANGIT_HASIL = `Rp.${BKM_LANGIT_HASIL}`;
                    $("#BKM_LANGIT_HASIL").html(BKM_LANGIT_HASIL)
                    
                    var BKM_TOTAL = `Rp.${JUM2}`;
                    $("#BKM_TOTAL").html(BKM_TOTAL)

                // BKF

                    var JUM3 = 0

                    // PAGAR

                        if(data['PAGAR[PP]'] == "01"){
                            var BKF_PAGAR = `<p>${data['PAGAR[PP]']} M' x <span class="font-bold">Rp.${result.BAHAN_PAGAR1}</span> </p>`;
                            $("#BKF_PAGAR").html(BKF_PAGAR)

                            var BKF_PAGAR_HASIL = data['PAGAR[PP]'] * result.BAHAN_PAGAR1

                            JUM3 += BKF_PAGAR_HASIL

                            BKF_PAGAR_HASIL = `Rp.${BKF_PAGAR_HASIL}`;

                            $("#BKF_PAGAR_HASIL").html(BKF_PAGAR_HASIL)
                        }else{
                            var BKF_PAGAR = `<p>${data['PAGAR[PP]']} M' x <span class="font-bold">Rp.${result.BAHAN_PAGAR2}</span> </p>`;
                            $("#BKF_PAGAR").html(BKF_PAGAR)

                            var BKF_PAGAR_HASIL = data['PAGAR[PP]'] * result.BAHAN_PAGAR2

                            JUM3 += BKF_PAGAR_HASIL

                            BKF_PAGAR_HASIL = `Rp.${BKF_PAGAR_HASIL}`;

                            $("#BKF_PAGAR_HASIL").html(BKF_PAGAR_HASIL)
                        }

                    // PH
                
                        var BKF_PH_RINGAN = `<p>${data['LPH[RINGAN]']} M2 x <span class="font-bold">Rp.${result.LUAS_HRINGAN}</span> </p>`;
                        $("#BKF_PH_RINGAN").html(BKF_PH_RINGAN)

                        var BKF_PH_RINGAN_HASIL = data['LPH[RINGAN]'] * result.LUAS_HRINGAN

                        JUM3 += BKF_PH_RINGAN_HASIL

                        BKF_PH_RINGAN_HASIL = `Rp.${BKF_PH_RINGAN_HASIL}`;

                        $("#BKF_PH_RINGAN_HASIL").html(BKF_PH_RINGAN_HASIL)
                
                        var BKF_PH_SEDANG = `<p>${data['LPH[SEDANG]']} M2 x <span class="font-bold">Rp.${result.LUAS_HSEDANG}</span> </p>`;
                        $("#BKF_PH_SEDANG").html(BKF_PH_SEDANG)

                        var BKF_PH_SEDANG_HASIL = data['LPH[SEDANG]'] * result.LUAS_HSEDANG

                        JUM3 += BKF_PH_SEDANG_HASIL

                        BKF_PH_SEDANG_HASIL = `Rp.${BKF_PH_SEDANG_HASIL}`;

                        $("#BKF_PH_SEDANG_HASIL").html(BKF_PH_SEDANG_HASIL)
                
                        var BKF_PH_BERAT = `<p>${data['LPH[BERAT]']} M2 x <span class="font-bold">Rp.${result.LUAS_HBERAT}</span> </p>`;
                        $("#BKF_PH_BERAT").html(BKF_PH_BERAT)

                        var BKF_PH_BERAT_HASIL = data['LPH[BERAT]'] * result.LUAS_HBERAT

                        JUM3 += BKF_PH_BERAT_HASIL

                        BKF_PH_BERAT_HASIL = `Rp.${BKF_PH_BERAT_HASIL}`;

                        $("#BKF_PH_BERAT_HASIL").html(BKF_PH_BERAT_HASIL)
                
                        var BKF_PH_PL = `<p>${data['LPH[P_LANTAI]']} M2 x <span class="font-bold">Rp.${result.LUAS_HPENUTUP}</span> </p>`;
                        $("#BKF_PH_PL").html(BKF_PH_PL)

                        var BKF_PH_PL_HASIL = data['LPH[P_LANTAI]'] * result.LUAS_HPENUTUP

                        JUM3 += BKF_PH_PL_HASIL

                        BKF_PH_PL_HASIL = `Rp.${BKF_PH_PL_HASIL}`;

                        $("#BKF_PH_PL_HASIL").html(BKF_PH_PL_HASIL)

                    
                    // GENSET

                        var BKF_KG = `<p>${data['OTHERS[K_GENSET]']} M2 x <span class="font-bold">Rp.${result.JUM_GENSET}</span> </p>`;
                        $("#BKF_KG").html(BKF_KG)

                        var BKF_KG_HASIL = data['OTHERS[K_GENSET]'] * result.JUM_GENSET

                        JUM3 += BKF_KG_HASIL

                        BKF_KG_HASIL = `Rp.${BKF_KG_HASIL}`;

                        $("#BKF_KG_HASIL").html(BKF_KG_HASIL)
                    
                    // SUMUR

                        var BKF_SA = `<p>${data['OTHERS[DLM_SUMUR_A]']} M2 x <span class="font-bold">Rp.${result.DALAM_SUMUR}</span> </p>`;
                        $("#BKF_SA").html(BKF_SA)

                        var BKF_SA_HASIL = data['OTHERS[DLM_SUMUR_A]'] * result.DALAM_SUMUR

                        JUM3 += BKF_SA_HASIL

                        BKF_SA_HASIL = `Rp.${BKF_SA_HASIL}`;

                        $("#BKF_SA_HASIL").html(BKF_SA_HASIL)
                    
                    // PABX

                        var BKF_JSP = `<p>${data['OTHERS[JLH_S_PABX]']} Sal x <span class="font-bold">Rp.${result.JUM_PABX}</span> </p>`;
                        $("#BKF_JSP").html(BKF_JSP)

                        var BKF_JSP_HASIL = data['OTHERS[JLH_S_PABX]'] * result.JUM_PABX

                        JUM3 += BKF_JSP_HASIL

                        BKF_JSP_HASIL = `Rp.${BKF_JSP_HASIL}`;

                        $("#BKF_JSP_HASIL").html(BKF_JSP_HASIL)
                    
                    // KOLAM

                        var BKF_KR = `<p>${data['KOLAM_RENANG[LUAS]']} M2 x <span class="font-bold">Rp.${result.Luas_Kolam}</span> </p>`;
                        $("#BKF_KR").html(BKF_KR)

                        var BKF_KR_HASIL = data['KOLAM_RENANG[LUAS]'] * result.Luas_Kolam

                        JUM3 += BKF_KR_HASIL

                        BKF_KR_HASIL = `Rp.${BKF_KR_HASIL}`;

                        $("#BKF_KR_HASIL").html(BKF_KR_HASIL)
                    
                    // PEMADAM

                        var BKF_PK_HYDRAN = `<p>${data['LUAS_BNG']} M2 x <span class="font-bold">Rp.${result.BAKAR_H}</span> </p>`;
                        $("#BKF_PK_HYDRAN").html(BKF_PK_HYDRAN)

                        var BKF_PK_HYDRAN_HASIL = data['LUAS_BNG'] * result.BAKAR_H

                        JUM3 += BKF_PK_HYDRAN_HASIL

                        BKF_PK_HYDRAN_HASIL = `Rp.${BKF_PK_HYDRAN_HASIL}`;

                        $("#BKF_PK_HYDRAN_HASIL").html(BKF_PK_HYDRAN_HASIL)

                        var BKF_PK_SPRINGKLER = `<p>${data['LUAS_BNG']} M2 x <span class="font-bold">Rp.${result.BAKAR_S}</span> </p>`;
                        $("#BKF_PK_SPRINGKLER").html(BKF_PK_SPRINGKLER)

                        var BKF_PK_SPRINGKLER_HASIL = data['LUAS_BNG'] * result.BAKAR_S

                        JUM3 += BKF_PK_SPRINGKLER_HASIL

                        BKF_PK_SPRINGKLER_HASIL = `Rp.${BKF_PK_SPRINGKLER_HASIL}`;

                        $("#BKF_PK_SPRINGKLER_HASIL").html(BKF_PK_SPRINGKLER_HASIL)

                        var BKF_PK_FIRE_AL = `<p>${data['LUAS_BNG']} M2 x <span class="font-bold">Rp.${result.BAKAR_F}</span> </p>`;
                        $("#BKF_PK_FIRE_AL").html(BKF_PK_FIRE_AL)

                        var BKF_PK_FIRE_AL_HASIL = data['LUAS_BNG'] * result.BAKAR_F

                        JUM3 += BKF_PK_FIRE_AL_HASIL

                        BKF_PK_FIRE_AL_HASIL = `Rp.${BKF_PK_FIRE_AL_HASIL}`;

                        $("#BKF_PK_FIRE_AL_HASIL").html(BKF_PK_FIRE_AL_HASIL)

                    // LIFT

                        var BKF_LIFT_PENUMPANG = `<p>${data['J_LIFT[PENUMPANG]']} Unit x <span class="font-bold">Rp.${result.JLIFT[0]}</span> </p>`;
                        $("#BKF_LIFT_PENUMPANG").html(BKF_LIFT_PENUMPANG)

                        var BKF_LIFT_PENUMPANG_HASIL = data['J_LIFT[PENUMPANG]'] * result.JLIFT[0]

                        JUM3 += BKF_LIFT_PENUMPANG_HASIL

                        BKF_LIFT_PENUMPANG_HASIL = `Rp.${BKF_LIFT_PENUMPANG_HASIL}`;

                        $("#BKF_LIFT_PENUMPANG_HASIL").html(BKF_LIFT_PENUMPANG_HASIL)

                        var BKF_LIFT_KAPSUL = `<p>${data['J_LIFT[KAPSUL]']} Unit x <span class="font-bold">Rp.${result.JLIFT[1]}</span> </p>`;
                        $("#BKF_LIFT_KAPSUL").html(BKF_LIFT_KAPSUL)

                        var BKF_LIFT_KAPSUL_HASIL = data['J_LIFT[KAPSUL]'] * result.JLIFT[1]

                        JUM3 += BKF_LIFT_KAPSUL_HASIL

                        BKF_LIFT_KAPSUL_HASIL = `Rp.${BKF_LIFT_KAPSUL_HASIL}`;

                        $("#BKF_LIFT_KAPSUL_HASIL").html(BKF_LIFT_KAPSUL_HASIL)

                        var BKF_LIFT_BARANG = `<p>${data['J_LIFT[BARANG]']} Unit x <span class="font-bold">Rp.${result.JLIFT[2]}</span> </p>`;
                        $("#BKF_LIFT_BARANG").html(BKF_LIFT_BARANG)

                        var BKF_LIFT_BARANG_HASIL = data['J_LIFT[BARANG]'] * result.JLIFT[2]

                        JUM3 += BKF_LIFT_BARANG_HASIL

                        BKF_LIFT_BARANG_HASIL = `Rp.${BKF_LIFT_BARANG_HASIL}`;

                        $("#BKF_LIFT_BARANG_HASIL").html(BKF_LIFT_BARANG_HASIL)

                    // ESKALATOR

                        var BKF_ESKALATOR_LD = `<p>${data['LTB[LT]']} Unit x <span class="font-bold">Rp.${result.LEBAR_TANGGA1}</span> </p>`;
                        $("#BKF_ESKALATOR_LD").html(BKF_ESKALATOR_LD)

                        var BKF_ESKALATOR_LD_HASIL = data['LTB[LT]'] * result.LEBAR_TANGGA1

                        JUM3 += BKF_ESKALATOR_LD_HASIL

                        BKF_ESKALATOR_LD_HASIL = `Rp.${BKF_ESKALATOR_LD_HASIL}`;

                        $("#BKF_ESKALATOR_LD_HASIL").html(BKF_ESKALATOR_LD_HASIL)

                        var BKF_ESKALATOR_KD = `<p>${data['LTB[MT]']} Unit x <span class="font-bold">Rp.${result.LEBAR_TANGGA2}</span> </p>`;
                        $("#BKF_ESKALATOR_KD").html(BKF_ESKALATOR_KD)

                        var BKF_ESKALATOR_KD_HASIL = data['LTB[MT]'] * result.LEBAR_TANGGA2

                        JUM3 += BKF_ESKALATOR_KD_HASIL

                        BKF_ESKALATOR_KD_HASIL = `Rp.${BKF_ESKALATOR_KD_HASIL}`;

                        $("#BKF_ESKALATOR_KD_HASIL").html(BKF_ESKALATOR_KD_HASIL)

                    // LAPANGAN TENIS

                        // Dengan Lampu
                        
                            var BKF_LT_DL_BETON = `<p>${data['JLT_DL[BETON]']} Ban x <span class="font-bold">Rp.${result.JUM_LAP_BETON1}</span> </p>`;
                            $("#BKF_LT_DL_BETON").html(BKF_LT_DL_BETON)

                            var BKF_LT_DL_BETON_HASIL = data['JLT_DL[BETON]'] * result.JUM_LAP_BETON1

                            JUM3 += BKF_LT_DL_BETON_HASIL

                            BKF_LT_DL_BETON_HASIL = `Rp.${BKF_LT_DL_BETON_HASIL}`;

                            $("#BKF_LT_DL_BETON_HASIL").html(BKF_LT_DL_BETON_HASIL)
                            
                            var BKF_LT_DL_ASPAL = `<p>${data['JLT_DL[ASPAL]']} Ban x <span class="font-bold">Rp.${result.JUM_LAP_ASPAL1}</span> </p>`;
                            $("#BKF_LT_DL_ASPAL").html(BKF_LT_DL_ASPAL)

                            var BKF_LT_DL_ASPAL_HASIL = data['JLT_DL[ASPAL]'] * result.JUM_LAP_ASPAL1

                            JUM3 += BKF_LT_DL_ASPAL_HASIL

                            BKF_LT_DL_ASPAL_HASIL = `Rp.${BKF_LT_DL_ASPAL_HASIL}`;

                            $("#BKF_LT_DL_ASPAL_HASIL").html(BKF_LT_DL_ASPAL_HASIL)
                            
                            var BKF_LT_DL_TANAH = `<p>${data['JLT_DL[TR]']} Ban x <span class="font-bold">Rp.${result.JUM_LAP_RUMPUT1}</span> </p>`;
                            $("#BKF_LT_DL_TANAH").html(BKF_LT_DL_TANAH)

                            var BKF_LT_DL_TANAH_HASIL = data['JLT_DL[TR]'] * result.JUM_LAP_RUMPUT1

                            JUM3 += BKF_LT_DL_TANAH_HASIL

                            BKF_LT_DL_TANAH_HASIL = `Rp.${BKF_LT_DL_TANAH_HASIL}`;

                            $("#BKF_LT_DL_TANAH_HASIL").html(BKF_LT_DL_TANAH_HASIL)

                        // Tanpa Lampu

                            var BKF_LT_TL_BETON = `<p>${data['JLT_TL[BETON]']} Ban x <span class="font-bold">Rp.${result.JUM_LAP_BETON2}</span> </p>`;
                            $("#BKF_LT_TL_BETON").html(BKF_LT_TL_BETON)

                            var BKF_LT_TL_BETON_HASIL = data['JLT_TL[BETON]'] * result.JUM_LAP_BETON2

                            JUM3 += BKF_LT_TL_BETON_HASIL

                            BKF_LT_TL_BETON_HASIL = `Rp.${BKF_LT_TL_BETON_HASIL}`;

                            $("#BKF_LT_TL_BETON_HASIL").html(BKF_LT_TL_BETON_HASIL)
                            
                            var BKF_LT_TL_ASPAL = `<p>${data['JLT_TL[ASPAL]']} Ban x <span class="font-bold">Rp.${result.JUM_LAP_ASPAL2}</span> </p>`;
                            $("#BKF_LT_TL_ASPAL").html(BKF_LT_TL_ASPAL)

                            var BKF_LT_TL_ASPAL_HASIL = data['JLT_TL[ASPAL]'] * result.JUM_LAP_ASPAL2

                            JUM3 += BKF_LT_TL_ASPAL_HASIL

                            BKF_LT_TL_ASPAL_HASIL = `Rp.${BKF_LT_TL_ASPAL_HASIL}`;

                            $("#BKF_LT_TL_ASPAL_HASIL").html(BKF_LT_TL_ASPAL_HASIL)
                            
                            var BKF_LT_TL_TANAH = `<p>${data['JLT_TL[TR]']} Ban x <span class="font-bold">Rp.${result.JUM_LAP_RUMPUT2}</span> </p>`;
                            $("#BKF_LT_TL_TANAH").html(BKF_LT_TL_TANAH)

                            var BKF_LT_TL_TANAH_HASIL = data['JLT_TL[TR]'] * result.JUM_LAP_RUMPUT2

                            JUM3 += BKF_LT_TL_TANAH_HASIL

                            BKF_LT_TL_TANAH_HASIL = `Rp.${BKF_LT_TL_TANAH_HASIL}`;

                            $("#BKF_LT_TL_TANAH_HASIL").html(BKF_LT_TL_TANAH_HASIL)

                    // AC

                        if(data['KD_JPB'] == "02"){
                            var BKF_AC_BNG_LAIN = `<p>${0} M2 x <span class="font-bold">Rp.${result.Nil_AC_Central[1]}</span> </p>`;
                            $("#BKF_AC_BNG_LAIN").html(BKF_AC_BNG_LAIN)

                            var BKF_AC_BNG_LAIN_HASIL = 0 * result.Nil_AC_Central[1]

                            JUM3 += BKF_AC_BNG_LAIN_HASIL

                            BKF_AC_BNG_LAIN_HASIL = `Rp.${BKF_AC_BNG_LAIN_HASIL}`;

                            $("#BKF_AC_BNG_LAIN_HASIL").html(BKF_AC_BNG_LAIN_HASIL)

                            $("#AC1").prepend("03 ")

                        }else if(data['KD_JPB'] == "04"){
                            var BKF_AC_BNG_LAIN = `<p>${0} M2 x <span class="font-bold">Rp.${result.Nil_AC_Central[4]}</span> </p>`;
                            $("#BKF_AC_BNG_LAIN").html(BKF_AC_BNG_LAIN)

                            var BKF_AC_BNG_LAIN_HASIL = 0 * result.Nil_AC_Central[4]

                            JUM3 += BKF_AC_BNG_LAIN_HASIL

                            BKF_AC_BNG_LAIN_HASIL = `Rp.${BKF_AC_BNG_LAIN_HASIL}`;

                            $("#BKF_AC_BNG_LAIN_HASIL").html(BKF_AC_BNG_LAIN_HASIL)

                            $("#AC1").prepend("06 ")
                        }else if(data['KD_JPB'] == "05"){
                            var BKF_AC_KAMAR = `<p>${0} M2 x <span class="font-bold">Rp.${result.Nil_AC_Central[5]}</span> </p>`;
                            $("#BKF_AC_KAMAR").html(BKF_AC_KAMAR)

                            var BKF_AC_KAMAR_HASIL = 0 * result.Nil_AC_Central[5]

                            JUM3 += BKF_AC_KAMAR_HASIL

                            BKF_AC_KAMAR_HASIL = `Rp.${BKF_AC_KAMAR_HASIL}`;

                            $("#BKF_AC_KAMAR_HASIL").html(BKF_AC_KAMAR_HASIL)

                            $("#AC2").prepend("07 ")

                            var BKF_AC_RUANGAN_LAIN = `<p>${0} M2 x <span class="font-bold">Rp.${result.Nil_AC_Central[6]}</span> </p>`;
                            $("#BKF_AC_RUANGAN_LAIN").html(BKF_AC_RUANGAN_LAIN)

                            var BKF_AC_RUANGAN_LAIN_HASIL = 0 * result.Nil_AC_Central[6]

                            JUM3 += BKF_AC_RUANGAN_LAIN_HASIL

                            BKF_AC_RUANGAN_LAIN_HASIL = `Rp.${BKF_AC_RUANGAN_LAIN_HASIL}`;

                            $("#BKF_AC_RUANGAN_LAIN_HASIL").html(BKF_AC_RUANGAN_LAIN_HASIL)

                            $("#AC3").prepend("08 ")

                        }else if(data['KD_JPB'] == "07"){
                            var BKF_AC_KAMAR = `<p>${0} M2 x <span class="font-bold">Rp.${result.Nil_AC_Central[2]}</span> </p>`;
                            $("#BKF_AC_KAMAR").html(BKF_AC_KAMAR)

                            var BKF_AC_KAMAR_HASIL = 0 * result.Nil_AC_Central[2]

                            JUM3 += BKF_AC_KAMAR_HASIL

                            BKF_AC_KAMAR_HASIL = `Rp.${BKF_AC_KAMAR_HASIL}`;

                            $("#BKF_AC_KAMAR_HASIL").html(BKF_AC_KAMAR_HASIL)

                            $("#AC2").prepend("04 ")

                            var BKF_AC_RUANGAN_LAIN = `<p>${0} M2 x <span class="font-bold">Rp.${result.Nil_AC_Central[3]}</span> </p>`;
                            $("#BKF_AC_RUANGAN_LAIN").html(BKF_AC_RUANGAN_LAIN)

                            var BKF_AC_RUANGAN_LAIN_HASIL = 0 * result.Nil_AC_Central[3]

                            JUM3 += BKF_AC_RUANGAN_LAIN_HASIL

                            BKF_AC_RUANGAN_LAIN_HASIL = `Rp.${BKF_AC_RUANGAN_LAIN_HASIL}`;

                            $("#BKF_AC_RUANGAN_LAIN_HASIL").html(BKF_AC_RUANGAN_LAIN_HASIL)

                            $("#AC3").prepend("05 ")
                        }else if(data['KD_JPB'] == "13"){
                            var BKF_AC_KAMAR = `<p>${0} M2 x <span class="font-bold">Rp.${result.Nil_AC_Central[7]}</span> </p>`;
                            $("#BKF_AC_KAMAR").html(BKF_AC_KAMAR)

                            var BKF_AC_KAMAR_HASIL = 0 * result.Nil_AC_Central[7]

                            JUM3 += BKF_AC_KAMAR_HASIL

                            BKF_AC_KAMAR_HASIL = `Rp.${BKF_AC_KAMAR_HASIL}`;

                            $("#BKF_AC_KAMAR_HASIL").html(BKF_AC_KAMAR_HASIL)

                            $("#AC2").prepend("09 ")

                            var BKF_AC_RUANGAN_LAIN = `<p>${0} M2 x <span class="font-bold">Rp.${result.Nil_AC_Central[8]}</span> </p>`;
                            $("#BKF_AC_RUANGAN_LAIN").html(BKF_AC_RUANGAN_LAIN)

                            var BKF_AC_RUANGAN_LAIN_HASIL = 0 * result.Nil_AC_Central[8]

                            JUM3 += BKF_AC_RUANGAN_LAIN_HASIL

                            BKF_AC_RUANGAN_LAIN_HASIL = `Rp.${BKF_AC_RUANGAN_LAIN_HASIL}`;

                            $("#BKF_AC_RUANGAN_LAIN_HASIL").html(BKF_AC_RUANGAN_LAIN_HASIL)

                            $("#AC3").prepend("10 ")
                        }else{

                            if(data['L_AC[AC_CENTRAL]'] == "01"){

                                var BKF_AC_BNG_LAIN = `<p>${data['LUAS_BNG']} M2 x <span class="font-bold">Rp.${result.JUM_AC_CENTRAL}</span> </p>`;
                                $("#BKF_AC_BNG_LAIN").html(BKF_AC_BNG_LAIN)

                                var BKF_AC_BNG_LAIN_HASIL = data['LUAS_BNG'] * result.JUM_AC_CENTRAL

                                JUM3 += BKF_AC_BNG_LAIN_HASIL

                                BKF_AC_BNG_LAIN_HASIL = `Rp.${BKF_AC_BNG_LAIN_HASIL}`;

                                $("#BKF_AC_BNG_LAIN_HASIL").html(BKF_AC_BNG_LAIN_HASIL)

                                $("#AC1").prepend("11 ")
                            }else{
                                var BKF_AC_BNG_LAIN = `<p>${0} M2 x <span class="font-bold">Rp.${0}</span> </p>`;
                                $("#BKF_AC_BNG_LAIN").html(BKF_AC_BNG_LAIN)

                                var BKF_AC_BNG_LAIN_HASIL = `Rp.${0 * 0}`;
                                $("#BKF_AC_BNG_LAIN_HASIL").html(BKF_AC_BNG_LAIN_HASIL)

                                $("#AC1").prepend("00 ")
                            }


                            var BKF_AC_KAMAR = `<p>${0} M2 x <span class="font-bold">Rp.${0}</span> </p>`;
                            $("#BKF_AC_KAMAR").html(BKF_AC_KAMAR)

                            var BKF_AC_KAMAR_HASIL = `Rp.${0 * 0}`;
                            $("#BKF_AC_KAMAR_HASIL").html(BKF_AC_KAMAR_HASIL)

                            $("#AC2").prepend("00 ")

                            var BKF_AC_RUANGAN_LAIN = `<p>${0} M2 x <span class="font-bold">Rp.${0}</span> </p>`;
                            $("#BKF_AC_RUANGAN_LAIN").html(BKF_AC_RUANGAN_LAIN)

                            var BKF_AC_RUANGAN_LAIN_HASIL = `Rp.${0 * 0}`;
                            $("#BKF_AC_RUANGAN_LAIN_HASIL").html(BKF_AC_RUANGAN_LAIN_HASIL)

                            $("#AC3").prepend("00 ")
                        }
                        
                        if(data['KD_JPB'] == "07"){
                            var BKF_AC_BOILER = `<p>${0} M2 x <span class="font-bold">Rp.${result.Nil_Boiler_Ht}</span> </p>`;
                            $("#BKF_AC_BOILER").html(BKF_AC_BOILER)

                            var BKF_AC_BOILER_HASIL = 0 * result.Nil_Boiler_Ht

                            JUM3 += BKF_AC_BOILER_HASIL

                            BKF_AC_BOILER_HASIL = `Rp.${BKF_AC_BOILER_HASIL}`;

                            $("#BKF_AC_BOILER_HASIL").html(BKF_AC_BOILER_HASIL)

                            $("#LBOILER").prepend("43 ")
                        }else if(data['KD_JPB'] == "13"){
                            var BKF_AC_BOILER = `<p>${0} M2 x <span class="font-bold">Rp.${result.Nil_Boiler_Ap}</span> </p>`;
                            $("#BKF_AC_BOILER").html(BKF_AC_BOILER)

                            var BKF_AC_BOILER_HASIL = 0 * result.Nil_Boiler_Ap

                            JUM3 += BKF_AC_BOILER_HASIL

                            BKF_AC_BOILER_HASIL = `Rp.${BKF_AC_BOILER_HASIL}`;

                            $("#BKF_AC_BOILER_HASIL").html(BKF_AC_BOILER_HASIL)

                            $("#LBOILER").prepend("45 ")
                        }else{
                            var BKF_AC_BOILER = `<p>${0} M2 x <span class="font-bold">Rp.${0}</span> </p>`;
                            $("#BKF_AC_BOILER").html(BKF_AC_BOILER)

                            var BKF_AC_BOILER_HASIL = 0 * 0

                            JUM3 += BKF_AC_BOILER_HASIL

                            BKF_AC_BOILER_HASIL = `Rp.${BKF_AC_BOILER_HASIL}`;

                            $("#BKF_AC_BOILER_HASIL").html(BKF_AC_BOILER_HASIL)

                            $("#LBOILER").prepend("00 ")
                        }
                        
                    var BKF_TOTAL = `Rp.${JUM3}`;
                    $("#BKF_TOTAL").html(BKF_TOTAL)

                // PENYUSUTAN

                    var JUM4 = 0

                    var PENYUSUTAN_NILAI = `<p>${result.xSUSUT} % x <span class="font-bold">Rp.${JUM1+JUM2+JUM3}</span> </p>`;
                    $("#PENYUSUTAN_NILAI").html(PENYUSUTAN_NILAI)

                    var PENYUSUTAN_NILAI_HASIL = result.xSUSUT * (JUM1+JUM2+JUM3)

                    JUM4 += PENYUSUTAN_NILAI_HASIL

                    PENYUSUTAN_NILAI_HASIL = `Rp.${PENYUSUTAN_NILAI_HASIL}`;
                        
                    $("#PENYUSUTAN_NILAI_HASIL").html(PENYUSUTAN_NILAI_HASIL)

                    var PENYUSUTAN_TOTAL = `Rp.${JUM4}`;
                    $("#PENYUSUTAN_TOTAL").html(PENYUSUTAN_TOTAL)

                // BKF (TD)

                    var JUM5 = 0

                    var BKF_TD_DL = `<p>${data['L_AC[DAYA_LISTRIK]']} KVa x <span class="font-bold">Rp.${result.DAYA_LISTRIK}</span> </p>`;
                    $("#BKF_TD_DL").html(BKF_TD_DL)

                    var BKF_TD_DL_HASIL = data['L_AC[DAYA_LISTRIK]'] * result.DAYA_LISTRIK

                    JUM5 += BKF_TD_DL_HASIL

                    BKF_TD_DL_HASIL = `Rp.${BKF_TD_DL_HASIL}`;
                    
                    $("#BKF_TD_DL_HASIL").html(BKF_TD_DL_HASIL)

                    var BKF_TD_JAS = `<p>${data['L_AC[AC_SPLIT]']} Buah x <span class="font-bold">Rp.${result.JUM_SPLIT}</span> </p>`;
                    $("#BKF_TD_JAS").html(BKF_TD_JAS)

                    var BKF_TD_JAS_HASIL = data['L_AC[AC_SPLIT]'] * result.JUM_SPLIT

                    JUM5 += BKF_TD_JAS_HASIL

                    BKF_TD_JAS_HASIL = `Rp.${BKF_TD_JAS_HASIL}`;
                    
                    $("#BKF_TD_JAS_HASIL").html(BKF_TD_JAS_HASIL)

                    var BKF_TD_JAW = `<p>${data['L_AC[AC_WINDOW]']} Buah x <span class="font-bold">Rp.${result.JUM_WINDOW}</span> </p>`;
                    $("#BKF_TD_JAW").html(BKF_TD_JAW)

                    var BKF_TD_JAW_HASIL = data['L_AC[AC_WINDOW]'] * result.JUM_WINDOW

                    JUM5 += BKF_TD_JAW_HASIL

                    BKF_TD_JAW_HASIL = `Rp.${BKF_TD_JAW_HASIL}`;
                    
                    $("#BKF_TD_JAW_HASIL").html(BKF_TD_JAW_HASIL)

                    var BKF_TD_TOTAL = `Rp.${JUM5}`;
                    $("#BKF_TD_TOTAL").html(BKF_TD_TOTAL)

                //LAST
                    
                    var NB_RP_CALC = (JUM1 + JUM2 + JUM3 + JUM5) - JUM4;
                    var NB_RP = `Rp.${NB_RP_CALC}`;
                    $("#NB_RP").html(NB_RP)
                    
                    var NI_RP = data['NILAI_INDIVIDU']
                    NI_RP = `Rp.${NI_RP}`;
                    $("#NI_RP").html(NI_RP)
                    
                    var NB_M2 = NB_RP_CALC / data['LUAS_BNG']
                    $("#NB_M2").html(NB_M2)
                
                $("#btn-modal-proses").click(function(){
                    console.log("PROSESS")
                    var form = $(document.forms.bangunan)

                    form.append(`<input type='hidden' name='BKF_PAGAR_HASIL' value='${BKF_PAGAR_HASIL}' >`)

                    form.append(`<input type='hidden' name='BKF_PH_RINGAN_HASIL' value='${BKF_PH_RINGAN_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_PH_SEDANG_HASIL' value='${BKF_PH_SEDANG_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_PH_BERAT_HASIL' value='${BKF_PH_BERAT_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_PH_PL_HASIL' value='${BKF_PH_PL_HASIL}' >`)

                    form.append(`<input type='hidden' name='BKF_KG_HASIL' value='${BKF_KG_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_SA_HASIL' value='${BKF_SA_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_JSP_HASIL' value='${BKF_JSP_HASIL}' >`)

                    form.append(`<input type='hidden' name='BKF_KR_HASIL' value='${BKF_KR_HASIL}' >`)

                    form.append(`<input type='hidden' name='BKF_PK_HYDRAN_HASIL' value='${BKF_PK_HYDRAN_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_PK_SPRINGKLER_HASIL' value='${BKF_PK_SPRINGKLER_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_PK_FIRE_AL_HASIL' value='${BKF_PK_FIRE_AL_HASIL}' >`)

                    form.append(`<input type='hidden' name='BKF_LT_DL_BETON_HASIL' value='${BKF_LT_DL_BETON_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_LT_DL_ASPAL_HASIL' value='${BKF_LT_DL_ASPAL_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_LT_DL_TANAH_HASIL' value='${BKF_LT_DL_TANAH_HASIL}' >`)

                    form.append(`<input type='hidden' name='BKF_LT_TL_BETON_HASIL' value='${BKF_LT_TL_BETON_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_LT_TL_ASPAL_HASIL' value='${BKF_LT_TL_ASPAL_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_LT_TL_TANAH_HASIL' value='${BKF_LT_TL_TANAH_HASIL}' >`)

                    form.append(`<input type='hidden' name='BKF_LIFT_PENUMPANG_HASIL' value='${BKF_LIFT_PENUMPANG_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_LIFT_KAPSUL_HASIL' value='${BKF_LIFT_KAPSUL_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_LIFT_BARANG_HASIL' value='${BKF_LIFT_BARANG_HASIL}' >`)

                    form.append(`<input type='hidden' name='BKF_ESKALATOR_KD_HASIL' value='${BKF_ESKALATOR_KD_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_ESKALATOR_LD_HASIL' value='${BKF_ESKALATOR_LD_HASIL}' >`)

                    form.append(`<input type='hidden' name='BKF_AC_BNG_LAIN_HASIL' value='${BKF_AC_BNG_LAIN_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_AC_KAMAR_HASIL' value='${BKF_AC_KAMAR_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_AC_RUANGAN_LAIN_HASIL' value='${BKF_AC_RUANGAN_LAIN_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_AC_BOILER_HASIL' value='${BKF_AC_BOILER_HASIL}' >`)

                    form.append(`<input type='hidden' name='BKF_TD_DL_HASIL' value='${BKF_TD_DL_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_TD_JAS_HASIL' value='${BKF_TD_JAS_HASIL}' >`)
                    form.append(`<input type='hidden' name='BKF_TD_JAW_HASIL' value='${BKF_TD_JAW_HASIL}' >`)

                    var AC1 = $("#AC1").text()
                    var AC2 = $("#AC2").text()
                    var AC3 = $("#AC3").text()
                    var LBOILER = $("#LBOILER").text()

                    var FLK69 = $("#BKF_AC_BNG_LAIN").text()
                    var FLK72 = $("#BKF_AC_KAMAR").text()
                    var FLK75 = $("#BKF_AC_RUANGAN_LAIN").text()
                    var FLK78 = $("#BKF_AC_BOILER").text()

                    FLK69 = FLK69.split("M2")
                    FLK69 = FLK69[0]

                    FLK72 = FLK72.split("M2")
                    FLK72 = FLK72[0]

                    FLK75 = FLK75.split("M2")
                    FLK75 = FLK75[0]

                    FLK78 = FLK78.split("M2")
                    FLK78 = FLK78[0]

                    form.append(`<input type='hidden' name='AC1' value='${AC1}' >`)
                    form.append(`<input type='hidden' name='AC2' value='${AC2}' >`)
                    form.append(`<input type='hidden' name='AC3' value='${AC3}' >`)
                    form.append(`<input type='hidden' name='LBOILER' value='${LBOILER}' >`)

                    form.append(`<input type='hidden' name='FLK69' value='${FLK69}' >`)
                    form.append(`<input type='hidden' name='FLK72' value='${FLK72}' >`)
                    form.append(`<input type='hidden' name='FLK75' value='${FLK75}' >`)
                    form.append(`<input type='hidden' name='FLK78' value='${FLK78}' >`)

                    form.append(`<input type='hidden' name='JUM1' value='${JUM1}' >`)
                    form.append(`<input type='hidden' name='JUM2' value='${JUM2}' >`)
                    form.append(`<input type='hidden' name='JUM3' value='${JUM3}' >`)
                    form.append(`<input type='hidden' name='JUM4' value='${JUM4}' >`)
                    form.append(`<input type='hidden' name='JUM5' value='${JUM5}' >`)

                    form.append(`<input type='hidden' name='tTotal1' value='${NB_RP_CALC}' >`)

                    form.append(`<input type='hidden' name='xSUSUT' value='${result.xSUSUT}' >`)
                    form.append(`<input type='hidden' name='nTipe_K' value='${result.nTipe_K}' >`)
                    form.append(`<input type='hidden' name='update' value='true' >`)

                    var c = confirm("Apakah Anda Yakin ?")

                    if(c){
                        bangunanForm.submit()
                    }
                })

            }else{
                bangunanForm.reportValidity();
            }

        // }


    })
      
</script>

<?php load('builder/partials/bottom') ?>
