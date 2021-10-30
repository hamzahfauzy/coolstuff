<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-4xl">Edit Status Kayu Ulin : <?=$data['THN_STATUS_KAYU_ULIN']?></h2>
    <div class="bg-white shadow-md rounded my-6 p-8">
        <form id="login-form" action="index.php?page=<?=$_GET['page']?>&kayu-ulin=<?=$_GET['kayu-ulin']?>" method="post" enctype="multipart/form-data">
            <div class="form-group mb-2">
                <label>Status</label>
                <select name="STATUS_KAYU_ULIN" class="p-2 w-full border rounded">
                    <option value="" selected readonly>- Pilih Status -</option>
                    <option <?=$data['STATUS_KAYU_ULIN'] == 0  ? 'selected' : ''?> value="0">NO</option>
                    <option <?=$data['STATUS_KAYU_ULIN'] == 1  ? 'selected' : ''?> value="1">YES</option>
                </select>
            </div>

            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" id="btn-login">Update</button>
            </div>
        </form>
    </div>
</div>
<?php load('builder/partials/bottom') ?>
