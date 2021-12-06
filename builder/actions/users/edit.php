<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$all_fields = $qb->columns("USERS","WEWENANG",true);
$data = $qb->select('USERS')->where('NIP',$_GET['users'])->first();
$keys        = array_keys($data);
$fields      = [];

$roles = $qb->select("WEWENANG")->get();

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

    $update = $qb->update('USERS',$_POST)->where('NIP',$_GET['users'])->exec();

    if(!isset($update['error']))
    {
        set_flash_msg(['success'=>'Data Updated']);
        header('location:index.php?page=builder/users/index');
        return;
    }
}