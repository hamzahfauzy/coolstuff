<?php

require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();
$msg = get_flash_msg('success');
$failed = get_flash_msg('failed');
$mysql = new QueryBuilder("mysql");
$submit = false;
$jenis_op = '';
$data = [];
$dt = [];
$old = get_flash_msg('old');
$wajib_pajak_id = null;
$exists = [];

if(isset($_POST['proses_bangunan'])) {
    unset($_POST['proses_bangunan']);

    $ktp = upload($_FILES['KTP'],'ktp');
    $foto_objek = upload($_FILES['FOTO_OBJEK'],'foto-objek');
    $surat_tanah = upload($_FILES['SURAT_TANAH'],'surat-tanah');

    if ($ktp['status'] == 'success') {
        $_POST['KTP'] = $ktp['filename'];
    }

    if ($foto_objek['status'] == 'success') {
        $_POST['FOTO_OBJEK'] = $foto_objek['filename'];
    }

    if ($surat_tanah['status'] == 'success') {
        $_POST['SURAT_TANAH'] = $foto_objek['filename'];
    }

    $_POST['L_AC'] = http_build_query($_POST['L_AC'], '');
    $_POST['LPH'] = http_build_query($_POST['LPH'], '');
    $_POST['JLT_DL'] = http_build_query($_POST['JLT_DL'], '');
    $_POST['JLT_TL'] = http_build_query($_POST['JLT_TL'], '');
    $_POST['PAGAR'] = http_build_query($_POST['PAGAR'], '');
    $_POST['LTB'] = http_build_query($_POST['LTB'], '');
    $_POST['J_LIFT'] = http_build_query($_POST['J_LIFT'], '');
    $_POST['OTHERS'] = http_build_query($_POST['OTHERS'], '');
    $_POST['KOLAM_RENANG'] = http_build_query($_POST['KOLAM_RENANG'], '');
    $_POST['WAJIB_PAJAK_ID'] = $wajib_pajak_id;
    $insert = $mysql->create('DAT_OP_BANGUNAN',$_POST)->exec();
    if ($insert) {
        set_flash_msg(['success'=>'Berhasil Mendaftar, Data akan diverifikasi terlebih dahulu!']);
        header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        return;
    } else {
        parse_str($_POST['L_AC'], $_POST['L_AC']);
        parse_str($_POST['LPH'], $_POST['LPH']);
        parse_str($_POST['JLT_DL'], $_POST['JLT_DL']);
        parse_str($_POST['JLT_TL'], $_POST['JLT_TL']);
        parse_str($_POST['PAGAR'], $_POST['PAGAR']);
        parse_str($_POST['LTB'], $_POST['LTB']);
        parse_str($_POST['J_LIFT'], $_POST['J_LIFT']);
        parse_str($_POST['OTHERS'], $_POST['OTHERS']);
        parse_str($_POST['KOLAM_RENANG'], $_POST['KOLAM_RENANG']);
        set_flash_msg(['old'=>$_POST, 'failed'=>'Gagal Mendaftar, Silahkan Cek Ulang Data yang didaftarkan']);
        header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        return;
    }
}



if(isset($_POST['proses_bumi'])) {
    unset($_POST['proses_bumi']);
    
    // $target_dir = "uploads/";
    // $ktp_file = $target_dir . "ktp/" . basename($_FILES["KTP"]["name"]);
    // $ktp = move_uploaded_file($_FILES["KTP"]["tmp_name"], $ktp_file);
    $ktp = upload($_FILES['KTP'],'ktp');

    if ($ktp) {
        $_POST['KTP'] = $ktp['filename'];
    }

    // $FOTO_OBJEK_file = $target_dir . "foto-objek/" . basename($_FILES["FOTO_OBJEK"]["name"]);
    // $FOTO_OBJEK = move_uploaded_file($_FILES["FOTO_OBJEK"]["tmp_name"], $FOTO_OBJEK_file);
    $FOTO_OBJEK = upload($_FILES['FOTO_OBJEK'],'foto-objek');

    if ($FOTO_OBJEK) {
        $_POST['FOTO_OBJEK'] = $FOTO_OBJEK['filename'];
    }
    

    // $SURAT_TANAH_file = $target_dir . "surat-tanah/" . basename($_FILES["SURAT_TANAH"]["name"]);
    // $SURAT_TANAH = move_uploaded_file($_FILES["SURAT_TANAH"]["tmp_name"], $SURAT_TANAH_file);
    $SURAT_TANAH = upload($_FILES['SURAT_TANAH'],'surat-tanah');

    if ($SURAT_TANAH) {
        $_POST['SURAT_TANAH'] = $SURAT_TANAH['filename'];
    }

    // print_r($ktp_file);
    
    // die;

    $_POST['WAJIB_PAJAK_ID'] = $wajib_pajak_id;
    $_POST['NO_SPOP'] = $_POST['KD_KECAMATAN'].$_POST['KD_KELURAHAN'].$_POST['NO_URUT'];
    $insert = $mysql->create('DAT_OP_BUMI',$_POST)->exec();
    if($insert) {
        set_flash_msg(['success'=>'Berhasil Mendaftar, Data akan diverifikasi terlebih dahulu!']);
        header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        return;
    }  else {
        set_flash_msg(['old'=>$_POST, 'failed'=>'Gagal Mendaftar, Silahkan Cek Ulang Data yang didaftarkan']);
        header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        return;
    }
}

