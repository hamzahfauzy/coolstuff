<?php load('builder/partials/top');?>

<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">Cetak Perbandingan Penilaian Bumi dan Bangunan</h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <form action="index.php" onsubmit="doSubmit(this); return false;">
            <input type="hidden" name="page" value="builder/laporan/perbandingan-penilaian-bumi-dan-bangunan/results">
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
                <select name="KD_KECAMATAN" class="p-2 w-full border rounded" onchange="kecamatanChange(this)">
                    <option value="" selected readonly>- Pilih Kecamatan -</option>
                        <option value="Semua">Semua</option>
                    <?php foreach($kecamatans as $kecamatan):?>
                        <option value="<?=$kecamatan['KD_KECAMATAN']?>"><?=$kecamatan['KD_KECAMATAN']." - ".$kecamatan['NM_KECAMATAN']?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group mb-2" id="kelurahan">
                <label>Kelurahan</label>
                <select name="KD_KELURAHAN" class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih Kelurahan -</option>
                </select>
            </div>
            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" name="cetak" value="cetak">Tampilkan</button>
            </div>
        </form>
    </div>
</div>

<script>

    function kecamatanChange(el){
        if(el.value == 'Semua')
        {
            var html = `
                        <label>Kelurahan</label>
                        <select name="KD_KELURAHAN" class="p-2 w-full border rounded" readonly>
                            <option value="Semua" selected>Semua</option>`

                html += `</select>`

                var kelurahan = document.querySelector("#kelurahan")

                kelurahan.innerHTML = html
        }
        else
        {
            fetch("index.php?page=builder/penilaian/laporan/perbandingan-penilaian-bumi-dan-bangunan/index&get-kelurahan=true&KD_KECAMATAN="+el.value).then(response => response.json()).then(data => {

                    var html = `
                            <label>Kelurahan</label>
                            <select name="KD_KELURAHAN" class="p-2 w-full border rounded">
                                <option value="Semua" selected>Semua</option>`

                    data.map(dt=>{
                        html += `<option value="${dt.KD_KELURAHAN}">${dt.KD_KELURAHAN} - ${dt.NM_KELURAHAN}</option>`
                    })

                    html += `</select>`

                    var kelurahan = document.querySelector("#kelurahan")

                    kelurahan.innerHTML = html

                    // kelurahan.classList.remove("hidden")

            }); 
        }
    }

    function doSubmit(form){
        document.querySelector('button[name=cetak]').disabled = true
        document.querySelector('button[name=cetak]').innerHTML = "Memproses"
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);

        location.href='index.php?page=builder/penilaian/laporan/perbandingan-penilaian-bumi-dan-bangunan/cetak-all&tahun_pajak='+document.querySelector("select[name=tahun_pajak]").value+'&KD_KECAMATAN='+document.querySelector("select[name=KD_KECAMATAN]").value+'&KD_KELURAHAN='+document.querySelector("select[name=KD_KELURAHAN]").value
        document.querySelector('button[name=cetak]').disabled = false
    }
</script>

<?php load('builder/partials/bottom');?>