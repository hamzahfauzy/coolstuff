<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();


if(isset($_GET['kayu-ulin']))
{   
    $delete = $qb->delete('KAYU_ULIN')->where('THN_STATUS_KAYU_ULIN',$_GET['kayu-ulin'])->exec();

    if(!isset($delete['error']))
    {
        set_flash_msg(['success'=>'Data Deleted']);
        header('location:index.php?page=builder/kayu-ulin/index');
        return;
    }
}