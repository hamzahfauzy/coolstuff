<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = $qb->columns("DAT_PETA_ZNT","KD_ZNT");

$kecamatans = $qb->select('REF_KECAMATAN')->get();

if(request() == 'POST')
{   
    $_POST['KD_PROPINSI'] = 12;
    $_POST['KD_DATI2'] = 12;

    $insert = $qb->create('DAT_PETA_ZNT',$_POST)->exec();

    if( $insert === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    if($insert)
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/znt/index');
        return;
    }
}