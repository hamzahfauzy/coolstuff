<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();


if(isset($_GET['pejabat']))
{   
    $delete = $qb->delete('PEJABAT')->where('NIP',$_GET['pejabat'])->exec();

    if(!isset($delete['error']))
    {
        set_flash_msg(['success'=>'Data Deleted']);
        header('location:index.php?page=builder/pejabat/index');
        return;
    }
}