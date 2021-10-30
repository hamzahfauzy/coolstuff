<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();


if(isset($_GET['kecamatan']) && isset($_GET['kelurahan']) && isset($_GET['blok']))
{   
    $delete = $qb->delete('DAT_PETA_BLOK')->where('KD_KECAMATAN',$_GET['kecamatan'])->where('KD_KELURAHAN',$_GET['kelurahan'])->where('KD_BLOK',$_GET['blok'])->exec();

    if($delete)
    {
        set_flash_msg(['success'=>'Data Deleted']);
        header('location:index.php?page=builder/blok/index');
        return;
    }
}