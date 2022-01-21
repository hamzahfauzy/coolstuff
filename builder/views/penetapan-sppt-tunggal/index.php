<?php load('builder/partials/top');
?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">Penetapan SPPT Tunggal</h2>
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
        <div class="bg-white shadow-md rounded my-6 p-8">
            <form method="post">

                <div class="form-group mb-2">
                    <label>NOP</label>
                    <input type="text" id="NOP" name="NOP" class="p-2 w-full border rounded" value="">
                </div>

                <div class="form-group mb-2">
                    <button type="button" onclick="check()" class="p-2 bg-green-800 text-white rounded">Cek</button>
                </div>

                <div class="box hidden">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group mb-2">
                            <label>Tahun</label>
                            <select class="p-2 w-full border rounded" name="YEAR" id="">
                                <option value="" selected readonly>- Pilih Tahun -</option>
                                <?php foreach($years as $Y):?>
                                    <option <?= ( $year == $Y) ? "selected" : ""?> value="<?=$Y?>"><?=$Y?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
        
                        <div class="form-group mb-2">
                            <label>No Persil</label>
                            <input type="text" id="NO_PERSIL" name="NO_PERSIL" class="p-2 w-full border rounded" value="">
                        </div>
                    </div>
    
                    <div class="grid grid-cols-2 gap-4">
    
                        <div class="form-group mb-2">
                            <label for="TGL_TEMPO">Tanggal Jatuh Tempo</label>
                            <input type="date" id="TGL_TEMPO" name="TGL_TEMPO" class="p-2 w-full border rounded" value="<?=date('Y-m-d')?>">
                        </div>
    
                        <div class="form-group mb-2">
                            <label for="TGL_TERBIT">Tanggal Terbit</label>
                            <input type="date" id="TGL_TERBIT" name="TGL_TERBIT" class="p-2 w-full border rounded" value="<?=date('Y-m-d')?>">
                        </div>
                        
                    </div>
    
                    <div class="grid grid-cols-2 gap-4">
    
                        <div class="form-group mb-2">
                            <label>Luas Bumi</label>
                            <input type="text" id="LUAS_BUMI" name="LUAS_BUMI" class="p-2 w-full border rounded" value="">
                        </div>
    
                        <div class="form-group mb-2">
                            <label>Luas Bangunan</label>
                            <input type="text" id="LUAS_BNG" name="LUAS_BNG" class="p-2 w-full border rounded" value="">
                        </div>
    
                    </div>
    
                    <div class="grid grid-cols-2 gap-4">
    
                        <div class="form-group mb-2">
                            <label>Kelas Bumi</label>
                            <input type="text" id="KELAS_BUMI" name="KELAS_BUMI" class="p-2 w-full border rounded" value="">
                        </div>
    
                        <div class="form-group mb-2">
                            <label>Kelas Bangunan</label>
                            <input type="text" id="KELAS_BNG" name="KELAS_BNG" class="p-2 w-full border rounded" value="">
                        </div>
    
                    </div>
    
                    <div class="grid grid-cols-2 gap-4">
    
                        <div class="form-group mb-2">
                            <label>NJOP Bumi</label>
                            <input type="text" id="NJOP_BUMI" name="NJOP_BUMI" class="p-2 w-full border rounded" value="">
                        </div>
    
                        <div class="form-group mb-2">
                            <label>NJOP Bangunan</label>
                            <input type="text" id="NJOP_BNG" name="NJOP_BNG" class="p-2 w-full border rounded" value="">
                        </div>
    
                    </div>
    
                    <div class="grid grid-cols-2 gap-4">
    
                        <div class="form-group mb-2">
                            <label>Total NJOP</label>
                            <input type="text" id="TOTAL_NJOP" name="TOTAL_NJOP" class="p-2 w-full border rounded" value="">
                        </div>
    
                        <div class="form-group mb-2">
                            <label>NJOPTKP</label>
                            <input type="text" id="NJOPTKP" name="NJOPTKP" class="p-2 w-full border rounded" value="">
                        </div>
    
                    </div>
    
                    <div class="grid grid-cols-2 gap-4">
    
                        <div class="form-group mb-2">
                            <label>Tarif %</label>
                            <input type="text" id="TARIF" name="TARIF" class="p-2 w-full border rounded" value="">
                        </div>
    
                        <div class="form-group mb-2">
                            <label>NJKP</label>
                            <input type="text" id="NJKP" name="NJKP" class="p-2 w-full border rounded" value="">
                        </div>
    
                    </div>
    
                    <div class="grid grid-cols-2 gap-4">
    
                        <div class="form-group mb-2">
                            <label>Faktor Pengurang</label>
                            <input type="text" id="FAKTOR_PENGURANG" name="FAKTOR_PENGURANG" onchange="faktorPengurang(this)" class="p-2 w-full border rounded" value="">
                        </div>
    
                        <div class="form-group mb-2">
                            <label>PBB</label>
                            <input type="text" id="PBB" name="PBB" class="p-2 w-full border rounded" value="">
                        </div>
    
                    </div>
    
                    <div class="form-group mb-2">
                        <label>Tempat Bayar</label>
                        <select name="KD_BAYAR" class="p-2 w-full border rounded" required>
                            <option value="" selected readonly>- Pilih Tempat Bayar -</option>
                            <?php foreach($tBayars as $bayar):?>
                                <option value="<?=$bayar['KD_TP']?>"><?=$bayar['KD_TP']." - ".$bayar['NM_TP']?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <button class="p-2 bg-indigo-800 text-white rounded" id="btn-login">Proses</button>
                    </div>
                </div>


            </form>
        </div>
    </div>
