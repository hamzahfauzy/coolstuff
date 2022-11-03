<?php load('builder/partials/top');

?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-3xl">e-SPPT</h2>
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
                    <select class="p-2 w-full border rounded" name="limit" id="">
                        <option value="" selected readonly>- Tampilkan jumlah data -</option>
                        <option <?= (isset($_GET['limit']) && $_GET['limit'] == $limits['count']) ? "selected" : ""?> value="<?=$limits['count']?>">Tampilkan Semua</option>
                        <?php for($i = 10; $i <= $limits['count'];$i+=10):?>
                            <option <?= (isset($_GET['limit']) && $_GET['limit'] == $i) ? "selected" : ""?> value="<?=$i?>"><?=$i?></option>";
                        <?php endfor ?>
                    </select>
                </div>

                <div class="form-group inline-block">
                    <input type="text" class="p-2 w-full border rounded" placeholder="Cari.." name="nama" value="<?=isset($_GET['nama']) && $_GET['nama'] ? $_GET['nama'] : '' ?>">
                </div>

                <div class="form-group inline-block">
                    <button class="p-2 bg-green-500 text-white rounded" name="filter">Filter</button>
                </div>

            </form>
        </div>
        <div class="bg-white shadow-md rounded my-3 overflow-x-auto">
            <table class="min-w-max w-full table-auto">
                <tbody class="text-gray-600 text-sm font-light">
                    <?php if(empty($datas)): ?>
                    <tr>
                        <td colspan="5" class="py-3 px-6 text-center font-semibold"><i>Empty</i></td>
                    </tr>
                    <?php else: ?>
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">No</th>
                            <th class="py-3 px-6 text-left">ID</th>
                            <th class="py-3 px-6 text-left">Nama</th>
                            <th class="py-3 px-6 text-left">Email</th>
                            <th class="py-3 px-6 text-left">Status</th>
                            <th class="py-3 px-6 text-center">Action</th>
                        </tr>
                    </thead>
                    <?php foreach($datas as $key => $data):?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$key+1?></span>
                            </div>
                        </td>

                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['ID_WAJIB_PAJAK']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['NAMA_WAJIB_PAJAK']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['EMAIL']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="font-medium"><?=$data['STATUS']?></span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <!-- <a href="index.php?page=builder/pendaftaran/subjek-pajak/view&id=<?=$data['SUBJEK_PAJAK_ID']?>" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a> -->
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

    function kelurahanChange(el){

        fetch("index.php?page=builder/subjek-pajak/index&filter-kelurahan="+el.value).then(response => response.json()).then(data => {

                var html = `<select name="blok" class="p-2 w-full border rounded">
                            <option value="" selected readonly>- Pilih Blok -</option>`

                            console.log(data)

                data.map(dt=>{
                    html += `<option value="${dt.KD_BLOK}">${dt.KD_BLOK}</option>`
                })

                html += `</select>`

                var blok = document.querySelector("#blok")

                blok.innerHTML = html

                blok.classList.remove("hidden")

        }); 
    }    
</script>

<?php load('builder/partials/bottom') ?>