if (isset($_POST['submit'])) {
    $submit = true;
    $jenis_op = $_POST['jenis_op'];
    
    $clause = "concat(KD_PROPINSI,'.', KD_DATI2,'.',KD_KECAMATAN, '.', KD_KELURAHAN , '.' , KD_BLOK , '-' , NO_URUT , '.' , KD_JNS_OP)";;
    if ($jenis_op == 'bangunan') {
        $StrQ = "Select *,$clause as NOP From DAT_OP_BUMI WHERE $clause =  '" . trim($_POST['NOPQ']) . "'";
        $strExists = "Select *, $clause as NOP, NO_BNG From DAT_OP_BANGUNAN WHERE $clause =  '" . trim($_POST['NOPQ']) . "' order by NO_BNG*1 DESC";
        $exists = $qb->rawQuery($strExists)->first();
        if($_POST['status'] == 'Terdaftar') {
            $data = $qb->rawQuery($StrQ)->first();
        } else {
            $dt = $qb->rawQuery($StrQ)->first();
        }
    } else if($jenis_op == 'bumi') {
        if($_POST['status'] == 'Terdaftar') {
            $strQ = "Select *, $clause as NOP from DAT_OP_BUMI where $clause='$_POST[NOPQ]'";
            $data = $qb->rawQuery($strQ)->first();
        }
    }
}

if($submit){
    $kecamatans = $qb->select('REF_KECAMATAN')->orderby('KD_KECAMATAN')->get();
    $old = get_flash_msg("old");

    $datOP = $qb->select("DAT_OBJEK_PAJAK")->where("SUBJEK_PAJAK_ID",$_POST['ID'])->where('KD_KECAMATAN',$data['KD_KECAMATAN'])->where('KD_KELURAHAN',$data['KD_KELURAHAN'])->where('KD_BLOK',$data['KD_BLOK'])->first();
    
    $kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$data['KD_KECAMATAN'])->orderby('KD_KELURAHAN')->get();
    $bloks = $qb->select("DAT_PETA_BLOK")->where('KD_KECAMATAN',$data['KD_KECAMATAN'])->where('KD_KELURAHAN',$data['KD_KELURAHAN'])->orderby('KD_BLOK')->get();
    $znts = $qb->select("DAT_PETA_ZNT")->where('KD_KECAMATAN',$data['KD_KECAMATAN'])->where('KD_KELURAHAN',$data['KD_KELURAHAN'])->where('KD_BLOK',$data['KD_BLOK'])->orderby('KD_ZNT')->get();
    $jalans = $qb->select("JALAN")->where('KD_KECAMATAN',$data['KD_KECAMATAN'])->where('KD_KELURAHAN',$data['KD_KELURAHAN'])->orderby('KD_ZNT')->get();

    $jenisBumis = ["01-TANAH DAN BANGUNAN","02-KAVLING SIAP BANGUN","03-TANAH KOSONG","04-FASILITAS UMUM"];
    $kondisis = ["01-Sangat Baik","02-Baik","03-Sedang","04-Jelek"];
    $konstruksis = ["01-Baja","02-Beton","03-Batu Bata","04-Kayu"];
    $ataps = ["01-Decrabon/Beton/Gtg Glazur","02-Gtg Beton/Aluminium","03-Gtg Biasa/Sirap","04-Asbes","05-Seng"];
    $dindings = ["01-Kaca/Aluminium","02-Beton","03-Batu Bata/Conblok","04-Kayu","05-Seng","06-Spandex"];
    $lantais = ["01-Marmer","02-Keramik","03-Teraso","04-Ubin PC/Papan","05-Semen"];
    $langits = ["01-Akuistik/Jati","02-Triplek/Asbes/Bambu","30-Tidak Ada"];
    $jpbs = $qb->select('REF_JPB')->orderBy('KD_JPB')->get();

    $years = []; 

    for($i = 0 ; $i<100;$i++){
        $years[] = date("Y",strtotime("-$i year"));
    }
}