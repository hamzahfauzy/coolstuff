<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = $qb->columns("USERS","WEWENANG",true);
$roles = $qb->select("WEWENANG")->get();


if(request() == 'POST')
{   

    $insert = $qb->create('USERS',$_POST)->exec();

    if(!isset($insert['error']))
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/users/index');
        return;
    }
}