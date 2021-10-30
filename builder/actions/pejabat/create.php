<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = $qb->columns("PEJABAT");

if(request() == 'POST')
{   
    $insert = $qb->create('PEJABAT',$_POST)->exec();

    if($insert)
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/pejabat/index');
        return;
    }
}