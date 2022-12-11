<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();
$mysql = new QueryBuilder("mysql");
$msg = get_flash_msg('success');
$error = get_flash_msg('error');
$submit = false;
$old = get_flash_msg('old');

$years = []; 

for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}


if(isset($_POST['submit']))
{
    unset($_POST['submit']);
    // check subjek pajak
    $subjek_pajak = $qb->select('DAT_SUBJEK_PAJAK')
                        ->where('SUBJEK_PAJAK_ID',$_POST['ID_WAJIB_PAJAK'])
                        ->where('NM_WP',$_POST['NAMA_WAJIB_PAJAK'])
                        ->first();
    if(!$subjek_pajak)
    {
        set_flash_msg(['error'=>'Pendaftaran e-SPPT gagal. ID Wajib Pajak dan Nama Wajib Pajak tidak sesuai / tidak ada.']);
        header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        return;
    }
    $insert = $mysql->create('esppt',$_POST)->exec();
    if($insert) {
        set_flash_msg(['success'=>'Berhasil Mendaftar. Data akan diverifikasi terlebih dahulu. Silahkan cek email anda secara berkala untuk mengetahui informasi terupdate.']);
        header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        return;
    }
}