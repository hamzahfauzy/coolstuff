<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$all_fields = $qb->columns("TEMPAT_BAYAR","KD_TP, NM_TP, ALAMAT_TP, NO_REK_TP");
$data = $qb->select('TEMPAT_BAYAR')->where('KD_TP',$_GET['tempat-pembayaran'])->first();
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

    $update = $qb->update('TEMPAT_BAYAR',$_POST)->where('KD_TP',$_GET['tempat-pembayaran'])->exec();

    if($update)
    {
        set_flash_msg(['success'=>'Data Updated']);
        header('location:index.php?page=builder/tempat-pembayaran/index');
        return;
    }
}