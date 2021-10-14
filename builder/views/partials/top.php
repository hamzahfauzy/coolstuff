<?php
$builder = new Builder;
$installation = $builder->get_installation();
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
                        <a class="text-white hover:bg-purple-700 p-2 px-4 inline-block" href="index.php?page=builder/home/dashboard">Home</a>
                    </li>
                    <li>
                        <a class="text-white hover:bg-purple-700 p-2 px-4 inline-block" href="index.php?page=builder/crud/index&data=page">Pages</a>
                    </li>
                    <li>
                        <a class="text-white hover:bg-purple-700 p-2 px-4 inline-block" href="index.php?page=builder/crud/index&data=kecamatan">Kecamatan</a>
                    </li>
                    <li>
                        <a class="text-white hover:bg-purple-700 p-2 px-4 inline-block" href="index.php?page=builder/crud/index&data=kelurahan">Kelurahan</a>
                    </li>
                    <li>
                        <a class="text-white hover:bg-purple-700 p-2 px-4 inline-block" href="index.php?page=builder/crud/index&data=blok">Blok</a>
                    </li>
                    <li>
                        <a class="text-white hover:bg-purple-700 p-2 px-4 inline-block" href="index.php?page=builder/crud/index&data=menu">Menus</a>
                    </li>
                    <li class="relative w-full">
                        <a href="#" onclick="toggleNav('#utility')" class="cursor-pointer dropdown text-white hover:bg-purple-700 p-2 px-4 inline-block">
                            <span class="align-text-center">Utility</span>
                            <i class="fa fa-caret-down align-text-center ml-2"></i>
                        </a>
                        <div class="nav-box absolute shadow bg-white hidden w-1/7 pt-2 text-left" id="utility" style="top:40px">
                            <a href="index.php" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">Open Site</a>
                            <a href="?page=builder/setting/index" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">Site Setting</a>
                            <a href="?action=auth/logout" class="block px-4 py-3 hover:bg-purple-700 hover:text-white">Keluar</a>
                        </div>
                        <!-- <a class="text-white hover:bg-purple-700 p-2 px-4 inline-block" href="index.php?page=builder/crud/index&data=menu">Menus</a> -->
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