<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$failed = get_flash_msg('failed');
$qb = new QueryBuilder();

if(isset($_GET['check'])){
    $sql = "select * From SPPT where KD_KECAMATAN='" . $_GET['kecamatan'] . "' AND KD_KELURAHAN='" .  $_GET['kelurahan'] . "' AND THN_PAJAK_SPPT='" .  $_GET['year'] . "' and (PROSES='M' or PROSES='T')";

    $pbb = $qb->rawQuery($sql)->first();

    echo $pbb ? 1 : 0;
    die;
}

if(isset($_GET['check-delete'])){
    $d_YAR = "select * From PEMBAYARAN_SPPT where KD_KECAMATAN='" . $_GET['kecamatan'] . "' AND KD_KELURAHAN='" . $_GET['kelurahan'] . "' AND THN_PAJAK_SPPT='" . $_GET['year'] . "'";

    $sppt = $qb->rawQuery($d_YAR)->first();

    echo $sppt ? 1 : 0;
    die;
}

if(isset($_GET['filter-kecamatan'])){
    $kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$_GET['filter-kecamatan'])->get();

    echo json_encode($kelurahans);
    die;
}

$tBayars = $qb->select("TEMPAT_BAYAR")->orderBy('KD_TP')->get();
$kecamatans = $qb->select("REF_KECAMATAN")->get();

if(request() == 'POST'){

    $d_YAR = "select * From PEMBAYARAN_SPPT where KD_KECAMATAN='" . $_POST['KD_KECAMATAN'] . "' AND KD_KELURAHAN='" . $_POST['KD_KELURAHAN'] . "' AND THN_PAJAK_SPPT='" . $_POST['YEAR'] . "'";

    $data = $qb->rawQuery($d_YAR)->first();

    if($data){

        if(isset($_POST['delete']) && $_POST['delete'] == 'on'){
            $C_STR = "HAPUS_LUNAS_MASSAL '" . $_POST['KD_KECAMATAN'] . "','" . $_POST['KD_KELURAHAN'] . "','" . $_POST['YEAR'] . "','3'";
            
            $massal = $qb->rawQuery($C_STR)->exec();
        }

    }

    $C_STR = "LUNAS_MASSAL '" . $_POST['KD_KECAMATAN'] . "','" . $_POST['KD_KELURAHAN'] . "','" . $_POST['YEAR'] . "','" . $_POST['KD_BAYAR'] . "','" . ROUND($_POST['DENDA']) . "','" . $_POST['TGL_PEMBAYARAN'] . "','" . $_POST['TGL_PEREKAM'] . "', '" . $_POST['NIP'] . "','3'";
    
    $massal = $qb->rawQuery($C_STR)->exec();

    if($massal){
        set_flash_msg(['success'=>'Pelunasan: Sukses!']);
        header("location:index.php?page=builder/pelunasan-massal/index");
        return;
    }else{
        set_flash_msg(['failed'=>'Pelunasan: Gagal!']);
        header("location:index.php?page=builder/pelunasan-massal/index");
        return;
    }


}

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

$year = date("Y");