<?php load('builder/partials/top') ?>
<div class="content lg:max-w-screen-lg lg:mx-auto py-8">
    <h2 class="text-4xl">Add NIR</h2>
    <form id="login-form" action="index.php?page=<?=$_GET['page']?>" method="post" enctype="multipart/form-data">
        <div class="bg-white shadow-md rounded my-6 p-8">

            <div class="form-group">
                <label for="">Tahun</label>
                <select class="p-2 w-full border rounded" name="YEAR">
                    <option value="" selected readonly>- Pilih Tahun -</option>
                    <?php foreach($years as $Y):?>
                        <option <?= (isset($year) && $year == $Y) ? "selected" : ""?> value="<?=$Y?>"><?=$Y?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group mb-2">
                <label>Kecamatan</label>
                <select name="KD_KECAMATAN" class="p-2 w-full border rounded" onchange="kecamatanChange(this)">
                    <option value="" selected readonly>- Pilih Kecamatan -</option>
                    <?php foreach($kecamatans as $kecamatan):?>
                        <option value="<?=$kecamatan['KD_KECAMATAN']?>"><?=$kecamatan['KD_KECAMATAN']." - ".$kecamatan['NM_KECAMATAN']?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group mb-2 hidden" id="kelurahan"></div>
            <div class="form-group mb-2 hidden" id="znt"></div>

            <div class="form-group mb-2 hidden" id="persen">
                <label>Kenaikan %</label>
                <input name="PERSEN" type="number" class="p-2 w-full border rounded" onkeyup="persenChange(this)" value="0" min="0">
            </div>

            <div class="form-group">
                <button class="w-full p-2 bg-indigo-800 text-white rounded" id="btn-login">Insert</button>
                <a href="index.php?page=builder/nir/index" class="w-full p-2 bg-yellow-500 text-white rounded block text-center mt-2">Kembali</a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded my-6 p-8 overflow-x-auto">
            <table class="min-w-max w-full table-auto">
                <tbody class="text-gray-600 text-sm font-light">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">No</th>
                            <th class="py-3 px-6 text-left">No Dokumen</th>
                            <th class="py-3 px-6 text-left">Kecamatan</th>
                            <th class="py-3 px-6 text-left">Kelurahan</th>
                            <th class="py-3 px-6 text-left">Znt</th>
                            <th class="py-3 px-6 text-left">Nir Lama</th>
                            <th class="py-3 px-6 text-left">Nir Baru</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </tbody>
            </table>
        </div>

    </form>
</div>

