<?php load('builder/partials/top');
?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">Status Wajib Pajak</h2>
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
            <form method="post" action="index.php?page=builder/penatausahaan/status-wajib-pajak/cetak" onsubmit="check(this); return false" target="_blank">
                <div class="form-group mb-2">
                    <?php 
                    $options = [];
                    for($i=date('Y');$i>=1900;$i--) $options[] = $i;
                    $options = implode("|",$options);
                    ?>
                    <label>Tahun Pajak</label>
                    <?= Form::input('options:'.$options, 'tahun_pajak', ['class'=>"p-2 w-full border rounded"]) ?>
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
                    <button class="p-2 bg-indigo-800 text-white rounded" id="btn-login">Cetak</button>
                </div>

            </form>

            <br>

            <center>Atau Cetak Berdasarkan NOP</center>

            <form method="post" action="index.php?page=builder/penatausahaan/status-wajib-pajak/cetak" onsubmit="check(this); return false" target="_blank">
                <div class="form-group mb-2">
                    <?php 
                    $options = [];
                    for($i=date('Y');$i>=1900;$i--) $options[] = $i;
                    $options = implode("|",$options);
                    ?>
                    <label>Tahun Pajak</label>
                    <?= Form::input('options:'.$options, 'tahun_pajak', ['class'=>"p-2 w-full border rounded"]) ?>
                </div>
                <div class="form-group mb-2">
                    <label>NOP</label>
                    <input type="text" id="NOP" name="NOP" class="p-2 w-full border rounded" value="">
                </div>

                <div class="form-group mb-2">
                    <button class="p-2 bg-indigo-800 text-white rounded" id="btn-login">Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function kecamatanChange(el){
        fetch("index.php?page=builder/penatausahaan/status-wajib-pajak/index&filter-kecamatan="+el.value).then(response => response.json()).then(data => {

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

    async function check(frm){

        var formData = new FormData(frm)

        var res = await fetch(frm.action + "&check=true",{
            method:'POST',
            body:formData
        })

        var data = await res.json()

        if(data.count){
            var c = confirm("Data ditemukan! Apakah Ingin Dilanjutkan ?")

            if(c){
                frm.submit()
            }
        }else{
            alert("Tidak ada Data")
        }

    }
</script>

<?php load('builder/partials/bottom') ?>
