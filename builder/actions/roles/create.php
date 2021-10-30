<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = $qb->columns("WEWENANG","KD_WEWENANG, NM_WEWENANG");

if(request() == 'POST')
{   

    $insert = $qb->create('WEWENANG',$_POST)->exec();

    if($insert)
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/roles/index');
        return;
    }
}