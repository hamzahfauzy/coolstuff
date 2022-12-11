<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = $qb->columns("REF_KECAMATAN","KD_KECAMATAN, NM_KECAMATAN");

if(request() == 'POST')
{   

    $_POST['KD_PROPINSI'] = 12;
    $_POST['KD_DATI2'] = 12;

    $insert = $qb->create('REF_KECAMATAN',$_POST)->exec();

    if(!isset($insert['error']))
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/kecamatan/index');
        return;
    }
}