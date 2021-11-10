<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$opBumi = $qb->select("DAT_OP_BUMI")->where("SUBJEK_PAJAK_ID",$_GET['id'])->where('KD_KECAMATAN',$_GET['kecamatan'])->where('KD_KELURAHAN',$_GET['kelurahan'])->where('KD_BLOK',$_GET['blok'])->where('KD_ZNT',$_GET['znt'])->first();

$NOP = "12.12.$opBumi[KD_KECAMATAN].$opBumi[KD_KELURAHAN].$opBumi[KD_BLOK]-$opBumi[NO_URUT].$opBumi[KD_JNS_OP]";

$sql = "DELETE_BUMI '" . $NOP . "','" . $NOP . "'";

$delete = $qb->rawQuery($sql)->exec();

if($delete)
{
    set_flash_msg(['success'=>'Data Deleted']);
    header('location:index.php?page=builder/subjek-pajak/view&id='.$_GET['id']);
    return;
}else{
    set_flash_msg(['failed'=>'Gagal Menghapus Data']);
    header('location:index.php?page=builder/subjek-pajak/view&id='.$_GET['id']);
    return;
}