<?php
require '../helpers/QueryBuilder.php';


if(isset($_GET['dbkb']))
{   
    $qb = new QueryBuilder();
    
    $keys = explode('-',$_GET['dbkb']);
   
    if($_GET['fasilitas'] == 'k3'){
        $delete = $qb->delete("FAS_DEP_MIN_MAX")->where('THN_DEP_MIN_MAX',$_GET['year'])->where('KD_FASILITAS',$keys[0])->where('KLS_DEP_MIN',$keys[1])->where('KLS_DEP_MAX',$keys[2])->exec();
    }elseif($_GET['fasilitas'] == 'k2'){
        $delete = $qb->delete("FAS_DEP_JPB_KLS_BINTANG")->where('THN_DEP_JPB_KLS_BINTANG',$_GET['year'])->where('KD_FASILITAS',$keys[0])->where('KD_JPB',$keys[1])->exec();
    }else{
        $delete = $qb->delete("FAS_NON_DEP")->where('THN_NON_DEP',$_GET['year'])->where('KD_FASILITAS',$_GET['dbkb'])->exec();
    }

    if($delete)
    {
        set_flash_msg(['success'=>'Data Deleted']);
        header("location:index.php?page=builder/dbkb-fasilitas/index&year=$_GET[year]&fasilitas=$_GET[fasilitas]");
        return;
    }
}