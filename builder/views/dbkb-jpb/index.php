<?php load('builder/partials/top');
?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">DBKB Non Standar : JPB3_JPB8</h2>
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
        <div class="bg-white shadow-md rounded my-6 p-8">
            <form id="login-form" action="index.php?page=<?=$_GET['page']?>" method="post" enctype="multipart/form-data">

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
                    <input type="checkbox" id="DBKB_STANDARD" checked name="DBKB_STANDARD">
                    <label for="DBKB_STANDARD">DBKB JPB8</label>
                </div>

                <div class="form-group mb-2">
                    <input type="checkbox" id="DBKB_MATERIAL" checked name="DBKB_MATERIAL">
                    <label for="DBKB_MATERIAL">DBKB JPB3</label>
                </div>

                <div class="form-group">
                    <button class="w-full p-2 bg-indigo-800 text-white rounded" id="btn-login">Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php load('builder/partials/bottom') ?>
