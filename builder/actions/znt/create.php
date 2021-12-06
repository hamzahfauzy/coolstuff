<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = $qb->columns("DAT_PETA_ZNT","KD_ZNT");

$msg = get_flash_msg('error');

$kecamatans = $qb->select('REF_KECAMATAN')->orderby('KD_KECAMATAN')->get();

if(request() == 'POST')
{   
    $_POST['KD_PROPINSI'] = 12;
    $_POST['KD_DATI2'] = 12;

    $insert = $qb->create('DAT_PETA_ZNT',$_POST)->exec();

    if(isset($insert['error']))
    {
        set_flash_msg(['error'=>'Data Sudah Ada']);
        header('location:index.php?page=builder/znt/create');
        return;
    }

    if(!isset($insert['error']))
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/znt/index');
        return;
    }
}