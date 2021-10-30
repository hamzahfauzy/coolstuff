<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();


if(isset($_GET['kecamatan']) && isset($_GET['kelurahan']))
{   
    $delete = $qb->delete('REF_KELURAHAN')->where('KD_KECAMATAN',$_GET['kecamatan'])->where('KD_KELURAHAN',$_GET['kelurahan'])->exec();

    if($delete)
    {
        set_flash_msg(['success'=>'Data Deleted']);
        header('location:index.php?page=builder/kelurahan/index');
        return;
    }
}