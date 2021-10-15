<?php
$builder = new Builder;
$installation = $builder->get_installation();

$curr_page = isset($_GET['page']) && $_GET['page'] == 'builder/crud/index';

$pendataan = $curr_page && (isset($_GET['data']) ? arrStringContains($_GET['data'],['blok','znt','nir','jalan','subjek-pajak','objek-pajak-bumi','objek-pajak-bangunan'])  : false) ? 'bg-purple-700' : '';
$penilaian = $curr_page && (isset($_GET['data']) ? stringContains($_GET['data'],'penilaian') : false) ? 'bg-purple-700' : '';
$penetapan = $curr_page && (isset($_GET['data']) ? arrStringContains($_GET['data'],['penetapan-ppdb-minimal','penetapan-sppt','pelunasan']) : false) ? 'bg-purple-700' : '';
$referensi = $curr_page && (isset($_GET['data']) ? arrStringContains($_GET['data'],['kecamatan','kelurahan','tempat-bayar']) : false) ? 'bg-purple-700' : '';
$utility = $curr_page && (isset($_GET['data']) ? arrStringContains($_GET['data'],['role','user','pejabat']) : false) ? 'bg-purple-700' : '';

$znt = $curr_page && (isset($_GET['data']) ? arrStringContains($_GET['data'],['blok','znt','nir','jalan']) : false) ? 'bg-purple-700 text-white' : '';
$wilayah = $curr_page && (isset($_GET['data']) ? arrStringContains($_GET['data'],['kecamatan','kelurahan']) : false) ? 'bg-purple-700 text-white' : '';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $installation->app_name ?></title>
    <link rel="shortcut icon" href="<?=get_file_storage('installation/'.$installation->logo)?>" type="image/x-icon">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
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
    </style>
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
            <div class="nav-container w-full mr-2">
                <ul class="flex">
                    <li>
                        <a class="text-white hover:bg-purple-700 <?=$_GET['page'] == 'builder/home/dashboard' ? 'bg-purple-700' : ''?> p-2 px-4 inline-block" href="index.php?page=builder/home/dashboard">Home</a>
                    </li>
                    <li class="relative">
                        <a href="#" onclick="toggleNav('#pendataan')" class="cursor-pointer dropdown text-white hover:bg-purple-700 <?=$pendataan?> p-2 px-4 inline-block">
                            <span class=" capitalize">pendataan</span>
                            <i class="fa fa-caret-down  ml-2"></i>
                        </a>
                        <div class="nav-box absolute shadow bg-white hidden w-1/7 pt-2 text-left" id="pendataan" style="top:40px">
                            <div class="relative">
                                <a href="#" onclick="toggleNav('#zona-nilai-tanah')" class="cursor-pointer block dropdown px-4 py-3 hover:bg-purple-700 <?=$znt?> hover:text-white flex justify-between items-center">
                                    <span class=" capitalize">zona nilai tanah</span>
                                    <i class="fa fa-caret-right text-right ml-2"></i>
                                </a>
                                <div class="nav-box absolute shadow bg-white hidden w-1/7 pt-2 text-left left-full top-0" id="zona-nilai-tanah">
                                    <a href="?page=builder/crud/index&data=blok" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('blok') ?> hover:text-white">Blok</a>
                                    <a href="?page=builder/crud/index&data=znt" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('znt') ?> hover:text-white">ZNT</a>
                                    <a href="?page=builder/crud/index&data=nir" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('nir') ?> hover:text-white">NIR</a>
                                    <a href="?page=builder/crud/index&data=jalan" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('jalan') ?> hover:text-white">Nama Jalan</a>
                                </div>
                            </div>
                            <a href="#" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">DBKB</a>
                            <a href="?page=builder/crud/index&data=subjek-pajak" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('subjek-pajak') ?> hover:text-white">Subjek Pajak</a>
                            <a href="?page=builder/crud/index&data=objek-pajak-bumi" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('objek-pajak-bumi') ?> hover:text-white">Objek Pajak Bumi</a>
                            <a href="?page=builder/crud/index&data=objek-pajak-bangunan" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('objek-pajak-bangunan') ?> hover:text-white">Objek Pajak Bangunan</a>
                        </div>
                    </li>
                    <li class="relative">
                        <a href="#" onclick="toggleNav('#penilaian')" class="cursor-pointer dropdown text-white hover:bg-purple-700 <?=$penilaian?> p-2 px-4 inline-block">
                            <span class=" capitalize">penilaian</span>
                            <i class="fa fa-caret-down  ml-2"></i>
                        </a>
                        <div class="nav-box absolute shadow bg-white hidden w-1/7 pt-2 text-left" id="penilaian" style="top:40px">
                            <a href="?page=builder/crud/index&data=penilaian" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('penilaian') ?> hover:text-white">Penilaian</a>
                            <a href="#" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">Laporan</a>
                        </div>
                    </li>
                    <li class="relative">
                        <a href="#" onclick="toggleNav('#penetapan')" class="cursor-pointer dropdown text-white hover:bg-purple-700 <?=$penetapan?> p-2 px-4 inline-block">
                            <span class=" capitalize">penetapan</span>
                            <i class="fa fa-caret-down  ml-2"></i>
                        </a>
                        <div class="nav-box absolute shadow bg-white hidden w-1/7 pt-2 text-left" id="penetapan" style="top:40px">
                            <a href="?page=builder/crud/index&data=penetapan-pbb-minimal" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('penetapan-pbb-minimal') ?> hover:text-white">PBB Minimal</a>
                            <a href="#" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">Penetapan NJOPTKP</a>
                            <a href="?page=builder/crud/index&data=penetapan-sppt" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('penetapan-sppt') ?> hover:text-white">Penetapan SPPT</a>
                            <a href="?page=builder/crud/index&data=pelunasan" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('pelunasan') ?> hover:text-white">Pelunasan</a>
                        </div>
                    </li>
                    <li class="relative">
                        <a href="#" onclick="toggleNav('#referensi')" class="cursor-pointer dropdown text-white hover:bg-purple-700 <?=$referensi?> p-2 px-4 inline-block">
                            <span class=" capitalize">referensi</span>
                            <i class="fa fa-caret-down  ml-2"></i>
                        </a>
                        <div class="nav-box absolute shadow bg-white hidden w-1/7 pt-2 text-left" id="referensi" style="top:40px">
                            <div class="relative">
                                <a href="#" onclick="toggleNav('#wilayah')" class="cursor-pointer block dropdown px-4 py-3 hover:bg-purple-700 <?=$wilayah?> hover:text-white flex justify-between items-center">
                                    <span class=" capitalize">wilayah</span>
                                    <i class="fa fa-caret-right text-right ml-2"></i>
                                </a>
                                <div class="nav-box absolute shadow bg-white hidden w-1/7 pt-2 text-left left-full top-0" id="wilayah">
                                    <a href="?page=builder/crud/index&data=kecamatan" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('kecamatan')?> hover:text-white">Kecamatan</a>
                                    <a href="?page=builder/crud/index&data=kelurahan" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('kelurahan') ?> hover:text-white">Kelurahan</a>
                                </div>
                            </div>

                            <a href="#" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">Klasifikasi Tarif/Rumah/Bangunan</a>
                            <a href="?page=builder/crud/index&data=tempat-bayar" class="block px-4 py-3 hover:bg-purple-700 <?= getCurrentPageDataNav('tempat-bayar') ?> hover:text-white">Tempat Pembayaran</a>
                            <a href="#" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">Status Penggunaan Kayu Ulin</a>
                            <a href="#" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">Update Resources</a>
                            <a href="#" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">Posting SPPT Lama</a>
                        </div>
                    </li>
                    <li class="relative">
                        <a href="#" onclick="toggleNav('#laporan')" class="cursor-pointer dropdown text-white hover:bg-purple-700 p-2 px-4 inline-block">
                            <span class=" capitalize">laporan</span>
                            <i class="fa fa-caret-down  ml-2"></i>
                        </a>
                        <div class="nav-box absolute shadow bg-white hidden w-1/7 pt-2 text-left" id="laporan" style="top:40px">
                            <a href="#" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">SPPT</a>
                            <a href="#" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">SSPD</a>
                            <a href="#" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">DHKP</a>
                            <div class="relative">
                                <a href="#" onclick="toggleNav('#format-lama')" class="cursor-pointer block dropdown px-4 py-3 hover:bg-purple-700 hover:text-white flex justify-between items-center">
                                    <span class=" capitalize">format lama</span>
                                    <i class="fa fa-caret-right text-right ml-2"></i>
                                </a>
                                <div class="nav-box absolute shadow bg-white hidden w-1/7 pt-2 text-left left-full top-0" id="format-lama">
                                    <a href="#" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">SPPT</a>
                                    <a href="#" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">SSPD</a>
                                    <a href="#" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">DHKP</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="relative">
                        <a href="#" onclick="toggleNav('#utility')" class="cursor-pointer text-left dropdown text-white hover:bg-purple-700 <?=$utility?> p-2 px-4 inline-block">
                            <span class=" capitalize">utility</span>
                            <i class="fa fa-caret-down  ml-2"></i>
                        </a>
                        <div class="nav-box absolute shadow bg-white hidden w-1/7 pt-2 text-left" id="utility" style="top:40px">
                            <a href="?page=builder/crud/index&data=role" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('role') ?> hover:text-white">Roles</a>
                            <a href="?page=builder/crud/index&data=user" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('user') ?> hover:text-white">User</a>
                            <a href="?page=builder/crud/index&data=pejabat" class="block px-4 py-3 hover:bg-purple-700  <?= getCurrentPageDataNav('pejabat') ?> hover:text-white">Pejabat</a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="text-right leading-none flex items-center flex-row-reverse w-1/5">
                <div class="relative w-full">
                    <a href="#" onclick="toggleNav('#setting')" class="cursor-pointer dropdown leading-none text-white">
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