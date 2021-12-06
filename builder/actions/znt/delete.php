<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();


if(isset($_GET['kecamatan']) && isset($_GET['kelurahan']) && isset($_GET['blok']) && isset($_GET['znt']))
{   
    $delete = $qb->delete('DAT_PETA_ZNT')->where('KD_KECAMATAN',$_GET['kecamatan'])->where('KD_KELURAHAN',$_GET['kelurahan'])->where('KD_BLOK',$_GET['blok'])->where('KD_ZNT',$_GET['znt'])->exec();

    if(!isset($delete['error']))
    {
        set_flash_msg(['success'=>'Data Deleted']);
        header('location:index.php?page=builder/znt/index');
        return;
    }
}