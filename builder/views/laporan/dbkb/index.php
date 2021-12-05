<?php load('builder/partials/top');?>

<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">Cetak DBKB</h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <form action="index.php" onsubmit="doSubmit(this); return false;">
            <input type="hidden" name="page" value="builder/laporan/dbkb/results">
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
                <input type="radio" name="type" value="bangunan_standard" id="bangunan_standard">
                <label for="bangunan_standard">Bangunan Standard</label>
            </div>

            <div class="form-group mb-2">
                <input type="radio" name="type" value="perkantoran_swasta" id="perkantoran_swasta">
                <label for="perkantoran_swasta">Perkantoran Swasta</label>
            </div>

            <div class="form-group mb-2">
                <input type="radio" name="type" value="pabrik" id="pabrik">
                <label for="pabrik">Pabrik</label>
            </div>

            <div class="form-group mb-2">
                <input type="radio" name="type" value="pertokoan" id="pertokoan">
                <label for="pertokoan">Pertokoan</label>
            </div>

            <div class="form-group mb-2">
                <input type="radio" name="type" value="rumah_sakit" id="rumah_sakit">
                <label for="rumah_sakit">Rumah Sakit/Klinik</label>
            </div>

            <div class="form-group mb-2">
                <input type="radio" name="type" value="olahraga" id="olahraga">
                <label for="olahraga">Olahraga/Rekreai dan Bangunan Parkir</label>
            </div>

            <div class="form-group mb-2">
                <input type="radio" name="type" value="hotel" id="hotel">
                <label for="hotel">Hotel/Wisma</label>
            </div>

            <div class="form-group mb-2">
                <input type="radio" name="type" value="bengkel" id="bengkel">
                <label for="bengkel">Bengkel/Gedung/Pertanian</label>
            </div>

            <div class="form-group mb-2">
                <input type="radio" name="type" value="apartemen" id="apartemen">
                <label for="apartemen">Apartemen</label>
            </div>

            <div class="form-group mb-2">
                <input type="radio" name="type" value="kanopi" id="kanopi">
                <label for="kanopi">Kanopi Pompa Bensin, Daya Dukung dan Mezanin</label>
            </div>

            <div class="form-group mb-2">
                <input type="radio" name="type" value="tangki_minyak" id="tangki_minyak">
                <label for="tangki_minyak">Tangki Minyak</label>
            </div>

            <div class="form-group mb-2">
                <input type="radio" name="type" value="gedung_sekolah" id="gedung_sekolah">
                <label for="gedung_sekolah">Gedung Sekolah</label>
            </div>

            <div class="form-group mb-2">
                <input type="radio" name="type" value="fasilitas1" id="fasilitas1">
                <label for="fasilitas1">Fasilitas I</label>
            </div>

            <div class="form-group mb-2">
                <input type="radio" name="type" value="fasilitas2" id="fasilitas2">
                <label for="fasilitas2">Fasilitas II</label>
            </div>

            <div class="form-group mb-2">
                <input type="radio" name="type" value="fasilitas3" id="fasilitas3">
                <label for="fasilitas3">Fasilitas III</label>
            </div>

            <div class="form-group mb-2">
                <input type="radio" name="type" value="material" id="material">
                <label for="material">Material</label>
            </div>

            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" name="cetak" value="cetak">Tampilkan</button>
            </div>
        </form>
    </div>
</div>

<script>

    function doSubmit(form){
        document.querySelector('button[name=cetak]').disabled = true
        document.querySelector('button[name=cetak]').innerHTML = "Memproses"
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);

        fetch('index.php?'+params.toString()+'&mode=cek_cetak')
        .then(res => res.json())
        .then(res => {
            if(res.status == 'fail')
            {
                alert(res.message)
            }
            else
            {
                location.href='index.php?page=builder/laporan/dbkb/cetak-all&type='+ res.type +'&tahun_pajak='+document.querySelector("select[name=tahun_pajak]").value
                document.querySelector('button[name=cetak]').disabled = false
            }
        })
    }
</script>

<?php load('builder/partials/bottom');?>