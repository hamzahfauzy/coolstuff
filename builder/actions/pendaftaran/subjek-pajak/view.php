<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();
$mysql = new QueryBuilder("mysql");

$msg = get_flash_msg('success');
$failed = get_flash_msg('failed');

$data = $qb->select('DAT_SUBJEK_PAJAK')->where("SUBJEK_PAJAK_ID",$_GET['id'])->first();
$clauseBumi = "concat(12,'.',12,'.',KD_KECAMATAN, '.', KD_KELURAHAN , '.' , KD_BLOK , '-' , NO_URUT , '.' , KODE)";

$qOPs = $qb->select("QOBJEKPAJAK")->where("SUBJEK_PAJAK_ID",$data['SUBJEK_PAJAK_ID'])->get();

$opBangunans = [];
$opBumis = [];

foreach ($qOPs as $qOP) {

        $opb = $mysql->select("DAT_OP_BUMI","DAT_OP_BUMI.*, $clauseBumi as NOPQ")
                        ->where($clauseBumi,$qOP['NOPQ'])->get();
        $opBumis = array_merge($opBumis, $opb); 


        $opbng = $mysql->select("DAT_OP_BANGUNAN","DAT_OP_BANGUNAN.*, NOP as NOPQ")
                        ->where("NOP",$qOP['NOPQ'])->get();
        $opBangunans = array_merge($opBangunans, $opbng);
}

$kondisi = ["01-Sangat Baik","02-Baik","03-Sedang","04-Jelek"];
$konstruksi = ["01-Baja","02-Beton","03-Batu Bata","04-Kayu"];
$atap = ["01-Decrabon/Beton/Gtg Glazur","02-Gtg Beton/Aluminium","03-Gtg Biasa/Sirap","04-Asbes","05-Seng"];
$dinding = ["01-Kaca/Aluminium","02-Beton","03-Batu Bata/Conblok","04-Kayu","05-Seng","06-Spandex"];
$lantai = ["01-Marmer","02-Keramik","03-Teraso","04-Ubin PC/Papan","05-Semen"];
$langit = ["01-Akuistik/Jati","02-Triplek/Asbes/Bambu","30-Tidak Ada"];

$jenisBumi = ["01-TANAH DAN BANGUNAN","02-KAVLING SIAP BANGUN","03-TANAH KOSONG","04-FASILITAS UMUM"];
