<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = $qb->columns("REF_KELURAHAN","KD_KELURAHAN, NM_KELURAHAN, NO_KELURAHAN, KD_POS_KELURAHAN");

$kecamatans = $qb->select('REF_KECAMATAN')->get();
$sektors = $qb->select('REF_JNS_SEKTOR')->get();

if(request() == 'POST')
{   
    $_POST['KD_PROPINSI'] = 12;
    $_POST['KD_DATI2'] = 12;

    $insert = $qb->create('REF_KELURAHAN',$_POST)->exec();

    if(!isset($insert['error']))
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/kelurahan/index');
        return;
    }
}