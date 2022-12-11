<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$msg = get_flash_msg('success');
$failed = get_flash_msg('failed');

//KD_PROPINSI + '.' + KD_DATI2 + '.' + KD_KECAMATAN + '.' + KD_KELURAHAN + '.' + KD_BLOK + '-' + NO_URUT + '.' + KD_JNS_OP =  '" & Trim(aNOP.Text) & "' ORDER BY NO_BNG*1 DESC"
$data = $qb->select('DAT_SUBJEK_PAJAK')->where("SUBJEK_PAJAK_ID",$_GET['id'])->first();

// $opBumis = $qb->select("DAT_OP_BUMI","DAT_OP_BUMI.*, kecamatan.NM_KECAMATAN, kelurahan.NM_KELURAHAN")
//             ->leftJoin('REF_KECAMATAN as kecamatan','DAT_OP_BUMI.KD_KECAMATAN','kecamatan.KD_KECAMATAN')
//             ->leftJoin('REF_KELURAHAN as kelurahan','DAT_OP_BUMI.KD_KECAMATAN','kelurahan.KD_KECAMATAN')
//             ->andJoin('DAT_OP_BUMI.KD_KELURAHAN','kelurahan.KD_KELURAHAN')->where("SUBJEK_PAJAK_ID",$_GET['id'])->get();

$clause = "DAT_OP_BANGUNAN.KD_PROPINSI + '.' + DAT_OP_BANGUNAN.KD_DATI2 + '.' + DAT_OP_BANGUNAN.KD_KECAMATAN + '.' + DAT_OP_BANGUNAN.KD_KELURAHAN + '.' + DAT_OP_BANGUNAN.KD_BLOK + '-' + DAT_OP_BANGUNAN.NO_URUT + '.' + DAT_OP_BANGUNAN.KD_JNS_OP";

$clauseBumi = "DAT_OP_BUMI.KD_PROPINSI + '.' + DAT_OP_BUMI.KD_DATI2 + '.' + DAT_OP_BUMI.KD_KECAMATAN + '.' + DAT_OP_BUMI.KD_KELURAHAN + '.' + DAT_OP_BUMI.KD_BLOK + '-' + DAT_OP_BUMI.NO_URUT + '.' + DAT_OP_BUMI.KD_JNS_OP";
$clauseHBumi = "HISTORY_OP_BUMI.KD_PROPINSI + '.' + HISTORY_OP_BUMI.KD_DATI2 + '.' + HISTORY_OP_BUMI.KD_KECAMATAN + '.' + HISTORY_OP_BUMI.KD_KELURAHAN + '.' + HISTORY_OP_BUMI.KD_BLOK + '-' + HISTORY_OP_BUMI.NO_URUT + '.' + HISTORY_OP_BUMI.KD_JNS_OP";

$qOPs = $qb->select("QOBJEKPAJAK")->where("SUBJEK_PAJAK_ID",$data['SUBJEK_PAJAK_ID'])->get();

$opBangunans = [];
$opBumis = [];
$historyOpBumis = [];

$historyOpBumis = $qb->select("HISTORY_OP_BUMI","HISTORY_OP_BUMI.*, kecamatan.NM_KECAMATAN, kelurahan.NM_KELURAHAN")
        ->leftJoin('REF_KECAMATAN as kecamatan','HISTORY_OP_BUMI.KD_KECAMATAN','kecamatan.KD_KECAMATAN')
        ->leftJoin('REF_KELURAHAN as kelurahan','HISTORY_OP_BUMI.KD_KECAMATAN','kelurahan.KD_KECAMATAN')
        ->andJoin('HISTORY_OP_BUMI.KD_KELURAHAN','kelurahan.KD_KELURAHAN')->where('HISTORY_OP_BUMI.SUBJEK_PAJAK_ID',$data['SUBJEK_PAJAK_ID'])->orderBy('YEAR','desc')->get();


foreach ($qOPs as $qOP) {

        $opb = $qb->select("DAT_OP_BUMI","DAT_OP_BUMI.*, $clauseBumi as NOPQ, kecamatan.NM_KECAMATAN, kelurahan.NM_KELURAHAN")
                ->leftJoin('REF_KECAMATAN as kecamatan','DAT_OP_BUMI.KD_KECAMATAN','kecamatan.KD_KECAMATAN')
                ->leftJoin('REF_KELURAHAN as kelurahan','DAT_OP_BUMI.KD_KECAMATAN','kelurahan.KD_KECAMATAN')
                ->andJoin('DAT_OP_BUMI.KD_KELURAHAN','kelurahan.KD_KELURAHAN')->where($clauseBumi,$qOP['NOPQ'])->get();
        $opBumis = array_merge($opBumis, $opb); 


        $opbng = $qb->select("DAT_OP_BANGUNAN","DAT_OP_BANGUNAN.*, $clause as NOPQ, jpb.NM_JPB_JPT, kecamatan.NM_KECAMATAN, kelurahan.NM_KELURAHAN, $clause as NOP")
                        ->leftJoin('REF_KECAMATAN as kecamatan','DAT_OP_BANGUNAN.KD_KECAMATAN','kecamatan.KD_KECAMATAN')
                        ->leftJoin('JPB_JPT as jpb','DAT_OP_BANGUNAN.KD_JPB','jpb.KD_JPB_JPT')
                        ->leftJoin('REF_KELURAHAN as kelurahan','DAT_OP_BANGUNAN.KD_KECAMATAN','kelurahan.KD_KECAMATAN')
                        ->andJoin('DAT_OP_BANGUNAN.KD_KELURAHAN','kelurahan.KD_KELURAHAN')->where($clause,$qOP['NOPQ'])->get();
        $opBangunans = array_merge($opBangunans, $opbng);
}

$kondisi = ["01-Sangat Baik","02-Baik","03-Sedang","04-Jelek"];
$konstruksi = ["01-Baja","02-Beton","03-Batu Bata","04-Kayu"];
$atap = ["01-Decrabon/Beton/Gtg Glazur","02-Gtg Beton/Aluminium","03-Gtg Biasa/Sirap","04-Asbes","05-Seng"];
$dinding = ["01-Kaca/Aluminium","02-Beton","03-Batu Bata/Conblok","04-Kayu","05-Seng","06-Spandex"];
$lantai = ["01-Marmer","02-Keramik","03-Teraso","04-Ubin PC/Papan","05-Semen"];
$langit = ["01-Akuistik/Jati","02-Triplek/Asbes/Bambu","30-Tidak Ada"];
$pekerjaans = [
        '1' => 'PNS',
        '2' => 'TNI/Polri',
        '3' => 'Pensiunan',
        '4' => 'Badan',
        '5' => 'Lainnya'
];

$jenisBumi = ["01-TANAH DAN BANGUNAN","02-KAVLING SIAP BANGUN","03-TANAH KOSONG","04-FASILITAS UMUM"];
