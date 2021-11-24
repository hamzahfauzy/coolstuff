<?php load('builder/partials/top');
?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">PBB Minimal</h2>
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
            <form id="pbbMinimal" method="post">

                <div class="form-group mb-2">
                    <label>Tahun</label>
                    <select class="p-2 w-full border rounded" name="THN_PBB_MINIMAL" id="">
                        <option value="" selected readonly>- Pilih Tahun -</option>
                        <?php foreach($years as $Y):?>
                            <option <?= ( $year == $Y) ? "selected" : ""?> value="<?=$Y?>"><?=$Y?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label for="NO_SK_PBB_MINIMAL">No SK</label>
                    <input type="text" id="NO_SK_PBB_MINIMAL" name="NO_SK_PBB_MINIMAL" class="p-2 w-full border rounded">
                </div>

                <div class="form-group mb-2">
                    <label for="TGL_SK_PBB_MINIMAL">Tanggal SK</label>
                    <input type="date" id="TGL_SK_PBB_MINIMAL" name="TGL_SK_PBB_MINIMAL" class="p-2 w-full border rounded">
                </div>
                
                <div class="form-group mb-2">
                    <label for="NILAI_PBB_MINIMAL">Nilai PBB Minimal</label>
                    <input type="number" id="NILAI_PBB_MINIMAL" name="NILAI_PBB_MINIMAL" class="p-2 w-full border rounded">
                </div>
                
                <div class="form-group mb-2">
                    <label for="NIP_PEREKAM_PBB_MINIMAL">NIP Perekam</label>
                    <input type="number" id="NIP_PEREKAM_PBB_MINIMAL" name="NIP_PEREKAM_PBB_MINIMAL" class="p-2 w-full border rounded">
                </div>

                <div class="form-group mb-2">
                    <label for="TGL_REKAM_PBB_MINIMAL">Tanggal Rekam</label>
                    <input type="date" id="TGL_REKAM_PBB_MINIMAL" name="TGL_REKAM_PBB_MINIMAL" class="p-2 w-full border rounded">
                </div>

                <div class="form-group mb-2">
                    <button type="button" class="p-2 bg-indigo-800 text-white rounded" onclick="onProcess(this)" id="btn-login">Proses</button>
                    <button type="button" class="p-2 bg-red-800 text-white rounded" onclick="onDelete(this)">Delete</button>
                </div>

            </form>
        </div>

        <div class="bg-white shadow-md rounded my-3 overflow-x-auto">
            <table class="min-w-max w-full table-auto">
                <tbody class="text-gray-600 text-sm font-light">
                    <?php if(empty($datas)): ?>
                    <tr>
                        <td colspan="6" class="py-3 px-6 text-center font-semibold"><i>Empty</i></td>
                    </tr>
                    <?php else: ?>
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">No</th>
                            <th class="py-3 px-6 text-left">No SK</th>
                            <th class="py-3 px-6 text-left">Tahun</th>
                            <th class="py-3 px-6 text-left">Nilai</th>
                            <th class="py-3 px-6 text-left">NIP Perekam</th>
                            <th class="py-3 px-6 text-left">Tanggal SK</th>
                            <th class="py-3 px-6 text-left">Tanggal Rekam</th>
                        </tr>
                    </thead>
                    <?php foreach($datas as $key => $data): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">

                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$key+1?></span>
                            </div>
                        </td>
                        
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NO_SK_PBB_MINIMAL']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['THN_PBB_MINIMAL']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NILAI_PBB_MINIMAL']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NIP_PEREKAM_PBB_MINIMAL']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['TGL_SK_PBB_MINIMAL'] ? $data['TGL_SK_PBB_MINIMAL']->format("Y-m-d") : '-'?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['TGL_REKAM_PBB_MINIMAL'] ? $data['TGL_REKAM_PBB_MINIMAL']->format("Y-m-d") : '-'?></span>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    async function onProcess(el){

        var year = document.querySelector("select[name='THN_PBB_MINIMAL']")

        var res = await fetch("index.php?page=<?=$_GET['page']?>&check=true&year="+year.value)

        var data = await res.json()

        if(data){
            var c = confirm("Data ditemukan! Apakah Ingin Dilanjutkan ?")

            if(c){
                document.forms.pbbMinimal.submit()
            }
        }else{
            var c = confirm("Data tidak ditemukan! Apakah Ingin Dilanjutkan ?")

            if(c){
                document.forms.pbbMinimal.submit()
            }
        }

    }

    async function onDelete(el){

        var year = document.querySelector("select[name='THN_PBB_MINIMAL']")

        var res = await fetch("index.php?page=<?=$_GET['page']?>&check=true&year="+year.value)

        var data = await res.json()

        if(data){
            var c = confirm("Data ditemukan! Apakah anda yakin ingin menghapus data ini ?")

            if(c){

                var form = document.forms.pbbMinimal

                form.innerHTML += "<input type='hidden' name='delete'>";

                form.submit()

            }
        }else{
            alert("Data tidak ditemukan!")
        }

    }
</script>

<?php load('builder/partials/bottom') ?>
