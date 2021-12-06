<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$all_fields = $qb->columns("WEWENANG","KD_WEWENANG, NM_WEWENANG");
$data = $qb->select('WEWENANG')->where('KD_WEWENANG',$_GET['roles'])->first();
$keys        = array_keys($data);
$fields      = [];

$data_key = null;

$builder = new Builder;
$modules = $builder->get_content('modules');

$module = [];

foreach ($modules as $key => $value) {

    $value = (array) $value;

    if($value['code'] == $_GET['roles']){
        $data_key = $key;
        $module = $value;
        break;
    }
}

$i = 0;
foreach($keys as $key)
{

    if(empty($all_fields[$i]) || $all_fields[$i]['column_name'] != $key){
        continue;
    }

    $fields[$key] = [
        'type' => $all_fields[$i]['data_type'],
        'character_maximum_length' => $all_fields[$i]['character_maximum_length'],
        'value' => $data[$key],
    ];

    $i++;
}

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

    if($data_key == null){
        $datas  = $modules;
        $datas[] = $newData;
        $datas = json_encode($datas);
    }else{
        $datas = (array) $modules;
        $datas[$data_key] = $newData;
        $datas = json_encode($datas);
    }

    $update = $qb->update('WEWENANG',$_POST)->where('KD_WEWENANG',$_GET['roles'])->exec();

    if(!isset($update['error']) && $builder->set_content('modules',$datas))
    {
        set_flash_msg(['success'=>'Data Updated']);
        header('location:index.php?page=builder/roles/index');
        return;
    }
}