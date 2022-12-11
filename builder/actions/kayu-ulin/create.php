<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$failed = get_flash_msg('failed');
$old = get_flash_msg('old');

if(request() == 'POST')
{   

    $_POST['KD_PROPINSI'] = '12';
    $_POST['KD_DATI2'] = '12';

    $ulin = $qb->select("KAYU_ULIN")->where("THN_STATUS_KAYU_ULIN",$_POST["THN_STATUS_KAYU_ULIN"])->first();

    if($ulin){

        set_flash_msg(['failed'=>'Data sudah ada','old'=>[
            'THN_STATUS_KAYU_ULIN'=>$_POST["THN_STATUS_KAYU_ULIN"],
            'STATUS_KAYU_ULIN'=>$_POST["STATUS_KAYU_ULIN"],
        ]]);

        header('location:index.php?page=builder/kayu-ulin/create');
        return;
    }

    $insert = $qb->create('KAYU_ULIN',$_POST)->exec();

    if(!isset($insert['error']))
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/kayu-ulin/index');
        return;
    }
}