<?php

require '../helpers/QueryBuilder.php';

// $qb = new QueryBuilder();
$mysql = new QueryBuilder("mysql");
$msg = get_flash_msg('success');
$submit = false;
$old = get_flash_msg('old');

$years = []; 

for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}


if(isset($_POST['submit']))
{
    unset($_POST['submit']);
    $insert = $mysql->create('esppt',$_POST)->exec();
    if($insert) {
        set_flash_msg(['success'=>'Berhasil Mendaftar, Data akan diverifikasi terlebih dahulu!']);
        header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        return;
    }
}