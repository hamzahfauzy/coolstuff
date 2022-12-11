<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

if(request() == 'POST')
{
    $fields = require 'fields/'.$_POST['jpb'].'.php';
    $tahun  = $_POST['tahun'];

    $_POST['fields']['KD_PROPINSI'] = 12;
    $_POST['fields']['KD_DATI2'] = 12;
    $_POST['fields'][$fields['clause']] = $tahun;

    $insert = $qb->create($fields['table'],$_POST['fields'])->exec();

    set_flash_msg(['success'=>'Success']);
    header('location:index.php?page=builder/dbkb-non-standar/index&tahun='.$tahun.'&jpb='.$_POST['jpb'].'&tampilkan=');
    return;
}

$fields = require 'fields/'.$_GET['jpb'].'.php';
$tahun  = $_GET['tahun'];
$jpb    = $qb->select("REF_JPB")->where("KD_JPB",$_GET['jpb'])->first();

