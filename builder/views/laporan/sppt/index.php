<?php load('builder/partials/top');?>

<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">Cetak SPPT</h2>

    <div class="my-5">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center bg-white rounded-md" >
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 rounded-t-lg border-b-2" id="massal-btn" onclick="onTabChange(0)" type="button">Massal</button>
            </li>
            <li role="presentation">
                <button class="inline-block p-4 rounded-t-lg border-b-2" id="satuan-btn" onclick="onTabChange(1)">Satuan</button>
            </li>
        </ul>
    </div>

    <div id="myTabContent">
        <div class="bg-white shadow-md rounded my-6 p-8" id="massal">
            <form action="index.php" onsubmit="doSubmit(this); return false;">
                <input type="hidden" name="page" value="builder/laporan/sppt/results">
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
                    <?= Form::input('number', 'nip_pencetak', ['class'=>"p-2 w-full border rounded","placeholder"=>'NIP Pencetak','value'=>0]) ?>
                </div>

                <div class="form-group mb-2">
                    <input type="checkbox" id="dengan_blangko" name="dengan_blangko">
                    <label for="dengan_blangko">Dengan Blangko</label>
                </div>

                <div class="form-group">
                    <button class="w-full p-2 bg-indigo-800 text-white rounded" name="cetak" value="cetak">Cetak</button>
                </div>
            </form>
        </div>
        <div class="bg-white shadow-md rounded my-6 p-8" id="satuan">
            
            <form action="index.php" onsubmit="doSubmit(this); return false;">
                <input type="hidden" name="page" value="builder/laporan/sppt/results">
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
                    <?= Form::input('text', 'nop', ['class'=>"p-2 w-full border rounded","placeholder"=>'NOP']) ?>
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
                    <?= Form::input('number', 'nip_pencetak', ['class'=>"p-2 w-full border rounded","placeholder"=>'NIP Pencetak','value'=>0]) ?>
                </div>
                <div class="form-group mb-2">
                    <input type="checkbox" id="dengan_blangko_satuan" value="1" name="dengan_blangko">
                    <label for="dengan_blangko_satuan">Dengan Blangko</label>
                </div>
                <div class="form-group">
                    <button class="w-full p-2 bg-indigo-800 text-white rounded" name="cetak" value="cetak">Cetak</button>
                </div>
            </form>
        
        </div>
    </div>
</div>

<script>

    var nop = $("input[name='nop']");

    nop.inputmask({mask:"12.12.999.999.999-9{1,4}.9"})

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
            fetch("index.php?page=builder/laporan/sppt/index&get-kelurahan=true&KD_KECAMATAN="+el.value).then(response => response.json()).then(data => {

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

        fetch("index.php?page=builder/laporan/sppt/index&get-jumlah-sppt=true&KD_KELURAHAN="+el.value+"&KD_KECAMATAN="+kecamatan.value).then(response => response.text()).then(data => {

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
                document.querySelector('input[name=jumlah_sppt]').value = res.data.total_SPPT
                document.querySelector('input[name=total_pbb]').value = res.data.jumlah.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                })

                setTimeout(() => {
                    if(confirm('Apa anda yakin cetak SPPT ?'))
                    {
                        form.submit()
                    }
                }, 1500);
            }
        })
    }

    onTabChange(0)

    function onTabChange(index){

        var active = "border-green-500 text-green-500"
        var inactive = "border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"

        if(index == 0){
            $("#massal").removeClass('hidden')
            $("#satuan").addClass('hidden')
            $("#massal-btn").addClass(active)
            $("#satuan-btn").addClass(inactive)
            $("#massal-btn").removeClass(inactive)
            $("#satuan-btn").removeClass(active)
        } else {
            $("#massal").addClass('hidden')
            $("#satuan").removeClass('hidden')
            $("#massal-btn").addClass(inactive)
            $("#satuan-btn").addClass(active)
            $("#massal-btn").removeClass(active)
            $("#satuan-btn").removeClass(inactive)
        }
    }
</script>

<?php load('builder/partials/bottom');?>