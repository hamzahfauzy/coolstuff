<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();


if(isset($_GET['kecamatan']) && isset($_GET['kelurahan']) && isset($_GET['blok']))
{   
    $delete = $qb->delete('JALAN',$_POST)->where('KD_KECAMATAN',$_GET['kecamatan'])->where('KD_KELURAHAN',$_GET['kelurahan'])->where('KD_BLOK',$_GET['blok'])->where('KD_ZNT',$_GET['znt'])->where('NM_JLN',$_GET['nama-jalan'])->exec();

    if(!isset($delete['error']))
    {
        set_flash_msg(['success'=>'Data Deleted']);
        header('location:index.php?page=builder/nama-jalan/index');
        return;
    }
}