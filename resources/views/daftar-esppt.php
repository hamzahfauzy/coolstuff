<?php load('partials/landing-top') ?>
<style>
.group {
    margin-bottom:10px;
}
.control-expanded, label{
    margin:12px 0;
}
label {
    margin:6px 0;
    display:block;
}
</style>
        <main style="padding-bottom:100px;">
                   
            <h2 align="center">Daftar e-SPPT</h2>
            <form action="" method="post">
                <div class="hero-form field" style="margin-left:auto;margin-right:auto;max-width:1000px;">
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

                    <?php if($error): ?>
                    <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-6" role="alert">
                        <div class="flex">
                            <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                            <div class="flex items-center">
                            <p class="font-bold m-0"><?=$error?></p>
                            </div>
                        </div>
                    </div>
                    <?php endif ?> 
                    <div class="control control-expanded">
                        <label for="">ID Wajib Pajak</label>
                        <input class="input" type="text" name="ID_WAJIB_PAJAK" placeholder="ID Wajib Pajak" value="<?=@$_POST['ID_WAJIB_PAJAK']?>">
                    </div>
                    <div class="control control-expanded">
                        <label for="">Nama Wajib Pajak</label>
                        <input class="input" type="text" name="NAMA_WAJIB_PAJAK" placeholder="Nama Wajib Pajak" value="<?=@$_POST['NAMA_WAJIB_PAJAK']?>">
                    </div>
                    <div class="control control-expanded">
                        <label for="">Email</label>
                        <input class="input" type="email" name="EMAIL" placeholder="Email" value="<?=@$_POST['EMAIL']?>">
                    </div>
                    <!-- <div class="control control-expanded">
                        <label>Tahun</label>
                        <select name="TAHUN" class="p-2 mt-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Tahun -</option>
                            <?php foreach($years as $year):?>
                                <option <?= @$_POST['TAHUN'] == $year ? 'selected'  : ''?> value="<?=$year?>"><?=$year?></option>
                            <?php endforeach ?>
                        </select>
                    </div>  -->
                    <div class="control">
                        <button class="button button-primary button-block" name="submit">Daftar</button>
                    </div>
                </div>
            </form>
        </main>
        <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>

<?php load('partials/landing-bottom') ?>