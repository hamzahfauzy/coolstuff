<?php load('builder/partials/top');
?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">DBKB Non Standar</h2>
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
        <div class="mt-5">
            <form action="" method="get">

                <input type="hidden" name="page" value="<?=$_GET['page']?>">

                <div class="form-group inline-block">
                    <select class="p-2 w-full border rounded" name="tahun" id="tahun">
                        <option value="" selected readonly>- Pilih Tahun -</option>
                        <?php for($tahun=date('Y');$tahun>=1900;$tahun--): ?>
                            <option <?= (isset($_GET['tahun']) && $_GET['tahun'] == $tahun) ? "selected" : ""?> value="<?=$tahun?>"><?=$tahun?></option>
                        <?php endfor ?>
                    </select>
                </div>

                <div class="form-group inline-block">
                    <select name="jpb" class="p-2 w-full border rounded" id="jpb">
                        <option value="" selected readonly>- Pilih JPB -</option>
                        <?php foreach($jpbs as $jpb):?>
                            <option <?= isset($_GET['jpb']) && $_GET['jpb'] == $jpb['KD_JPB'] ? 'selected' : ''?> value="<?=$jpb['KD_JPB']?>"><?=$jpb['KD_JPB']." - ".$jpb['NM_JPB']?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group inline-block">
                    <button class="p-2 bg-green-500 text-white rounded" name="tampilkan">Tampilkan</button>

                    <button type="button" class="p-2 bg-green-500 text-white rounded" onclick="buatBaru()">+ Add New</button>

                    <?php if(isset($_GET['jpb']) && isset($_GET['tahun'])): ?>
                    <a href="index.php?page=builder/dbkb-non-standar/delete&tahun=<?=$_GET['tahun']?>&jpb=<?=$_GET['jpb']?>" class="p-2 bg-red-500 text-white rounded" style="height:40px;display:inline-block;" onclick="if(confirm('Semua data yang tampil akan terhapus! Lanjutkan ?')){return true}else{return false}">Delete</a>
                    <?php endif ?>
                </div>

            </form>
        </div>
        <div class="bg-white shadow-md rounded my-3 overflow-x-auto">
            <form action="" method="post">
            <table class="min-w-max w-full table-auto">
                <tbody class="text-gray-600 text-sm font-light">
                    <?php if(empty($datas)): ?>
                    <tr>
                        <td colspan="4" class="py-3 px-6 text-center font-semibold"><i>Empty</i></td>
                    </tr>
                    <?php else: ?>
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">No</th>
                            <?php foreach($fields['columns'] as $key => $title): ?>
                            <th class="py-3 px-6 text-left"><?=$title?></th>
                            <?php endforeach ?>
                            <th class="py-3 px-6 text-center">Nilai Baru</th>
                        </tr>
                    </thead>
                    <?php foreach($datas as $key => $data): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">

                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$key+1?></span>
                            </div>
                        </td>
                        
                        <?php foreach($fields['columns'] as $k => $title): ?>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium <?= end($fields['columns']) == $title ? 'nilai-lama' : ''?>" data-key="<?=$key?>"><?=$data[$k]?></span>
                            </div>
                        </td>
                        <?php endforeach ?>

                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <input type="text" class="p-2 w-full border rounded nilai-baru" placeholder="Nilai Baru" name="NILAI_BARU[<?=$key?>]">
                            </div>
                        </td>
                    </tr>
                    <?php endforeach ?>
                    <tr>
                        <td class="py-3 px-6 text-left whitespace-nowrap" colspan="<?=count($fields['columns'])+2?>">
                            <div class="flex items-center">
                                <span>Presentasi Kenaikan (%)</span>
                                &nbsp;
                                <input type="text" class="p-2 w-full border rounded persentase" placeholder="Presentasi Kenaikan (%)" name="persentase" onchange="persenChange(this)">
                                &nbsp;
                                <button class="p-2 bg-green-500 text-white rounded" name="Simpan">Simpan</button>
                            </div>
                        </td>
                    </tr>
                    <?php endif ?>
                </tbody>
            </table>
            </form>
        </div>
    </div>
</div>

<script> 
var timeout;

function buatBaru()
{
    var tahun = document.querySelector('#tahun')
    var jpb = document.querySelector('#jpb')

    if(tahun.value && jpb.value)
    {
        location.href = 'index.php?page=builder/dbkb-non-standar/create&tahun='+tahun.value+'&jpb='+jpb.value
        return
    }

    alert('Tahun dan JPB harus dipilih!')
}

function persenChange(el){
    clearTimeout(timeout)
    timeout = setTimeout(() => {

        var nLama = document.querySelectorAll(".nilai-lama")

        nLama.forEach(lama=>{
            
            var value = parseFloat(lama.innerHTML)

            var fk = lama.dataset.key

            var plus = value * (el.value / 100)

            document.querySelector(`[name='NILAI_BARU[${fk}]']`).value = value + plus

        })

    }, 500)
} 
</script>

<?php load('builder/partials/bottom') ?>
