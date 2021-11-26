<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$fields = $qb->columns("WEWENANG","KD_WEWENANG, NM_WEWENANG");

if(request() == 'POST')
{   


    $newData = [];

    $newData['code'] = $_POST['KD_WEWENANG'] ?? 0;

    foreach (getModules() as $key => $value) {
        foreach ($value as $key2 => $value2) {

            if(is_array($value2)){
                foreach ($value2 as $key3 => $value3) {
                    if(array_key_exists($value3,$_POST)){
                        
                        $newData[$value3] = $_POST[$value3] == 'on' ? 1 : 0;

                        unset($_POST[$value3]);
                    }
                }
            }else{
                if(array_key_exists($value2,$_POST)){

                    $newData[$value2] = $_POST[$value2] == 'on' ? 1 : 0;

                    unset($_POST[$value2]);
                }
            }
            

        }
    }

    $builder = new Builder;
    $datas  = $builder->get_content('modules');
    $datas[] = $newData;
    $datas = json_encode($datas);

    $insert = $qb->create('WEWENANG',$_POST)->exec();

    if($insert && $builder->set_content('modules',$datas))
    {
        set_flash_msg(['success'=>'Data Saved']);
        header('location:index.php?page=builder/roles/index');
        return;
    }
}