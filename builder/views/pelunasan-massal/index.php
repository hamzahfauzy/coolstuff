<?php load('builder/partials/top');
?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">Pelunasan Massal</h2>
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
            <form id="pelunasan" method="post">

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
                    <label>Kecamatan</label>
                    <select name="KD_KECAMATAN" class="p-2 w-full border rounded" onchange="kecamatanChange(this)" required>
                        <option value="" selected readonly>- Pilih Kecamatan -</option>
                        <?php foreach($kecamatans as $kecamatan):?>
                            <option value="<?=$kecamatan['KD_KECAMATAN']?>"><?=$kecamatan['KD_KECAMATAN']." - ".$kecamatan['NM_KECAMATAN']?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group mb-2 hidden" id="kelurahan"></div>

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
                    <label for="TGL_PEMBAYARAN">Tanggal Pembayaran</label>
                    <input type="date" id="TGL_PEMBAYARAN" name="TGL_PEMBAYARAN" class="p-2 w-full border rounded">
                </div>
                
                <div class="form-group mb-2">
                    <label for="DENDA">Denda</label>
                    <input type="number" id="DENDA" name="DENDA" class="p-2 w-full border rounded">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-group mb-2">
                        <label for="TGL_PEREKAM">Tanggal Perekam</label>
                        <input type="date" id="TGL_PEREKAM" name="TGL_PEREKAM" class="p-2 w-full border rounded">
                    </div>
                    
                    <div class="form-group mb-2">
                        <label for="NIP">NIP</label>
                        <input type="number" id="NIP" name="NIP" class="p-2 w-full border rounded">
                    </div>
                </div>

                <div class="form-group mb-2">
                    <input type="checkbox" id="delete" name="delete">
                    <label for="delete">Hapus Pelunasan</label>
                </div>

                <div class="form-group mb-2">
                    <button type="button" class="p-2 bg-indigo-800 text-white rounded" onclick="onProcess(this)" id="btn-login">Proses</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function kecamatanChange(el){
        fetch("index.php?page=builder/penetapan-sppt/index&filter-kecamatan="+el.value).then(response => response.json()).then(data => {

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

    async function onProcess(el){

        var pelunasanForm = document.forms.pelunasan

        if(pelunasanForm.checkValidity()){
            var year = document.querySelector("select[name='YEAR']")
            var kecamatan = document.querySelector("select[name='KD_KECAMATAN']")
            var kelurahan = document.querySelector("select[name='KD_KELURAHAN']")

            var res = await fetch("index.php?page=<?=$_GET['page']?>&check=true&year="+year.value+"&kecamatan="+kecamatan.value+"&kelurahan="+kelurahan.value)

            var data = await res.json()

            if(data){
                var c = confirm("Data ditemukan! Apakah Ingin Dilanjutkan ?")

                if(c){
                    pelunasanForm.submit()
                }
            }else{
                alert("SPPT Belum ditetapkan proses tidak dapat dilanjutkan")
            }
        }else{
            pelunasanForm.reportValidity();
        }


    }

</script>

<?php load('builder/partials/bottom') ?>
