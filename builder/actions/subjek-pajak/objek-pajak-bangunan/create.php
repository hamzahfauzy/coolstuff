<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = $qb->columns("DAT_OP_BANGUNAN","NO_BNG,NO_FORMULIR_LSPOP,THN_DIBANGUN_BNG,THN_RENOVASI_BNG,LUAS_BNG,JML_LANTAI_BNG,NILAI_SISTEM_BNG,JNS_TRANSAKSI_BNG,TGL_PENDATAAN_BNG,TGL_PEMERIKSAAN_BNG,TGL_PEREKAMAN_BNG,K_UTAMA,K_MATERIAL,K_FASILITAS,J_SUSUT,K_SUSUT,K_NON_SUSUT,NIP_PEREKAM_BNG,NIP_PEMERIKSA_BNG,NIP_PENDATA_BNG");

$kecamatans = $qb->select('REF_KECAMATAN')->get();

$jpbs = $qb->select('REF_JPB')->orderBy('KD_JPB')->get();

$subjekPajak = $qb->select("DAT_SUBJEK_PAJAK")->where('SUBJEK_PAJAK_ID',$_GET['id'])->first();

$old = get_flash_msg("old");

$kondisis = ["01-Sangat Baik","02-Baik","03-Sedang","04-Jelek"];
$konstruksis = ["01-Baja","02-Beton","03-Batu Bata","04-Kayu"];
$ataps = ["01-Decrabon/Beton/Gtg Glazur","02-Gtg Beton/Aluminium","03-Gtg Biasa/Sirap","04-Asbes","05-Seng"];
$dindings = ["01-Kaca/Aluminium","02-Beton","03-Batu Bata/Conblok","04-Kayu","05-Seng","06-Spandex"];
$lantais = ["01-Marmer","02-Keramik","03-Teraso","04-Ubin PC/Papan","05-Semen"];
$langits = ["01-Akuistik/Jati","02-Triplek/Asbes/Bambu","30-Tidak Ada"];

// if($opBangunan){

//     // rPajak!K_UTAMA = Round(JUM1.Caption, 0)
//     // rPajak!K_MATERIAL = Round(JUM2.Caption, 0)
//     // rPajak!K_FASILITAS = Round(JUM3.Caption, 0)
//     // rPajak!K_SUSUT = Round(JUM4.Caption, 0)
//     // rPajak!K_NON_SUSUT = Round(JUM5.Caption, 0)
//     // rPajak!J_SUSUT = Round(FLK2(17).Text, 0)

    // $opBangunanFields = $qb->columns("DAT_OP_BANGUNAN","NO_URUT,KD_JNS_OP,NO_BNG,KD_JPB,NO_FORMULIR_LSPOP,THN_DIBANGUN_BNG,THN_RENOVASI_BNG,LUAS_BNG,JML_LANTAI_BNG,NILAI_SISTEM_BNG,JNS_TRANSAKSI_BNG,TGL_PENDATAAN_BNG,TGL_PEMERIKSAAN_BNG,TGL_PEREKAMAN_BNG,K_UTAMA,K_MATERIAL,K_FASILITAS,J_SUSUT,K_SUSUT,K_NON_SUSUT,NIP_PEREKAM_BNG,NIP_PEMERIKSA_BNG,NIP_PENDATA_BNG");
// }

if(request() == 'POST')
{   
    $_POST['KD_PROPINSI'] = 12;
    $_POST['KD_DATI2'] = 12;
    
    $clause = "KD_PROPINSI + '.' + KD_DATI2 + '.' + KD_KECAMATAN + '.' + KD_KELURAHAN + '.' + KD_BLOK + '-' + NO_URUT + '.' + KD_JNS_OP";

    // $val = "$_POST[KD_PROPINSI].$_POST[KD_DATI2].$_POST[KD_KECAMATAN].$_POST[KD_KELURAHAN].$_POST[KD_BLOK]-$_POST[NO_URUT].$_POST[KD_JNS_OP]";

    $opBangunan = $qb->select("DAT_OP_BANGUNAN")->where($clause,$_POST['NOP'])->first();

    if($opBangunan){

        set_flash_msg(["old"=>$_POST]);

        header('location:index.php?page=builder/subjek-pajak/objek-pajak-bangunan/create&id='.$_GET['id']);
        return;
    }

    if(isset($_POST["TGL_PENDATAAN_BNG"])){
        $result = $_POST["TGL_PENDATAAN_BNG"]." 00:00:00";
        $_POST["TGL_PENDATAAN_BNG"] = $result;
    }

    if(isset($_POST["TGL_PEMERIKSAAN_BNG"])){
        $result = $_POST["TGL_PEMERIKSAAN_BNG"]." 00:00:00";
        $_POST["TGL_PEMERIKSAAN_BNG"] = $result;
    }

    if(isset($_POST["TGL_PEREKAMAN_BNG"])){
        $result = $_POST["TGL_PEREKAMAN_BNG"]." 00:00:00";
        $_POST["TGL_PEREKAMAN_BNG"] = $result;
    }

    $arr = explode(".",$_POST["NOP"]);

    $_POST['KD_KECAMATAN'] = $arr[2];
    $_POST['KD_KELURAHAN'] = $arr[3];

    $arr2 = explode("-",$arr[4]);
    $_POST['KD_BLOK'] = $arr2[0];
    $_POST['NO_URUT'] = $arr2[1];

    $_POST['KD_JNS_OP'] = $arr[5];

    unset($_POST['NOP']);

    $insert = $qb->create('DAT_OP_BANGUNAN',$_POST)->exec();

    if($insert)
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/subjek-pajak/view&id='.$_GET['id']);
        return;
    }
}