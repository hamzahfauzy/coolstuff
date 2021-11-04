<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();


if(isset($_GET['kecamatan']))
{   
    $delete = $qb->delete('REF_KECAMATAN')->where('KD_KECAMATAN',$_GET['kecamatan'])->exec();

    if($delete)
    {
        set_flash_msg(['success'=>'Data Deleted']);
        header('location:index.php?page=builder/kecamatan/index');
        return;
    }
}