</div>

<script>
    function kecamatanChange(el){
        fetch("index.php?page=builder/penetapan-sppt-tunggal/index&filter-kecamatan="+el.value).then(response => response.json()).then(data => {

                var html = `
                        <label>Kelurahan</label>
                        <select name="KD_KELURAHAN" class="p-2 w-full border rounded" required>
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

    function check(){
        var nop = document.querySelector("[name='NOP']")
        var year = document.querySelector("select[name='YEAR']")

        fetch("index.php?page=builder/penetapan-sppt-tunggal/index&check=true&NOP="+nop.value).then(response => response.json()).then(data => {

            if(data.hasOwnProperty("data")){
                document.querySelector(".box").classList.remove("hidden")

                document.querySelector("[name='LUAS_BUMI']").value = data.data.TOTAL_LUAS_BUMI
                document.querySelector("[name='LUAS_BNG']").value = data.data.TOTAL_LUAS_BNG

                document.querySelector("[name='NJOP_BUMI']").value = data.data.NJOP_BUMI
                document.querySelector("[name='NJOP_BNG']").value = data.data.NJOP_BNG

                document.querySelector("[name='NO_PERSIL']").value = data.data.NO_PERSIL ? data.data.NO_PERSIL : "00"

                document.querySelector("[name='KELAS_BUMI']").value = data.KELAS_BUMI
                document.querySelector("[name='KELAS_BNG']").value = data.KELAS_BNG
                document.querySelector("[name='NJKP']").value = data.NJKP
                document.querySelector("[name='TARIF']").value = data.TARIF
                document.querySelector("[name='NJOPTKP']").value = data.NJOPTKP
                document.querySelector("[name='PBB']").value = data.PBB
                document.querySelector("[name='TOTAL_NJOP']").value = data.TOTAL_NJOP

                document.querySelector("[name='FAKTOR_PENGURANG']").value = data.sppt.FAKTOR_PENGURANG_SPPT
                document.querySelector("[name='KD_BAYAR']").value = data.sppt.KD_TP
            }else{
                document.querySelector(".box").classList.add("hidden")
                alert("Data Tidak Ditemukan!")
            }
        })
    } 

    function faktorPengurang(el){
        document.querySelector("[name='PBB']").value -= el.value
    }

    async function onProcess(el){

        var year = document.querySelector("select[name='YEAR']")

        var res = await fetch("index.php?page=<?=$_GET['page']?>&check=true&year="+year.value)

        var data = await res.json()

        if(data){
            var c = confirm("Data ditemukan! Apakah Ingin Dilanjutkan ?")

            if(c){
                document.forms.pbbMinimal.submit()
            }
        }else{
            alert("NJOPTKP Untuk tahun "+ year.value +" Beluma dibuat, Proses tidak akan dilanjutkan!")
        }

    }
</script>

<?php load('builder/partials/bottom') ?>
