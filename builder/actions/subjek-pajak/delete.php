<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();


if(isset($_GET['id']))
{   
    $delete = $qb->delete('DAT_SUBJEK_PAJAK',$_POST)->where("SUBJEK_PAJAK_ID",$_GET['id'])->exec();

    if($delete)
    {
        set_flash_msg(['success'=>'Data Deleted']);
        header('location:index.php?page=builder/subjek-pajak/index');
        return;
    }
}