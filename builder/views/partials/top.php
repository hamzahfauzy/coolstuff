<?php
$builder = new Builder;
$installation = $builder->get_installation();

$nav_class_active = 'bg-purple-700 text-white';

$hidden = 'hidden';

$modules = getModules();

$pendataan_data = $modules['pendataan'];

$penilaian_data = $modules['penilaian'];

$penetapan_data = $modules['penetapan'];

$referensi_data = $modules['referensi'];

$utility_data = $modules['utility'];

$laporan_data = $modules['laporan'];

$penatausahaan_data = $modules['penatausahaan'];

$user = $_SESSION['auth'];

$builder = new Builder;
$json_modules = $builder->get_content('modules');

$data_key = null;

$module = [];

foreach ($json_modules as $key => $value) {

    $value = (array) $value;

    if($value['code'] == $user['role']){
        $data_key = $key;
        $module = $value;
        break;
    }
}

unset($module['code']);

$module = json_encode(array_keys($module));

$penatausahaan = (isset($_GET['page']) && arrStringContains($_GET['page'],$penatausahaan_data) ? $nav_class_active : '');
$pendataan = (isset($_GET['page']) && arrStringContains($_GET['page'],$pendataan_data) ? $nav_class_active : '');
$penilaian = (isset($_GET['page']) && arrStringContains($_GET['page'],$penilaian_data) ? $nav_class_active : '');
$penetapan = (isset($_GET['page']) && arrStringContains($_GET['page'],$penetapan_data) ? $nav_class_active : '');

$referensi = (isset($_GET['page']) && arrStringContains($_GET['page'],$referensi_data) ? $nav_class_active : '');
$utility = (isset($_GET['page']) && arrStringContains($_GET['page'],$utility_data) ? $nav_class_active : '');
$laporan = (isset($_GET['page']) && arrStringContains($_GET['page'],$laporan_data) ? $nav_class_active : '');

$dbkb = (isset($_GET['page']) && arrStringContains($_GET['page'],$pendataan_data['dbkb']) ? $nav_class_active : '');

$znt = (isset($_GET['page']) && arrStringContains($_GET['page'],$pendataan_data['znt']) ? $nav_class_active : '');

$objek_pajak = (isset($_GET['page']) && arrStringContains($_GET['page'],$pendataan_data['objek-pajak'])) ? $nav_class_active : '';

$wilayah = isset($_GET['page']) ? arrStringContains($_GET['page'],$referensi_data['wilayah']) ? $nav_class_active : '' : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $installation->app_name ?></title>
    <link rel="shortcut icon" href="<?=get_file_storage('installation/'.$installation->logo)?>" type="image/x-icon">
    <link href="css/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;500&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        .nav-box a:not(.nav-box a:last-child){
            border-bottom:1px solid #E5E7EB;
        }
        .nav-container li{
            width:100%;
        }

        .dropdown{
            display:flex;
            /* justify-content:center; */
            align-items:center;
        }

        /* width */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
        background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
        background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
        background: #555;
        }

    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
