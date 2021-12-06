<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

if(isset($_GET['roles']))
{   
    $delete = $qb->delete('WEWENANG')->where('KD_WEWENANG',$_GET['roles'])->exec();

    $builder = new Builder;
    $modules = $builder->get_content('modules');

    $data_key = null;

    foreach ($modules as $key => $value) {

        $value = (array) $value;

        if($value['code'] == $_GET['roles']){
            $data_key = $key;
            break;
        }
    }


    if($data_key != null){
        unset($modules[$data_key]);
    }
    $datas = json_encode($modules);

    if(!isset($delete['error']) && $builder->set_content('modules',$datas))
    {
        set_flash_msg(['success'=>'Data Deleted']);
        header('location:index.php?page=builder/roles/index');
        return;
    }
}