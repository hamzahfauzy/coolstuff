<?php load('builder/partials/top');?>

<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">Cetak SSPD</h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <form action="index.php" onsubmit="doSubmit(this); return false;">
            <input type="hidden" name="page" value="builder/laporan/sspd/results">
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
            <div class="form-group mb-2">
                <label>Jumlah SPPT</label>
                <?= Form::input('text', 'jumlah_sppt', ['readonly'=>'readonly','class'=>"p-2 w-full border rounded","placeholder"=>'Jumlah SPPT']) ?>
            </div>
            <div class="form-group mb-2">
                <label>Total PBB</label>
                <?= Form::input('text', 'total_pbb', ['readonly'=>'readonly','value'=>0,'class'=>"p-2 w-full border rounded","placeholder"=>'Total PBB']) ?>
            </div>
            <div class="form-group mb-2">
                <label>Tanggal Terbit</label>
                <?= Form::input('date', 'tanggal_terbit', ['value'=>date('Y-m-d'),'readonly'=>'readonly','class'=>"p-2 w-full border rounded","placeholder"=>'Tanggal Terbit']) ?>
            </div>
            <div class="form-group mb-2">
                <label>Tanggal Cetak</label>
                <?= Form::input('date', 'tanggal_cetak', ['value'=>date('Y-m-d'),'class'=>"p-2 w-full border rounded","placeholder"=>'Tanggal Cetak']) ?>
            </div>
            <div class="form-group mb-2">
                <label>NIP Pencetak</label>
                <?= Form::input('number', 'nip_pencetak', ['class'=>"p-2 w-full border rounded","placeholder"=>'NIP Pencetak','value'=>'0']) ?>
            </div>

            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" name="cetak" value="cetak">Tampilkan</button>
            </div>
        </form>

        <br>

        <center>Atau Cetak Berdasarkan NOP</center>

        <form action="index.php" onsubmit="doSubmit(this); return false;">
            <input type="hidden" name="page" value="builder/laporan/sspd/results">

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
                <input type="text" id="NOP" name="NOP" class="p-2 w-full border rounded">
            </div>

            <div class="form-group mb-2">
                <label>Tanggal Terbit</label>
                <?= Form::input('date', 'tanggal_terbit', ['value'=>date('Y-m-d'),'readonly'=>'readonly','class'=>"p-2 w-full border rounded","placeholder"=>'Tanggal Terbit']) ?>
            </div>
            <div class="form-group mb-2">
                <label>Tanggal Cetak</label>
                <?= Form::input('date', 'tanggal_cetak', ['value'=>date('Y-m-d'),'class'=>"p-2 w-full border rounded","placeholder"=>'Tanggal Cetak']) ?>
            </div>
            <div class="form-group mb-2">
                <label>NIP Pencetak</label>
                <?= Form::input('number', 'nip_pencetak', ['class'=>"p-2 w-full border rounded","placeholder"=>'NIP Pencetak','value'=>'0']) ?>
            </div>

            <div class="form-group mb-2">
                <button class="p-2 bg-indigo-800 text-white rounded" id="btn-login">Cetak</button>
            </div>
        </form>
    </div>
</div>

<script>

     var nop = $("input[name='NOP']");

    nop.inputmask({mask:"12.12.999.999.999-9999.9"})

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
            fetch("index.php?page=builder/laporan/sspd/index&get-kelurahan=true&KD_KECAMATAN="+el.value).then(response => response.json()).then(data => {

                    var html = `
                            <label>Kelurahan</label>
                            <select name="KD_KELURAHAN" class="p-2 w-full border rounded" onchange="kelurahanChange(this)">
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

    function kelurahanChange(el){
        var kecamatan = document.querySelector("select[name='KD_KECAMATAN']")

        fetch("index.php?page=builder/laporan/sspd/index&get-jumlah-sppt=true&KD_KELURAHAN="+el.value+"&KD_KECAMATAN="+kecamatan.value).then(response => response.text()).then(data => {

                document.querySelector('input[name=jumlah_sppt]').value = data
                document.querySelector('input[name=total_pbb]').value = 0

        }); 
    }    

    function doSubmit(form){
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
                form.submit()

                // document.querySelector('input[name=jumlah_sppt]').value = res.data.total_SPPT
                // document.querySelector('input[name=total_pbb]').value = res.data.jumlah.toLocaleString('id-ID', {
                //     style: 'currency',
                //     currency: 'IDR',
                // })

                // setTimeout(() => {
                //     if(confirm('Apa anda yakin cetak SSPD secara Masal'))
                //     {
                        
                //     }
                // }, 1500);
            }
        })
    }
</script>

<?php load('builder/partials/bottom');?>