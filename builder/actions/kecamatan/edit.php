<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$all_fields = $qb->columns("REF_KECAMATAN","KD_KECAMATAN, NM_KECAMATAN");
$data = $qb->select('REF_KECAMATAN')->where('KD_KECAMATAN',$_GET['kecamatan'])->first();
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

    $update = $qb->update('REF_KECAMATAN',$_POST)->where('KD_KECAMATAN',$_GET['kecamatan'])->exec();

    if(!isset($update['error']))
    {
        set_flash_msg(['success'=>'Data Updated']);
        header('location:index.php?page=builder/kecamatan/index');
        return;
    }
}