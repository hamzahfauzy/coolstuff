<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-4xl">Add Kayu Ulin</h2>

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
        <form id="login-form" action="index.php?page=<?=$_GET['page']?>" method="post" enctype="multipart/form-data">

            <div class="form-group mb-2">
                <label>Tahun Status Kayu Ulin</label>
                <input type="number" name="THN_STATUS_KAYU_ULIN" required value="<?= !empty($old) ? $old["THN_STATUS_KAYU_ULIN"] : '' ?>" class="p-2 w-full border rounded">
            </div>

            <div class="form-group mb-2">
                <label>Status</label>
                <select name="STATUS_KAYU_ULIN" required class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih Status -</option>
                    <option <?= !empty($old) ? $old["STATUS_KAYU_ULIN"] == 0 ? 'selected' : '' : '' ?> value="0">NO</option>
                    <option <?= !empty($old) ? $old["STATUS_KAYU_ULIN"] == 1 ? 'selected' : '' : '' ?> value="1">YES</option>
                </select>
            </div>

            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" id="btn-login">Insert</button>
            </div>
        </form>
    </div>
</div>
<?php load('builder/partials/bottom') ?>
