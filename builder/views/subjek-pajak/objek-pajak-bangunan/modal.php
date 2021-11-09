<!-- This example requires Tailwind CSS v2.0+ -->
<div class="fixed z-10 inset-0 overflow-y-auto" id="modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
              Lembar Kerja Penilaian
            </h3>

            <div class="mt-2 text-sm">

              <div>
                <div class="flex justify-between">
                    <p class="font-bold">NOP : 12345678976345</p>
                    <p class="font-bold">No Form : 12345678976345</p>
                </div>
  
                <ol class="grid grid-cols-3 gap-4 list-decimal list-inside">
  
                  <div class="my-2">
                    <li>Jenis Penggunaan Bangunan : <span class="font-bold">1.0</span></li>
    
                    <li class="mt-2">Luas Struktur Bangunan (M2) : <span class="font-bold">1.0</span></li>
                    
                    <li class="mt-2">Jumlah Lantai : <span class="font-bold">1.0</span></li>
                  </div>
  
                  <div class="my-2 text-center">
                    <li>Tahun Pajak : <span class="font-bold">1.0</span></li>
    
                    <li class="mt-2 text-center">Tahun Dibangun : <span class="font-bold">1.0</span></li>
                    
                    <li class="mt-2">Tahun Renovasi : <span class="font-bold">1.0</span></li>
                  </div>
  
                  <div class="my-2 text-right">
                    
                    <li>Bangunan Ke : <span class="font-bold">1.0</span></li>
                    
                    <li class="mt-2">Kondisi : <span class="font-bold">1.0</span></li>
                    
                    <li class="mt-2">Konstruksi : <span class="font-bold">1.0</span></li>
                    
                  </div>
  
                </ol>
              </div>
              
              <div>
                <hr class="my-2">

                <div class="flex justify-between">
                  <p class="font-bold">Biaya Komponen Utama</p>
                  <p class="font-bold">Rp.12345678976345</p>
                </div>

                <ol class="grid grid-cols-3 gap-4 list-decimal list-inside">

                  <div class="my-2">
                    <li>Struktur Komponen Utama</li>
    
                    <li class="mt-2">Mezanine</li>
                    
                    <li class="mt-2">Daya Dukung Lantai</li>
                  </div>

                  <div class="my-2 text-center">
                    <p>45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                  </div>

                  <div class="my-2 text-right">
                    <p class="font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                  </div>

                </ol>
              </div>

              <div>
                <hr class="my-2">
  
                <div class="flex justify-between">
                  <p class="font-bold">Biaya Komponen Material</p>
                  <p class="font-bold">Rp.12345678976345</p>
                </div>
  
                <ol class="grid grid-cols-3 gap-4 list-decimal list-inside">
  
                  <div class="my-2">
                    <li>Atap-5-5</li>
    
                    <li class="mt-2">Dinding-4-4</li>
                    
                    <li class="mt-2">Lantai-5-5</li>
                    
                    <li class="mt-2">Langit-Langit-2-2</li>
                  </div>
  
                  <div class="my-2 text-center">
                    <p>45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                  </div>
  
                  <div class="my-2 text-right">
                    <p class="font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                  </div>
  
                </ol>
              </div>

              <div>
                <hr class="my-2">
  
                <div class="flex justify-between">
                  <p class="font-bold">Biaya Komponen Fasilitas</p>
                  <p class="font-bold">Rp.12345678976345</p>
                </div>

                <ol class="grid grid-cols-3 gap-4 list-decimal list-inside">
  
                  <div class="my-2">
  
                    <div class="my-4">
                      <li class="font-bold">Pagar</li>
  
                      <p class="mt-2 ml-4">Bahan Pagar</p>
                    </div>
  
  
                    <div class="my-4">
                      
                      <li class="font-bold">Perkerasan Halaman</li>
  
                      <p class="mt-2 ml-4">14 Ringan</p>
                      <p class="mt-2 ml-4">15 Sedang</p>
                      <p class="mt-2 ml-4">16 Berat</p>
                      <p class="mt-2 ml-4">17 Penutup Lantai</p>
  
                    </div>
                    
                    <li class="my-4 font-bold">Kapasitas Genset</li>
                    <li class="my-4 font-bold">Sumur Artesis</li>
                    <li class="my-4 font-bold">Jumlah Saluran PABX</li>
  
                    <div class="my-4">
                      
                      <li class="font-bold">Kolam Renang</li>
  
                      <p class="mt-2 ml-4">13 Pelapis</p>
  
                    </div>
  
                    <div class="my-4">
                      
                      <li class="font-bold">Pemadam Kebakaran</li>
  
                      <p class="mt-2 ml-4">Hydran</p>
                      <p class="mt-2 ml-4">Springkler</p>
                      <p class="mt-2 ml-4">Fire AL.</p>
  
                    </div>
  
                    <div class="my-4">
                      
                      <li class="font-bold">Lapangan Tenis</li>
  
                      <ul class="list-decimal list-inside mt-2 ml-2">
  
                        <div class="my-2">
                      
                          <li>Dengan Lampu</li>
      
                          <p class="mt-2 ml-4">Beton</p>
                          <p class="mt-2 ml-4">Aspal</p>
                          <p class="mt-2 ml-4">Tanah Liat/Rumput</p>
  
                        </div>
  
                        <div class="my-2">
                      
                          <li>Tanpa Lampu</li>
      
                          <p class="mt-2 ml-4">Beton</p>
                          <p class="mt-2 ml-4">Aspal</p>
                          <p class="mt-2 ml-4">Tanah Liat/Rumput</p>
  
                        </div>
                      
                      </ul>
  
                    </div>
                    
                    <div class="my-4">
                      
                      <li class="font-bold">Lift</li>
  
                      <p class="mt-2 ml-4">Penumpang</p>
                      <p class="mt-2 ml-4">Kapsul</p>
                      <p class="mt-2 ml-4">Barang</p>
  
                    </div>
                    
                    <div class="my-4">
                      
                      <li class="font-bold">Eskalator</li>
  
                      <p class="mt-2 ml-4"><= 80 M</p>
                      <p class="mt-2 ml-4">> 80 M</p>
  
                    </div>
                    
                    <div class="my-4">
                      
                      <li class="font-bold">AC Central</li>
  
                      <p class="mt-2 ml-4">Bangunan Lain</p>
                      <p class="mt-2 ml-4">Kamar</p>
                      <p class="mt-2 ml-4">Ruangan Lain</p>
                      <p class="mt-2 ml-4">Boiler</p>
  
                    </div>
                  
                  </div>
  
                  <div class="my-2 text-center">
  
                    <p class="mt-4">&nbsp;</p>
                    <p class="mt-2">45.00 M' x <span class="font-bold">Rp.200.00</span> </p>
  
                    <p class="mt-4">&nbsp;</p>
                    <p class="mt-2">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                    
                    <p class="mt-4">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-4">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-4">45.00 Sal x <span class="font-bold">Rp.200.00</span> </p>
  
                    <p class="mt-4">&nbsp;</p>
                    <p class="mt-2">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
  
                    <p class="mt-4">&nbsp;</p>
                    <p class="mt-2">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
  
                    <p class="mt-4">&nbsp;</p>
                    <p class="mt-2">&nbsp;</p>
                    <p class="mt-2">45.00 Ban x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 Ban x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 Ban x <span class="font-bold">Rp.200.00</span> </p>
  
                    <p class="mt-2">&nbsp;</p>
                    <p class="mt-2">45.00 Ban x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 Ban x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 Ban x <span class="font-bold">Rp.200.00</span> </p>
  
                    <p class="mt-4">&nbsp;</p>
                    <p class="mt-2">45.00 Unit x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 Unit x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 Unit x <span class="font-bold">Rp.200.00</span> </p>
  
                    <p class="mt-4">&nbsp;</p>
                    <p class="mt-2">45.00 Unit x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 Unit x <span class="font-bold">Rp.200.00</span> </p>
  
                    <p class="mt-4">&nbsp;</p>
                    <p class="mt-2">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 M2 x <span class="font-bold">Rp.200.00</span> </p>
  
                  </div>
  
                  <div class="my-2 text-right">
  
                    <p class="mt-4 font-bold">&nbsp;</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
  
                    <p class="mt-4 font-bold">&nbsp;</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    
                    <p class="mt-4 font-bold">Rp.200.00</p>
                    <p class="mt-4 font-bold">Rp.200.00</p>
                    <p class="mt-4 font-bold">Rp.200.00</p>
  
                    <p class="mt-4 font-bold">&nbsp;</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
  
                    <p class="mt-4 font-bold">&nbsp;</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
  
                    <p class="mt-4 font-bold">&nbsp;</p>
                    <p class="mt-2 font-bold">&nbsp;</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
  
                    <p class="mt-2 font-bold">&nbsp;</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
  
                    <p class="mt-4 font-bold">&nbsp;</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
  
                    <p class="mt-4 font-bold">&nbsp;</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
  
                    <p class="mt-4 font-bold">&nbsp;</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
  
                  </div>
  
                </ol>
              </div>
              
              <div>
                <hr class="my-2">
  
                <div class="flex justify-between">
                  <p class="font-bold">Penyusutan</p>
                  <p class="font-bold">Rp.12345678976345</p>
                </div>
  
                <ol class="grid grid-cols-3 gap-4 list-decimal list-inside">
  
                  <div class="my-2">
                    <li>Nilai Penyusutan</li>
                  </div>
  
                  <div class="my-2 text-center">
                    <p>45.00 % x <span class="font-bold">Rp.200.00</span> </p>
                  </div>
  
                  <div class="my-2 text-right">
                    <p class="font-bold">Rp.200.00</p>
                  </div>
  
                </ol>

              </div>
              
              <div>
                <hr class="my-2">
  
                <div class="flex justify-between">
                  <p class="font-bold">Biaya Komponen Fasilitas (Tidak Disusutkan)</p>
                  <p class="font-bold">Rp.12345678976345</p>
                </div>
  
                <ol class="grid grid-cols-3 gap-4 list-decimal list-inside">
  
                  <div class="my-2">
                    <li>Daya Listrik</li>
                    <li class="mt-2">Jumlah AC Split</li>
                    <li class="mt-2">Jumlah AC Window</li>
                  </div>
  
                  <div class="my-2 text-center">
                    <p>45.00 KVa x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 Buah x <span class="font-bold">Rp.200.00</span> </p>
                    <p class="mt-2">45.00 Buah x <span class="font-bold">Rp.200.00</span> </p>
                  </div>
  
                  <div class="my-2 text-right">
                    <p class="font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                    <p class="mt-2 font-bold">Rp.200.00</p>
                  </div>
  
                </ol>

              </div>
              
              <div>
                <hr class="my-2">
  
                <div class="flex justify-between">
                  <div>
                    <p class="font-bold">Nilai Bangunan (Rp)</p>
                    <p>Rp.12345678976345</p>
                  </div>

                  <div  class="text-right">
                    <p class="font-bold">Nilai Bangunan / M2</p>
                    <p>29</p>
                  </div>
                </div>

              </div>
              
            </div>

          </div>

        </div>

      </div>

      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">

        <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
          Proses
        </button>
        <button type="button" id="close-modal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
          Tutup
        </button>

      </div>

    </div>

  </div>

</div>

<script>
    $("#close-modal").on('click',function(){
        $("#modal").addClass("hidden")
    })
</script>