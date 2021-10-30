<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$data = $qb->select('KAYU_ULIN')->where('THN_STATUS_KAYU_ULIN',$_GET['kayu-ulin'])->first();

if(request() == 'POST')
{   

    $update = $qb->update('KAYU_ULIN',$_POST)->where('THN_STATUS_KAYU_ULIN',$_GET['kayu-ulin'])->exec();

    if($update)
    {
        set_flash_msg(['success'=>'Data Updated']);
        header('location:index.php?page=builder/kayu-ulin/index');
        return;
    }
}