<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();


if(isset($_GET['users']))
{   
    $delete = $qb->delete('USERS')->where('NIP',$_GET['users'])->exec();

    if(!isset($delete['error']))
    {
        set_flash_msg(['success'=>'Data Deleted']);
        header('location:index.php?page=builder/users/index');
        return;
    }
}