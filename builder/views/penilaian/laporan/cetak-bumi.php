<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penilaian Bumi</title>
</head>
<body onload="window.print()">
    <h2 align="center">LAPORAN PENILAIAN BUMI<br>TAHUN <?=$_GET['tahun']?></h2>
    <table class="min-w-max w-full table-auto" width="100%" border="1">
        <tbody class="text-gray-600 text-sm font-light">
            <?php if(empty($datas)): ?>
            <tr>
                <td colspan="4" class="py-3 px-6 text-center font-semibold"><i>Empty</i></td>
            </tr>
            <?php else: ?>
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-center">No</th>
                    <th class="py-3 px-6 text-center">NOP</th>
                    <th class="py-3 px-6 text-center">Nama Wajib Pajak</th>
                    <th class="py-3 px-6 text-center">Jenis Bumi<br>Alamat Objek Pajak</th>
                    <th class="py-3 px-6 text-center">Luas Bumi<br>Kode ZNT</th>
                    <th class="py-3 px-6 text-center">NIR</th>
                    <th class="py-3 px-6 text-center">Nilai Sistem</th>
                </tr>
            </thead>
            <?php 
            foreach($datas as $key => $data): 
                $nir = $data['NIR']*1000;
                $nilai_sistem_bumi = $data['TOTAL_LUAS_BUMI']*$nir;
                $jenis_bumi = [
                    0 => '',
                    1 => '01-Tanah dan Bangunan',
                    2 => '02-Kavling Siang Bangun',
                    3 => '03-Tanah Kosong'
                ];
                $jns_bumi = isset($jenis_bumi[$data['JNS_BUMI']]) ? $jenis_bumi[$data['JNS_BUMI']] : '04-Fasilitas Umum';
                $alamat = $data['JALAN_OP'] . ' Kel/Desa : ' . $data['NM_KELURAHAN'] . '<br> Kec : ' . $data['NM_KECAMATAN'];
            ?>
            <tr class="border-b border-gray-200 hover:bg-gray-100">

                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium"><?=$key+1?></span>
                    </div>
                </td>
                
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium"><?=$data['NOPQ']?></span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium"><?=$data['NM_WP']?></span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium"><?=$jns_bumi?><br><?= $alamat ?></span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium"><?=$data['TOTAL_LUAS_BUMI']?><br><?=$data['KD_ZNT']?></span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium"><?=number_format($nir,0,',','.')?></span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium"><?=number_format($nilai_sistem_bumi,0,',','.')?></span>
                    </div>
                </td>
            </tr>
            <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</body>
</html>