</head>
<body>
    <div class="nav bg-white w-full">
        <div class="lg:max-w-screen-lg lg:mx-auto flex py-4 justify-center">
            <div class="nav-brand flex items-center">
                <img src="<?=get_file_storage('installation/'.$installation->logo)?>" width="30px">
                <h3 class="font-semibold text-xl ml-4"><?= $installation->app_name ?></h3>
            </div>
        </div>
    </div>
    <div class="nav bg-green-500 shadow w-full">
        <div class="lg:max-w-screen-lg lg:mx-auto mx-6 flex justify-between">
            <div class="nav-container w-full mr-1">
                <ul class="flex">
                    <li>
                        <a class="text-white hover:bg-purple-700 <?=$_GET['page'] == 'builder/home/dashboard' ? $nav_class_active : ''?> p-2 px-4 inline-block" href="index.php?page=builder/home/dashboard">Home</a>
                    </li>
                    <li class="relative">
                        <a href="#" onclick="toggleNav('#pendataan')" class="cursor-pointer dropdown text-white hover:bg-purple-700 <?=$pendataan?> p-2 px-4 inline-block">
                            <span class=" capitalize">pendataan</span>
                            <i class="fa fa-caret-down  ml-2"></i>
                        </a>
                        <div class="nav-box absolute shadow bg-white hidden w-max pt-2 text-left" id="pendataan" style="top:40px">
                            <div class="relative">
                                <a href="#" onclick="toggleNav('#zona-nilai-tanah')" class="cursor-pointer block dropdown px-4 py-3 hover:bg-purple-700 <?=$znt?> hover:text-white flex justify-between items-center">
                                    <span class=" capitalize">zona nilai tanah</span>
                                    <i class="fa fa-caret-right text-right ml-2"></i>
                                </a>
                                <div class="nav-box absolute shadow bg-white hidden w-max pt-2 text-left left-full top-0" id="zona-nilai-tanah">
                                    <a href="?page=builder/blok/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('blok') ?> hover:text-white">Blok</a>
                                    <a href="?page=builder/znt/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('znt') ?> hover:text-white">ZNT</a>
                                    <a href="?page=builder/nir/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('nir') ?> hover:text-white">NIR</a>
                                    <a href="?page=builder/nama-jalan/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('nama-jalan') ?> hover:text-white">Nama Jalan</a>
                                </div>
                            </div>
                            <div class="relative">
                                <a href="#" onclick="toggleNav('#dbkb')" class="cursor-pointer block dropdown px-4 py-3 hover:bg-purple-700 <?=$dbkb?> hover:text-white flex justify-between items-center">
                                    <span class=" capitalize">DBKB</span>
                                    <i class="fa fa-caret-right text-right ml-2"></i>
                                </a>
                                <div class="nav-box absolute shadow bg-white hidden w-max pt-2 text-left left-full top-0" id="dbkb">
                                    <a href="?page=builder/dbkb-utama-material/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('dbkb-utama-material') ?> hover:text-white">DBKB Utama dan Material</a>
                                    <a href="?page=builder/dbkb-fasilitas/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('dbkb-fasilitas') ?> hover:text-white">DBKB Fasilitas</a>
                                    <a href="?page=builder/dbkb-utama/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('dbkb-utama') ?> hover:text-white">DBKB Utama</a>
                                    <a href="?page=builder/dbkb-material/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('dbkb-material') ?> hover:text-white">DBKB Material</a>
                                </div>
                            </div>
                            <a href="?page=builder/subjek-pajak/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('subjek-pajak') ?> hover:text-white">Subjek Pajak</a>
                            <div class="relative">
                                <a href="#" onclick="toggleNav('#objek-pajak')" class="cursor-pointer block dropdown px-4 py-3 hover:bg-purple-700 <?=$objek_pajak?> hover:text-white flex justify-between items-center">
                                    <span class=" capitalize">objek pajak</span>
                                    <i class="fa fa-caret-right text-right ml-2"></i>
                                </a>
                                <div class="nav-box absolute shadow bg-white hidden w-max pt-2 text-left left-full top-0" id="objek-pajak">
                                    <a href="?page=builder/objek-pajak-bumi/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('objek-pajak-bumi') ?> hover:text-white">Objek Pajak Bumi</a>
                                    <a href="?page=builder/objek-pajak-bangunan/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('objek-pajak-bangunan') ?> hover:text-white">Objek Pajak Bangunan</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="relative">
                        <a href="#" onclick="toggleNav('#penilaian')" class="cursor-pointer dropdown text-white hover:bg-purple-700 <?=$penilaian?> p-2 px-4 inline-block">
                            <span class=" capitalize">penilaian</span>
                            <i class="fa fa-caret-down  ml-2"></i>
                        </a>
                        <div class="nav-box absolute shadow bg-white hidden w-max pt-2 text-left" id="penilaian" style="top:40px">
                            <a href="?page=builder/penilaian-massal/index" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('penilaian-massal') ?> hover:text-white">Penilaian Massal</a>
                            <div class="relative">
                                <a href="#" onclick="toggleNav('#laporan-penilaian')" class="cursor-pointer block dropdown px-4 py-3 hover:bg-purple-700 <?=$znt?> hover:text-white flex justify-between items-center">
                                    <span class=" capitalize">Laporan</span>
                                    <i class="fa fa-caret-right text-right ml-2"></i>
                                </a>
                                <div class="nav-box absolute shadow bg-white hidden w-max pt-2 text-left left-full top-0" id="laporan-penilaian">
                                    <a href="?page=builder/penilaian/laporan/perbandingan-penilaian-bumi-dan-bangunan/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('perbandingan-penilaian-bumi-dan-bangunan') ?> hover:text-white">Perbandingan dengan Tahun Sebelumnya</a>
                                    <a href="?page=builder/penilaian/laporan/bumi" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('bumi-masal') ?> hover:text-white">Bumi</a>
                                    <a href="?page=builder/penilaian/laporan/bangunan" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('bangunan-individu') ?> hover:text-white">Bangunan</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="relative">
                        <a href="#" onclick="toggleNav('#penetapan')" class="cursor-pointer dropdown text-white hover:bg-purple-700 <?=$penetapan?> p-2 px-4 inline-block">
                            <span class=" capitalize">penetapan</span>
                            <i class="fa fa-caret-down  ml-2"></i>
                        </a>
                        <div class="nav-box absolute shadow bg-white hidden w-max pt-2 text-left" id="penetapan" style="top:40px">
                            <a href="?page=builder/pbb-minimal/index" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('pbb-minimal') ?> hover:text-white">PBB Minimal</a>
                            <a href="?page=builder/penetapan-njoptkp/index" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('penetapan-njoptkp') ?> hover:text-white">Penetapan NJOPTKP</a>
                            <a href="?page=builder/penetapan-sppt/index" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('penetapan-sppt') ?> hover:text-white">Penetapan SPPT</a>
                            <a href="?page=builder/pelunasan-massal/index" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('pelunasan-massal') ?> hover:text-white">Pelunasan Massal</a>
                            <a href="?page=builder/pelunasan-tunggal/index" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('pelunasan-tunggal') ?> hover:text-white">Pelunasan Tunggal</a>
                        </div>
                    </li>
                    <li class="relative">
                        <a href="#" onclick="toggleNav('#referensi')" class="cursor-pointer dropdown text-white hover:bg-purple-700 <?=$referensi?> p-2 px-4 inline-block">
                            <span class=" capitalize">referensi</span>
                            <i class="fa fa-caret-down  ml-2"></i>
                        </a>
                        <div class="nav-box absolute shadow bg-white hidden w-max pt-2 text-left" id="referensi" style="top:40px">
                            <div class="relative">
                                <a href="#" onclick="toggleNav('#wilayah')" class="cursor-pointer block dropdown px-4 py-3 hover:bg-purple-700 <?=$wilayah?> hover:text-white flex justify-between items-center">
                                    <span class=" capitalize">wilayah</span>
                                    <i class="fa fa-caret-right text-right ml-2"></i>
                                </a>
                                <div class="nav-box absolute shadow bg-white hidden w-max pt-2 text-left left-full top-0" id="wilayah">
                                    <a href="?page=builder/kecamatan/index" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('kecamatan')?> hover:text-white">Kecamatan</a>
                                    <a href="?page=builder/kelurahan/index" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('kelurahan') ?> hover:text-white">Kelurahan</a>
                                </div>
                            </div>

                            <a href="#" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">Klasifikasi Tarif/Rumah/Bangunan</a>
                            <a href="?page=builder/tempat-pembayaran/index" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('tempat-pembayaran') ?> hover:text-white">Tempat Pembayaran</a>
                            <a href="?page=builder/kayu-ulin/index" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('kayu-ulin') ?> hover:text-white">Status Penggunaan Kayu Ulin</a>
                            <a href="?page=builder/update-resources/index" class="block px-4 py-3 hover:bg-purple-700 hover:text-white <?= getCurrentPageDataNav('update-resources') ?>">Update Resources</a>
                            <a href="?page=builder/posting-sppt-lama/index" class="block px-4 py-3 hover:bg-purple-700 hover:text-white <?= getCurrentPageDataNav('posting-sppt-lama') ?>">Posting SPPT Lama</a>
                        </div>
                    </li>
                    <li class="relative">
                        <a href="#" onclick="toggleNav('#laporan')" class="cursor-pointer dropdown text-white hover:bg-purple-700 <?=$laporan?> p-2 px-4 inline-block">
                            <span class=" capitalize">laporan</span>
                            <i class="fa fa-caret-down  ml-2"></i>
                        </a>
                        <div class="nav-box absolute shadow bg-white hidden w-max pt-2 text-left" id="laporan" style="top:40px">
                            <a href="?page=builder/laporan/sppt/index" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('laporan/sppt') ?> hover:text-white">SPPT</a>
                            <a href="?page=builder/laporan/sspd/index" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('laporan/sspd') ?> hover:text-white">SSPD</a>
                            <a href="?page=builder/laporan/dhkp/index" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('laporan/dhkp') ?> hover:text-white">DHKP</a>
                            <a href="?page=builder/laporan/klasifikasi-dan-besaran-njop-bumi/index" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('laporan/klasifikasi-dan-besaran-njop-bumi') ?> capitalize hover:text-white">klasifikasi dan besaran njop bumi</a>
                            <a href="?page=builder/laporan/dbkb/index" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('laporan/dbkb') ?> hover:text-white">DBKB</a>
                            <a href="?page=builder/laporan/simulasi-penetapan-sppt/index" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('laporan/simulasi-penetapan-sppt') ?> hover:text-white">Simulasi Perbandingan SPPT</a>
                        </div>
                    </li>
                    <li class="relative">
                        <a href="#" onclick="toggleNav('#utility')" class="cursor-pointer text-left dropdown text-white hover:bg-purple-700 <?=$utility?> p-2 px-4 inline-block">
                            <span class=" capitalize">utility</span>
                            <i class="fa fa-caret-down  ml-2"></i>
                        </a>
                        <div class="nav-box absolute shadow bg-white hidden w-max pt-2 text-left" id="utility" style="top:40px">
                            <a href="?page=builder/roles/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('roles') ?> hover:text-white">Roles</a>
                            <a href="?page=builder/users/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('users') ?> hover:text-white">Users</a>
                            <a href="?page=builder/pejabat/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('pejabat') ?> hover:text-white">Pejabat</a>
                        </div>
                    </li>
                    <li class="relative">
                        <a href="#" onclick="toggleNav('#penatausahaan')" class="cursor-pointer text-left dropdown text-white hover:bg-purple-700 <?=$penatausahaan?> p-2 px-4 inline-block">
                            <span class=" capitalize">Penatausahaan</span>
                            <i class="fa fa-caret-down  ml-2"></i>
                        </a>
                        <div class="nav-box absolute shadow bg-white hidden w-max pt-2 text-left" id="penatausahaan" style="top:40px">
                            <a href="?page=builder/penatausahaan/laporan-realistis/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('laporan-realistis') ?> hover:text-white">Laporan Realistis</a>
                            <a href="?page=builder/penatausahaan/laporan-piutang/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('laporan-piutang') ?> hover:text-white">Laporan Piutang</a>
                            <a href="?page=builder/penatausahaan/surat-tagihan/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('surat-tagihan') ?> hover:text-white">Surat Tagihan</a>
                            <a href="?page=builder/penatausahaan/status-wajib-pajak/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('status-wajib-pajak') ?> hover:text-white">Status Wajib Pajak</a>
                            <a href="?page=builder/penatausahaan/log-perubahan-objek/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('log-perubahan-objek') ?> hover:text-white">Log Perubahan Objek</a>
                            <a href="?page=builder/penatausahaan/log-objek-baru/index" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('log-objek-baru') ?> hover:text-white">Log Objek Baru</a>
                        </div>
                    </li>
                </ul>
            </div>  
            <div class="text-right leading-none flex items-center flex-row-reverse w-1/5">
                <div class="relative w-full">
                    <a href="#" onclick="toggleNav('#setting')" class="cursor-pointer dropdown float-right leading-none text-white">
                        <span class="align-text-top"><?=strlen($_SESSION['auth']['username']) > 7 ? substr($_SESSION['auth']['username'],0,7).'..' : $_SESSION['auth']['username']?></span>
                        <i class="fa fa-user-circle text-purple-700 text-2xl ml-2"></i> 
                        <i class="fa fa-caret-down align-text-top ml-2"></i>
                    </a>
                    <div class="nav-box absolute shadow bg-white hidden w-full pt-2 text-left" id='setting' style="top:35px;">
                        <a href="index.php" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">Open Site</a>
                        <a href="?page=builder/setting/index" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">Site Setting</a>
                        <a href="?action=auth/logout" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">Keluar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main bg-gray-100" style="min-height:calc(100vh - 58px);height:auto;">

    <script>

        var mdl = <?= $module ?>

        var anchors = document.querySelectorAll(".nav .nav-container a:not(.dropdown)")

        anchors.forEach(item=>{
            if(!mdl.includes(item.href.split('?page=')[1])){
                item.classList.add('hidden')
            }
        })

    </script>