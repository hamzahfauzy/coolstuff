<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();


if(isset($_GET['roles']))
{   
    $delete = $qb->delete('WEWENANG')->where('KD_WEWENANG',$_GET['roles'])->exec();

    if($delete)
    {
        set_flash_msg(['success'=>'Data Deleted']);
        header('location:index.php?page=builder/roles/index');
        return;
    }
}