<script>

    var timeout;

    function persenChange(el){
        clearTimeout(timeout)
        timeout = setTimeout(() => {

            var nLama = document.querySelectorAll(".nir-lama")

            nLama.forEach(lama=>{
                
                var value = parseFloat(lama.innerHTML)

                var fk = lama.getAttribute("name").match(/\[([^)]+)\]/)[1]

                var plus = value * (el.value / 100)

                document.querySelector(`[name='NIR_BARU[${fk}]']`).value = value + plus

            })

        }, 500)
    }

    function kecamatanChange(el){
        var year = document.querySelector("[name='YEAR']")

        fetch("index.php?page=builder/nir/index&filter-kecamatan="+el.value).then(response => response.json()).then(data => {

                var html = `
                        <label>Kelurahan</label>
                        <select name="KD_KELURAHAN" class="p-2 w-full border rounded" onchange="kelurahanChange(this)">
                            <option value="" selected readonly>- Pilih Kelurahan -</option>`

                data.map(dt=>{
                    html += `<option value="${dt.KD_KELURAHAN}">${dt.KD_KELURAHAN} - ${dt.NM_KELURAHAN}</option>`
                })

                html += `</select>`

                var kelurahan = document.querySelector("#kelurahan")

                kelurahan.innerHTML = html

                kelurahan.classList.remove("hidden")

        }); 

        fetch("index.php?page=builder/nir/create&check=true&YEAR="+year.value+"&KD_KECAMATAN="+el.value).then(response => response.json()).then(dt => {

            var html = ''

            dt.map((data,key)=>{
                
                html += `<tr class="border-b border-gray-200 hover:bg-gray-100">
                            
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">${key+1}</span>
                                </div>
                            </td>
    
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">${data['NO_DOKUMEN']}</span>
                                </div>
                            </td>
    
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">${data['KD_KECAMATAN'] + "-" + data['NM_KECAMATAN']}</span>
                                </div>
                            </td>
    
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">${data['KD_KELURAHAN']+ "-" + data['NM_KELURAHAN']}</span>
                                </div>
                            </td>
    
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">${data['KD_ZNT']}</span>
                                </div>
                            </td>
    
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium nir-lama" name="NIR_LAMA[${data['NO_DOKUMEN'] + "-" + data['KD_KECAMATAN'] + "-" + data['KD_KELURAHAN'] + "-" + data['KD_ZNT']}]">${data['NIR']}</span>
                                </div>
                            </td>
                            
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="form-group inline-block">
                                    <input type="text" class="p-2 w-full border rounded nir-baru" placeholder="Nir Baru" name="NIR_BARU[${data['NO_DOKUMEN'] + "-" + data['KD_KECAMATAN'] + "-" + data['KD_KELURAHAN'] + "-" + data['KD_ZNT']}]">
                                </div>
                            </td>
    
                    </tr>`
            })

            var tbody = document.querySelector("tbody")

            tbody.innerHTML = html

            
            document.querySelector("#persen").classList.remove("hidden")
        })
    }    

    function kelurahanChange(el){
        var kecamatan = document.querySelector("select[name='KD_KECAMATAN']")
        var year = document.querySelector("[name='YEAR']")

        fetch("index.php?page=builder/nir/index&filter-kelurahan="+el.value+"&filter-kecamatan="+kecamatan.value).then(response => response.json()).then(data => {

                var html = `
                        <label>ZNT</label>
                        <select name="KD_ZNT" class="p-2 w-full border rounded" onchange="zntChange(this)">
                            <option value="" selected readonly>- Pilih ZNT -</option>`

                data.map(dt=>{
                    html += `<option value="${dt.KD_ZNT}">${dt.KD_ZNT}</option>`
                })

                html += `</select>`

                var znt = document.querySelector("#znt")

                znt.innerHTML = html

                znt.classList.remove("hidden")

        });

        fetch("index.php?page=builder/nir/create&check=true&YEAR="+year.value+"&KD_KECAMATAN="+kecamatan.value+"&KD_KELURAHAN="+el.value).then(response => response.json()).then(dt => {

            var html = ''

            dt.map((data,key)=>{
                
                html += `<tr class="border-b border-gray-200 hover:bg-gray-100">
                            
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">${key+1}</span>
                                </div>
                            </td>
    
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">${data['NO_DOKUMEN']}</span>
                                </div>
                            </td>
    
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">${data['KD_KECAMATAN'] + "-" + data['NM_KECAMATAN']}</span>
                                </div>
                            </td>
    
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">${data['KD_KELURAHAN']+ "-" + data['NM_KELURAHAN']}</span>
                                </div>
                            </td>
    
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">${data['KD_ZNT']}</span>
                                </div>
                            </td>
    
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium nir-lama" name="NIR_LAMA[${data['NO_DOKUMEN'] + "-" + data['KD_KECAMATAN'] + "-" + data['KD_KELURAHAN'] + "-" + data['KD_ZNT']}]">${data['NIR']}</span>
                                </div>
                            </td>
                            
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="form-group inline-block">
                                    <input type="text" class="p-2 w-full border nir-baru rounded" placeholder="Nir Baru" name="NIR_BARU[${data['NO_DOKUMEN'] + "-" + data['KD_KECAMATAN'] + "-" + data['KD_KELURAHAN'] + "-" + data['KD_ZNT']}]">
                                </div>
                            </td>
    
                    </tr>`
            })

            var tbody = document.querySelector("tbody")

            tbody.innerHTML = html

            document.querySelector("#persen").classList.remove("hidden")

        }) 
    }    

    function zntChange(el){
        var kecamatan = document.querySelector("select[name='KD_KECAMATAN']")
        var kelurahan = document.querySelector("select[name='KD_KELURAHAN']")
        var year = document.querySelector("[name='YEAR']")

        fetch("index.php?page=builder/nir/create&check=true&YEAR="+year.value+"&KD_KECAMATAN="+kecamatan.value+"&KD_KELURAHAN="+kelurahan.value+"&KD_ZNT="+el.value).then(response => response.json()).then(dt => {

            var html = ''

            dt.map((data,key)=>{
                
                html += `<tr class="border-b border-gray-200 hover:bg-gray-100">
                            
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">${key+1}</span>
                                </div>
                            </td>
    
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">${data['NO_DOKUMEN']}</span>
                                </div>
                            </td>
    
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">${data['KD_KECAMATAN'] + "-" + data['NM_KECAMATAN']}</span>
                                </div>
                            </td>
    
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">${data['KD_KELURAHAN']+ "-" + data['NM_KELURAHAN']}</span>
                                </div>
                            </td>
    
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">${data['KD_ZNT']}</span>
                                </div>
                            </td>
    
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium nir-lama" name="NIR_LAMA[${data['NO_DOKUMEN'] + "-" + data['KD_KECAMATAN'] + "-" + data['KD_KELURAHAN'] + "-" + data['KD_ZNT']}]">${data['NIR']}</span>
                                </div>
                            </td>
                            
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="form-group inline-block">
                                    <input type="text" class="p-2 w-full nir-baru border rounded" placeholder="Nir Baru" name="NIR_BARU[${data['NO_DOKUMEN'] + "-" + data['KD_KECAMATAN'] + "-" + data['KD_KELURAHAN'] + "-" + data['KD_ZNT']}]">
                                </div>
                            </td>
    
                    </tr>`
            })

            var tbody = document.querySelector("tbody")

            tbody.innerHTML = html

            document.querySelector("#persen").classList.remove("hidden")

        }) 
    }    
</script>

<?php load('builder/partials/bottom') ?>
