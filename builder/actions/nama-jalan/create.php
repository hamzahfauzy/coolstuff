<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = $qb->columns("JALAN","NM_JLN");

$kecamatans = $qb->select('REF_KECAMATAN')->get();

if(request() == 'POST')
{   
    $_POST['KD_PROPINSI'] = 12;
    $_POST['KD_DATI2'] = 12;

    $insert = $qb->create('JALAN',$_POST)->exec();

    if(!isset($insert['error']))
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/nama-jalan/index');
        return;
    }
}