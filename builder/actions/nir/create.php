<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = $qb->columns("DAT_NIR","NO_DOKUMEN,NIR,THN_NIR_ZNT");

$kecamatans = $qb->select('REF_KECAMATAN')->get();

if(request() == 'POST')
{   
    $_POST['KD_PROPINSI'] = 12;
    $_POST['KD_DATI2'] = 12;
    $_POST['KD_KANWIL'] = '01';
    $_POST['KD_KPPBB'] = 16;
    $_POST['JNS_DOKUMEN'] = 1;

    $insert = $qb->create('DAT_NIR',$_POST)->exec();

    if($insert == false){
        print_r(sqlsrv_errors());

        die;
    }

    if($insert)
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/nir/index');
        return;
    }
}