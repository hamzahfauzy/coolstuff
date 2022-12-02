<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();
$mysql = new QueryBuilder("mysql");

if(isset($_GET['act'])) {
   switch ($_GET['act']) {

    case 'accept_bumi':
        
        $mysql->update('DAT_OP_BUMI', ['STATUS'=>'DITERIMA'])->where('ID',$_GET['act_id'])->exec();
        set_flash_msg(['success'=>'Data Bumi Berhasil Diterima!']);
        break;

    case 'accept_bng':
        
        $mysql->update('DAT_OP_BANGUNAN', ['STATUS'=>'DITERIMA'])->where('ID',$_GET['act_id'])->exec();
        set_flash_msg(['success'=>'Bangunan Bumi Berhasil Diterima!']);
        break;

    case 'reject_bumi':
        
        $mysql->update('DAT_OP_BUMI', ['STATUS'=>'DITOLAK'])->where('ID',$_GET['act_id'])->exec();
        set_flash_msg(['success'=>'Data Bumi Ditolak!']);
        break;

    case 'reject_bng':
        
        $mysql->update('DAT_OP_BANGUNAN', ['STATUS'=>'DITOLAK'])->where('ID',$_GET['act_id'])->exec();
        set_flash_msg(['success'=>'Data Bangunan Ditolak!']);
        break;
   }
    header('Location:index.php?page=builder/pendaftaran/subjek-pajak/view&id='.$_GET['id']);
    return;
}

$msg = get_flash_msg('success');
$failed = get_flash_msg('failed');

$data = $mysql->select('subjek_pajak')->where("NIK",$_GET['id'])->first();

$opBumis = $mysql->select("DAT_OP_BUMI")->where('WAJIB_PAJAK_ID',$_GET['id'])->get();
$opBangunans = $mysql->select("DAT_OP_BANGUNAN")->where('WAJIB_PAJAK_ID',$_GET['id'])->get();

$kondisi = ["01-Sangat Baik","02-Baik","03-Sedang","04-Jelek"];
$konstruksi = ["01-Baja","02-Beton","03-Batu Bata","04-Kayu"];
$atap = ["01-Decrabon/Beton/Gtg Glazur","02-Gtg Beton/Aluminium","03-Gtg Biasa/Sirap","04-Asbes","05-Seng"];
$dinding = ["01-Kaca/Aluminium","02-Beton","03-Batu Bata/Conblok","04-Kayu","05-Seng","06-Spandex"];
$lantai = ["01-Marmer","02-Keramik","03-Teraso","04-Ubin PC/Papan","05-Semen"];
$langit = ["01-Akuistik/Jati","02-Triplek/Asbes/Bambu","30-Tidak Ada"];

$jenisBumi = ["01-TANAH DAN BANGUNAN","02-KAVLING SIAP BANGUN","03-TANAH KOSONG","04-FASILITAS UMUM"];
