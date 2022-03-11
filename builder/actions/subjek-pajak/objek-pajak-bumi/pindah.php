<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$clauseBumi = "DAT_OP_BUMI.KD_PROPINSI + '.' + DAT_OP_BUMI.KD_DATI2 + '.' + DAT_OP_BUMI.KD_KECAMATAN + '.' + DAT_OP_BUMI.KD_KELURAHAN + '.' + DAT_OP_BUMI.KD_BLOK + '-' + DAT_OP_BUMI.NO_URUT + '.' + DAT_OP_BUMI.KD_JNS_OP";

$subjekPajak = $qb->select("DAT_SUBJEK_PAJAK")->where('SUBJEK_PAJAK_ID',$_GET['id'])->first();

$opBumi = $qb->select("DAT_OP_BUMI")->where($clauseBumi,$_GET['NOP'])->first();

$datOP = $qb->select("DAT_OBJEK_PAJAK")->where("SUBJEK_PAJAK_ID",$_GET['id'])->where('KD_KECAMATAN',$opBumi['KD_KECAMATAN'])->where('KD_KELURAHAN',$opBumi['KD_KELURAHAN'])->where('KD_BLOK',$opBumi['KD_BLOK'])->first();

$old = get_flash_msg("old");

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

$year = date("Y");

if(request() == 'POST')
{   
    $opBumi['YEAR'] = $_POST['YEAR'];
    $history = $qb->create("HISTORY_OP_BUMI",$opBumi)->exec();

    $update = $qb->update("DAT_OBJEK_PAJAK",["SUBJEK_PAJAK_ID"=>$_POST['SUBJEK_PAJAK_ID']])->where("SUBJEK_PAJAK_ID",$_GET['id'])->where('KD_KECAMATAN',$opBumi['KD_KECAMATAN'])->where('KD_KELURAHAN',$opBumi['KD_KELURAHAN'])->where('KD_BLOK',$opBumi['KD_BLOK'])->exec();

    $update = $qb->update("DAT_OP_BUMI",["SUBJEK_PAJAK_ID"=>$_POST['SUBJEK_PAJAK_ID']])->where($clauseBumi,$_GET['NOP'])->exec();

    if($update)
    {
        set_flash_msg(['success'=>'Data Updated']);
        header('location:index.php?page=builder/subjek-pajak/view&id='.$_GET['id']);
        return;
    }else{
        set_flash_msg(["old"=>$_POST]);

        header('location:index.php?page=builder/subjek-pajak/objek-pajak-bumi/pindah&id='.$_GET['id']."&NOP=".$_GET['NOP']);
        return;
    }
}