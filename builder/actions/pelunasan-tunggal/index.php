<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$failed = get_flash_msg('failed');
$qb = new QueryBuilder();

if(isset($_GET['check'])){
    // d_YAR = "SELECT KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, THN_PAJAK_SPPT, KD_KANWIL_BANK, KD_KPPBB_BANK, KD_BANK_TUNGGAL, KD_BANK_PERSEPSI, KD_TP, sum(DENDA_SPPT) as TOT_DENDA, Sum(JML_SPPT_YG_DIBAYAR) AS TOT_BAYAR, TGL_PEMBAYARAN_SPPT, TGL_REKAM_BYR_SPPT, NIP_REKAM_BYR_SPPT" & _
    //         " From PEMBAYARAN_SPPT GROUP BY KD_PROPINSI, KD_DATI2, KD_KECAMATAN, KD_KELURAHAN, KD_BLOK, NO_URUT, KD_JNS_OP, THN_PAJAK_SPPT, KD_KANWIL_BANK, KD_KPPBB_BANK, KD_BANK_TUNGGAL, KD_BANK_PERSEPSI, KD_TP, TGL_PEMBAYARAN_SPPT, TGL_REKAM_BYR_SPPT, NIP_REKAM_BYR_SPPT, [KD_PROPINSI]+'.'+[KD_DATI2]+'.'+[KD_KECAMATAN]+'.'+[KD_KELURAHAN]+'.'+[KD_BLOK]+'-'+[NO_URUT]+'.'+[KD_JNS_OP] " & _
    //         " HAVING (((THN_PAJAK_SPPT)='" & ccTahun.Text & "') AND (([KD_PROPINSI]+'.'+[KD_DATI2]+'.'+[KD_KECAMATAN]+'.'+[KD_KELURAHAN]+'.'+[KD_BLOK]+'-'+[NO_URUT]+'.'+[KD_JNS_OP])='" & aNOP.Text & "' ))"

    $sql = "Select * From PEMBAYARAN_SPPT WHERE KD_PROPINSI + '.' + KD_DATI2  +'.' + KD_KECAMATAN +'.' + KD_KELURAHAN +'.' + KD_BLOK +'-' +NO_URUT +'.' +KD_JNS_OP= '" .  $_GET['NOP'] . "' and THN_PAJAK_SPPT='" .  $_GET['year'] . "'";

    $sppt = $qb->rawQuery($sql)->first();

    echo json_encode($sppt);
    die;
}

if(isset($_GET['check-delete'])){
    $d_YAR = "select *  From PEMBAYARAN_SPPT where KD_PROPINSI + '.' + KD_DATI2  +'.' + KD_KECAMATAN +'.' + KD_KELURAHAN +'.' + KD_BLOK +'-' +NO_URUT +'.' +KD_JNS_OP= '" .  $_GET['NOP'] . "' and THN_PAJAK_SPPT='" .  $_GET['year'] . "' AND PEMBAYARAN_SPPT_KE='" .  $_GET['SPPT_KE'] . "'";
    
    // $d_YAR = "DELETE  From PEMBAYARAN_SPPT where KD_PROPINSI + '.' + KD_DATI2  +'.' + KD_KECAMATAN +'.' + KD_KELURAHAN +'.' + KD_BLOK +'-' +NO_URUT +'.' +KD_JNS_OP= '" .  $_GET['NOP'] . "' and THN_PAJAK_SPPT='" .  $_GET['year'] . "' AND PEMBAYARAN_SPPT_KE='" .  $_GET['SPPT_KE'] . "'";

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

if(request() == 'POST'){

    $sql = "Select * From SPPT WHERE KD_PROPINSI + '.' + KD_DATI2  +'.' + KD_KECAMATAN +'.' + KD_KELURAHAN +'.' + KD_BLOK +'-' +NO_URUT +'.' +KD_JNS_OP= '" .  $_GET['NOP'] . "' and (PROSES='M' OR PROSES='T')and THN_PAJAK_SPPT='" .  $_GET['year'] . "'";

    $data = $qb->rawQuery($sql)->first();

    if($data){

        if(isset($_POST['delete']) && $_POST['delete'] == 'on'){
            $d_YAR = "DELETE  From PEMBAYARAN_SPPT where KD_PROPINSI + '.' + KD_DATI2  +'.' + KD_KECAMATAN +'.' + KD_KELURAHAN +'.' + KD_BLOK +'-' +NO_URUT +'.' +KD_JNS_OP= '" .  $_POST['NOP'] . "' and THN_PAJAK_SPPT='" .  $_POST['year'] . "' AND PEMBAYARAN_SPPT_KE='" .  $_GET['SPPT_KE'] . "'";

            $C_STR = "HAPUS_LUNAS_TUNGGAL '" . $_POST['year'] . "','" . $_POST['SPPT_KE'] . "','" . $_POST['NOP'] . "'";
            
            $qb->rawQuery($C_STR)->exec();
        }

    }

    $C_STR = "LUNAS_TUNGGAL '" . $_POST['YEAR'] . "','" . $_POST['SPPT_KE'] . "','" . $_POST['KD_BAYAR'] . "','" . round($_POST['DENDA']) . "','" . $_POST['TGL_PEMBAYARAN'] . "','" . $_POST['TGL_PEREKAM'] . "', '" . $_POST['NIP'] . "','" . $_POST['NOP'] . "','" . $_POST['JLH_DIBAYARKAN'] . "'";
    
    $massal = $qb->rawQuery($C_STR)->exec();

    if($massal){
        set_flash_msg(['success'=>'Pelunasan: Sukses!']);
        header("location:index.php?page=builder/pelunasan-tunggal/index");
        return;
    }else{
        set_flash_msg(['failed'=>'Pelunasan: Gagal!']);
        header("location:index.php?page=builder/pelunasan-tunggal/index");
        return;
    }


}

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

$year = date("Y");