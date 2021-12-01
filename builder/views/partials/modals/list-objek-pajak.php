<!-- This example requires Tailwind CSS v2.0+ -->
<div class="fixed z-10 inset-0  overflow-y-auto" id="modal-list-objek-pajak" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!--
        Background overlay, show/hide based on modal state.

        Entering: "ease-out duration-300"
            From: "opacity-0"
            To: "opacity-100"
        Leaving: "ease-in duration-200"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!--
        Modal panel, show/hide based on modal state.

        Entering: "ease-out duration-300"
            From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            To: "opacity-100 translate-y-0 sm:scale-100"
        Leaving: "ease-in duration-200"
            From: "opacity-100 translate-y-0 sm:scale-100"
            To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl sm:w-full">

            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                
                <div class="sm:flex sm:items-start">

                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">

                        <h3 class="text-xl leading-6 text-center my-5 font-medium text-gray-900" id="modal-title">
                            Search List Objek Pajak
                        </h3>

                        <div class="mt-2 text-sm">
                            
                            <div class="form-group mb-2">
                                <label for="">Nama WP</label>
                                <input type="text" name="QOP_NAMA_WP" class="p-2 w-full border rounded">
                            </div>
                            
                            <div class="form-group mb-2">
                                <button type="button" class="p-2 mb-2 bg-green-800 text-white rounded" onclick="selectQOP()">Search</button>
                            </div>

                        </div>

                        <div class="mt-2 overflow-x-auto">
                            <table class="min-w-max w-full table-auto text-gray-600 text-sm font-light">
                                <thead>
                                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left"></th>
                                        <th class="py-3 px-6 text-left">No</th>
                                        <th class="py-3 px-6 text-left">NOP</th>
                                        <th class="py-3 px-6 text-left">Nama</th>
                                        <th class="py-3 px-6 text-left">Alamat Wajib Pajak</th>
                                        <th class="py-3 px-6 text-left">Lokasi Objek Pajak</th>
                                        <th class="py-3 px-6 text-left">L Bumi</th>
                                        <th class="py-3 px-6 text-left">L BNG</th>
                                        <th class="py-3 px-6 text-left">NJOP Bumi</th>
                                        <th class="py-3 px-6 text-left">NJOP BNG</th>
                                        <th class="py-3 px-6 text-left">Total NJOP</th>
                                        <th class="py-3 px-6 text-left">NJOPTK</th>
                                        <th class="py-3 px-6 text-left">Subjek ID</th>
                                        <th class="py-3 px-6 text-left">Jalan</th>
                                        <th class="py-3 px-6 text-left">Kel</th>
                                        <th class="py-3 px-6 text-left">Blok</th>
                                        <th class="py-3 px-6 text-left">RT</th>
                                        <th class="py-3 px-6 text-left">RW</th>
                                        <th class="py-3 px-6 text-left">Kota</th>
                                        <th class="py-3 px-6 text-left">POS</th>
                                        <th class="py-3 px-6 text-left">NPWP</th>
                                        <th class="py-3 px-6 text-left">Persil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">

                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" id="btn-modal-proses">
                Proses
                </button>
                <button type="button" id="close-modal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Tutup
                </button>

            </div>

        </div>
    </div>
</div>

<script defer>

    var selectedNOP = ""

    function selectNOP(NOP){
        $("input[name='NOP']").val(NOP)
        $("#modal-list-objek-pajak").addClass("hidden")
    }

    async function selectQOP(){
        var name = $("[name='QOP_NAMA_WP']")

        var response = await fetch(`index.php?action=builder/modals/list-objek-pajak&search=${name.val()}`)

        var data = await response.json()

        var html = ''

        var tbody = $("#modal-list-objek-pajak tbody")

        data.forEach((dt,key)=>{

            var alamat = dt.JALAN_WP + ", " + dt.KELURAHAN_WP + ", BLOK: " + dt.BLOK_KAV_NO_WP + " /RW: " + dt.RW_WP + "/RT: " + dt.RT_WP + "-" + dt.KOTA_WP

            var lokasi =  dt.JALAN_OP + ", " + dt.NM_KELURAHAN + ", BLOK: " + dt.BLOK_KAV_NO_OP + " /RW: " + dt.RW_OP + "/RT: " + dt.RT_OP + " KEC. " + dt.NM_KECAMATAN

            html += `<tr class="border-b border-gray-200 hover:bg-gray-100">

                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <button class="font-medium p-2 mb-2 bg-blue-800 text-white rounded" onclick="selectNOP('${dt.NOPQ}')">Pilih</button>
                    </div>
                </td>

                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${key+1}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${dt.NOPQ}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${dt.NM_WP}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${alamat}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${lokasi}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${dt.TOTAL_LUAS_BUMI}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${dt.TOTAL_LUAS_BNG}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${dt.NJOP_BUMI}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${dt.NJOP_BNG}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${parseInt(dt.NJOP_BUMI) + parseInt(dt.NJOP_BNG)}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium"></span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${dt.SUBJEK_PAJAK_ID}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${dt.JALAN_WP}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${dt.NM_KELURAHAN}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${dt.BLOK_KAV_NO_WP}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${dt.RT_WP}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${dt.RW_WP}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${dt.KOTA_WP}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${dt.KD_POS_WP}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${dt.NPWP}</span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium">${dt.NO_PERSIL}</span>
                    </div>
                </td>

                </tr>
            `
        })

        tbody.html(html)
    }

    $("#close-modal").on('click',function(){
        $("#modal-list-objek-pajak").addClass("hidden")
    })
</script>