<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$all_fields = $qb->columns("WEWENANG","KD_WEWENANG, NM_WEWENANG");
$data = $qb->select('WEWENANG')->where('KD_WEWENANG',$_GET['roles'])->first();
$keys        = array_keys($data);
$fields      = [];


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

    $update = $qb->update('WEWENANG',$_POST)->where('KD_WEWENANG',$_GET['roles'])->exec();

    if($update)
    {
        set_flash_msg(['success'=>'Data Updated']);
        header('location:index.php?page=builder/roles/index');
        return;
    }
}