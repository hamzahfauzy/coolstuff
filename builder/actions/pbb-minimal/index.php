<?php

require '../helpers/QueryBuilder.php';

$msg = get_flash_msg('success');
$failed = get_flash_msg('failed');
$qb = new QueryBuilder();

if(isset($_GET['check'])){
    $sql = "Select * From PBB_MINIMAL where THN_PBB_MINIMAL='" . trim($_GET['year']) . "'";

    $pbb = $qb->rawQuery($sql)->first();

    echo $pbb ? 1 : 0;
    die;
}

$datas = $qb->select("PBB_MINIMAL")->orderBy('THN_PBB_MINIMAL','desc')->get();

if(request() == 'POST'){

    $_POST['KD_PROPINSI'] = 12;
    $_POST['KD_DATI2'] = 12;

    $sql = "Select * From PBB_MINIMAL where THN_PBB_MINIMAL='" . trim($_POST['THN_PBB_MINIMAL']) . "'";

    $pbb = $qb->rawQuery($sql)->first();

    if($pbb){
        
        if(isset($_POST['delete'])){

            $del = $qb->delete('PBB_MINIMAL')->where('THN_PBB_MINIMAL',trim($_POST['THN_PBB_MINIMAL'])); //->exec();

            if($del){
                set_flash_msg(['success'=>'Data Deleted']);
                header("location:index.php?page=builder/pbb-minimal/index");
                return;
            }else{
                set_flash_msg(['failed'=>'Failed Delete Data']);
                header("location:index.php?page=builder/pbb-minimal/index");
                return;
            }
        }else{

            if(!$_POST['NO_SK_PBB_MINIMAL']) unset($_POST['NO_SK_PBB_MINIMAL']);
            if(!$_POST['TGL_SK_PBB_MINIMAL']) unset($_POST['TGL_SK_PBB_MINIMAL']);
            if(!$_POST['NILAI_PBB_MINIMAL']) unset($_POST['NILAI_PBB_MINIMAL']);
            if(!$_POST['NIP_PEREKAM_PBB_MINIMAL']) unset($_POST['NIP_PEREKAM_PBB_MINIMAL']);
            if(!$_POST['TGL_REKAM_PBB_MINIMAL']) unset($_POST['TGL_REKAM_PBB_MINIMAL']);

            $upd = $qb->update('PBB_MINIMAL',$_POST)->where('THN_PBB_MINIMAL',trim($_POST['THN_PBB_MINIMAL']))->exec();
    
            if(!isset($upd['error'])){
                set_flash_msg(['success'=>'Data Updated']);
                header("location:index.php?page=builder/pbb-minimal/index");
                return;
            }else{
                set_flash_msg(['failed'=>'Failed Update Data']);
                header("location:index.php?page=builder/pbb-minimal/index");
                return;
            }
        }


    }else{

        if(isset($_POST['delete'])){
            set_flash_msg(['failed'=>'Failed Delete Data']);
            header("location:index.php?page=builder/pbb-minimal/index");
            return;
        }else{
            $create = $qb->create('PBB_MINIMAL',$_POST)->exec();
    
            if(!isset($create['error'])){
                set_flash_msg(['success'=>'Data Saved']);
                header("location:index.php?page=builder/pbb-minimal/index");
                return;
            }else{
                set_flash_msg(['failed'=>'Failed Save Data']);
                header("location:index.php?page=builder/pbb-minimal/index");
                return;
            }
        }

    }

}

$years = []; 
for($i = 0 ; $i<100;$i++){
    $years[] = date("Y",strtotime("-$i year"));
}

$year = date("Y");