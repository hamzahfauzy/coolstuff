<?php load('builder/partials/top'); load('builder/partials/modals/list-subjek-pajak'); ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-xl mr-3">Pindah Subjek Pajak</h2>
        <a href="index.php?page=builder/subjek-pajak/view&id=<?=$_GET['id']?>" class="p-2 bg-green-500 text-white rounded">Kembali</a>
    </div>

     <form id="login-form" action="index.php?page=<?=$_GET['page']?>&id=<?=$_GET['id']?>&NOP=<?=$_GET['NOP']?>" method="post" enctype="multipart/form-data">

        <div class="bg-white shadow-md rounded my-6 p-8">

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
                <label for="SUBJEK_PAJAK_ID">SUBJEK PAJAK ID</label>
                <input type="text" id="SUBJEK_PAJAK_ID" name="SUBJEK_PAJAK_ID" value="<?=isset($old) && $old["SUBJEK_PAJAK_ID"] ? $old['SUBJEK_PAJAK_ID'] : ''?>" class="p-2 w-full border rounded">
            </div>
            
            <div class="form-group mb-2">
                <button type="button" class="p-2 mb-2 bg-green-800 text-white rounded" onclick="onSelectSP()">Pilih</button>
                <button class="p-2 mb-2 bg-indigo-800 text-white rounded" id="submit">Submit</button>
            </div>
        
        </div>

    </form>

</div>

<script>

    var modal = $("#modal-list-subjek-pajak")

    function onSelectSP(){
        modal.removeClass("hidden")
    }

</script>

<?php load('builder/partials/bottom') ?>
