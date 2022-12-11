<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = $qb->columns("TEMPAT_BAYAR","KD_TP, NM_TP, ALAMAT_TP, NO_REK_TP");

if(request() == 'POST')
{   

    $_POST['KD_KANWIL'] = '01';
    $_POST['KD_KPPBB'] = '16';
    $_POST['KD_BANK_TUNGGAL'] = '01';
    $_POST['KD_BANK_PERSEPSI'] = '01';

    $insert = $qb->create('TEMPAT_BAYAR',$_POST)->exec();

    if(!isset($insert['error']))
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/tempat-pembayaran/index');
        return;
    }
}