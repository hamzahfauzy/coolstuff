<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = $qb->columns("DAT_OP_BUMI","NO_URUT,KD_JNS_OP,LUAS_BUMI,NILAI_SISTEM_BUMI,NO_FORMULIR,STATUS_JADI");

$kecamatans = $qb->select('REF_KECAMATAN')->get();

$subjekPajak = $qb->select("DAT_SUBJEK_PAJAK")->where('SUBJEK_PAJAK_ID',$_GET['id'])->first();

$opBumi = $qb->select("DAT_OP_BUMI")->where("SUBJEK_PAJAK_ID",$_GET['id'])->where('KD_KECAMATAN',$_GET['kecamatan'])->where('KD_KELURAHAN',$_GET['kelurahan'])->where('KD_BLOK',$_GET['blok'])->where('KD_ZNT',$_GET['znt'])->first();

$kelurahans = $qb->select("REF_KELURAHAN")->where('KD_KECAMATAN',$opBumi['KD_KECAMATAN'])->get();
$bloks = $qb->select("DAT_PETA_BLOK")->where('KD_KECAMATAN',$opBumi['KD_KECAMATAN'])->where('KD_KELURAHAN',$opBumi['KD_KELURAHAN'])->get();
$znts = $qb->select("DAT_PETA_ZNT")->where('KD_KECAMATAN',$opBumi['KD_KECAMATAN'])->where('KD_KELURAHAN',$opBumi['KD_KELURAHAN'])->where('KD_BLOK',$opBumi['KD_BLOK'])->get();

$jenisBumis = ["01-TANAH DAN BANGUNAN","02-KAVLING SIAP BANGUN","03-TANAH KOSONG","04-FASILITAS UMUM"];

if(request() == 'POST')
{   
    // $_POST['KD_PROPINSI'] = 12;
    // $_POST['KD_DATI2'] = 12;
    // $_POST['NO_BUMI'] = 1;
    // $_POST['SUBJEK_PAJAK_ID'] = $_GET['id'];

    $update = $qb->update('DAT_OP_BUMI',$_POST)->where('KD_KECAMATAN',$_GET['kecamatan'])->where('KD_KELURAHAN',$_GET['kelurahan'])->where('KD_BLOK',$_GET['blok'])->where('KD_ZNT',$_GET['znt'])->where("SUBJEK_PAJAK_ID",$_GET['id'])->exec();

    if($update)
    {
        set_flash_msg(['success'=>'Data Updated']);
        header('location:index.php?page=builder/subjek-pajak/view&id='.$_GET['id']);
        return;
    }
}