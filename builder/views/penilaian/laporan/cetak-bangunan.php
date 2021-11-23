<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penilaian Bangunan</title>
</head>
<body onload="window.print()">
    <h2 align="center">LAPORAN PENILAIAN BANGUNAN<br>TAHUN <?=$_GET['tahun']?></h2>
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
                    <th class="py-3 px-6 text-center">Alamat Objek</th>
                </tr>
            </thead>
            <?php 
            foreach($datas as $key => $data): 
                $alamat_wp = $data['JALAN_OP']." <br> KEL/DESA :" . $data['NM_KELURAHAN']." <br> KEC :" . $data['NM_KECAMATAN'];
                $alamat = $data['JALAN_OP'] . ' <br> Kel/Desa : ' . $data['NM_KELURAHAN'] . '<br> Kec : ' . $data['NM_KECAMATAN'];

                $child_data = [
                    [
                        'Bangunan Ke' => $data['NO_BNG'],
                        'Biaya Komponen Utama' => number_format($data['K_UTAMA'])
                    ],
                    [
                        'JPB' => $data['KD_JPB'] . "-" . $data['NM_JPB'],
                        'Biaya Komponen Material' => number_format($data['K_UTAMA'])
                    ],
                    [
                        'Luas Bng (M2)' => $data['LUAS_BNG'],
                        'Biaya Komponen Fasilitas' => number_format($data['K_FASILITAS'])
                    ],
                    [
                        'JLH Lantai' => $data['JML_LANTAI_BNG'],
                        'Jumlah' => number_format($data['K_UTAMA']+$data['K_MATERIAL']+$data['K_FASILITAS'])
                    ],
                    [
                        'Kondisi' => $data['KONDISI_BNG'],
                        'Nilai Penyusutan' => $data['J_SUSUT'].'% X '.number_format($data['K_UTAMA']+$data['K_MATERIAL']+$data['K_FASILITAS']).' = '.number_format($data['K_SUSUT'])
                    ],
                    [
                        'Konstruksi' => $data['JNS_KONSTRUKSI_BNG'],
                        'Biaya Non Susut' => number_format($data['K_NON_SUSUT'])
                    ],
                    [
                        'THN Bangun' => $data['THN_DIBANGUN_BNG'],
                        'Total' => number_format($data['NILAI_SISTEM_BNG'])
                    ],
                    [
                        'THN Renovasi' => $data['THN_RENOVASI_BNG'],
                        'Nilai Sistem Per M2' => number_format($data['NILAI_SISTEM_BNG']/$data['LUAS_BNG'])
                    ],
                ];
            ?>
            <tr class="border-b border-gray-200 bg-gray-100">
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
                        <span class="font-medium">
                            <?=$data['NM_WP']?><br>
                            <?=$alamat_wp?>
                        </span>
                    </div>
                </td>
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="font-medium"><?= $alamat ?></span>
                    </div>
                </td>
            </tr>
            <?php foreach($child_data as $child): ?>
            <tr>
                <?php foreach($child as $key => $value): ?>
                <td class="py-3 px-6 text-left border" colspan="2">
                    <div class="flex items-center">
                        <span class="font-medium"><?=$key?> : <?=$value?></span>
                    </div>
                </td>
                <?php endforeach ?>
            </tr>
            <?php endforeach ?>
            <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</body>
</html>