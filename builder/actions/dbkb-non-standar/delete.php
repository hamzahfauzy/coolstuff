<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = require 'fields/'.$_GET['jpb'].'.php';
$tahun  = $_GET['tahun'];

$delete = $qb->delete($fields['table'])->where($fields['clause'],$tahun)->exec();

if(!isset($delete['error']))
{
    set_flash_msg(['success'=>'Data Deleted']);
    header('location:index.php?page=builder/dbkb-non-standar/index&tahun='.$tahun.'&jpb='.$_GET['jpb'].'&tampilkan=');
    return;
}