<?php load('builder/partials/top');

load('builder/partials/modals/list-objek-pajak');
?>

<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">Cetak Log Perubahan Objek</h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <form action="index.php" onsubmit="doSubmit(this); return false;">
            <input type="hidden" name="page" value="builder/penatausahaan/log-perubahan-objek/results">
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
                    <label for="NOP">NOP</label>
                    <input type="text" id="NOP" name="NOP" class="p-2 w-full border rounded">
                </div>
                
                <div class="form-group mb-2">
                    <button type="button" class="p-2 mb-2 bg-green-800 text-white rounded" onclick="onSelectQOP()">Pilih</button>
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

            <div class="grid grid-cols-3 gap-4">

                <div class="form-group mb-2">
                    <label for="dRekam1">&nbsp;</label>
                    <input type="checkbox" class="p-2 w-full border rounded" name="cLog" checked onchange="cLogChange(this)">
                </div>

                <div class="form-group mb-2">
                    <label for="dRekam1">Dari Tanggal</label>
                    <input type="date" id="dRekam1" name="dRekam1" class="p-2 w-full border rounded" value="<?=date('Y-m-d')?>">
                </div>
    
                <div class="form-group mb-2">
                    <label for="dRekam2">Sampai Tanggal</label>
                    <input type="date" id="dRekam2" name="dRekam2" class="p-2 w-full border rounded" value="<?=date('Y-m-d')?>">
                </div>
            </div>

            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" name="cetak" value="cetak">Tampilkan</button>
            </div>
        </form>
    </div>
</div>

<script>

    var modal = $("#modal-list-objek-pajak")

    var nop = $("input[name='NOP']");

    nop.inputmask({mask:"12.12.999.999.999-9999.9"})

    function onSelectQOP(){
        modal.removeClass("hidden")
    }

    function cLogChange(e){

        var dRekam1 = $("[name='dRekam1']")
        var dRekam2 = $("[name='dRekam2']")

        if(e.checked){
            dRekam1.removeAttr('disabled')
            dRekam2.removeAttr('disabled')
        }else{
            
            dRekam1.attr('disabled','')
            dRekam2.attr('disabled','')
        }
    }

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
            fetch("index.php?page=builder/penatausahaan/log-perubahan-objek/index&get-kelurahan=true&KD_KECAMATAN="+el.value).then(response => response.json()).then(data => {

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

        fetch('index.php?'+params.toString()+'&mode=cek_cetak')
        .then(res => res.json())
        .then(res => {
            if(res.status == 'fail')
            {
                alert(res.message)
                document.querySelector('button[name=cetak]').disabled = false
                document.querySelector('button[name=cetak]').innerHTML = "Tampilkan"
            }
            else
            {
                params.delete('page')

                location.href='index.php?page=builder/penatausahaan/log-perubahan-objek/cetak-all&'+params.toString()
                document.querySelector('button[name=cetak]').disabled = false
            }
        })
    }
</script>

<?php load('builder/partials/bottom');?>