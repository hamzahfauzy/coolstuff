<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

// $clauseBumi = "DAT_OP_BUMI.KD_PROPINSI + '.' + DAT_OP_BUMI.KD_DATI2 + '.' + DAT_OP_BUMI.KD_KECAMATAN + '.' + DAT_OP_BUMI.KD_KELURAHAN + '.' + DAT_OP_BUMI.KD_BLOK + '-' + DAT_OP_BUMI.NO_URUT + '.' + DAT_OP_BUMI.KD_JNS_OP";

// $opBumi = $qb->select("DAT_OP_BUMI")->where($clauseBumi,$_GET['NOP'])->first();

// $NOP = "12.12.$opBumi[KD_KECAMATAN].$opBumi[KD_KELURAHAN].$opBumi[KD_BLOK]-$opBumi[NO_URUT].$opBumi[KD_JNS_OP]";

$sql = "DELETE_BUMI '" . $_GET['NOP'] . "','" . $_GET['NOP'] . "'";

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