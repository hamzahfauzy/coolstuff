<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();


if(isset($_GET['tempat-pembayaran']))
{   
    $delete = $qb->delete('TEMPAT_BAYAR')->where('KD_TP',$_GET['tempat-pembayaran'])->exec();

    if(!isset($delete['error']))
    {
        set_flash_msg(['success'=>'Data Deleted']);
        header('location:index.php?page=builder/tempat-pembayaran/index');
        return;
    }
}