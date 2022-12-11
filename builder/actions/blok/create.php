<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = $qb->columns("DAT_PETA_BLOK","KD_BLOK");

$kecamatans = $qb->select('REF_KECAMATAN')->orderby('KD_KECAMATAN')->get();

$msg = get_flash_msg('error');

if(request() == 'POST')
{   
    $_POST['KD_PROPINSI'] = 12;
    $_POST['KD_DATI2'] = 12;
    $_POST['STATUS_PETA_BLOK'] = 0;

    $insert = $qb->create('DAT_PETA_BLOK',$_POST)->exec();
    if(isset($insert['error']))
    {
        set_flash_msg(['error'=>'Data Sudah Ada']);
        header('location:index.php?page=builder/blok/create');
        return;
    }

    if($insert)
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/blok/index');
        return;
    }
}