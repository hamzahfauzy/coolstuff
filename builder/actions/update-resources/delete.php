<?php
require '../helpers/QueryBuilder.php';


if(isset($_GET['resource']))
{   
    $qb = new QueryBuilder();
   
    $delete = $qb->delete("HRG_RESOURCE")->where('THN_HRG_RESOURCE',$_GET['year'])->where('KD_GROUP_RESOURCE',$_GET['group'])->where('KD_RESOURCE',$_GET['resource'])->exec();

    if($delete)
    {
        set_flash_msg(['success'=>'Data Deleted']);
        header("location:index.php?page=builder/update-resources/index&year=$_GET[year]&group=$_GET[group]");
        return;
    }
}