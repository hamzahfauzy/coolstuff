<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$all_fields = $qb->columns("REF_KELURAHAN","KD_KELURAHAN, NM_KELURAHAN, NO_KELURAHAN, KD_POS_KELURAHAN");
$data = $qb->select('REF_KELURAHAN')->where('KD_KECAMATAN',$_GET['kecamatan'])->where('KD_KELURAHAN',$_GET['kelurahan'])->first();
$keys        = array_keys($data);
$fields      = [];

$kecamatans = $qb->select('REF_KECAMATAN')->get();
$sektors = $qb->select('REF_JNS_SEKTOR')->get();

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

    $update = $qb->update('REF_KELURAHAN',$_POST)->where('KD_KECAMATAN',$_GET['kecamatan'])->where('KD_KELURAHAN',$_GET['kelurahan'])->exec();

    if($update)
    {
        set_flash_msg(['success'=>'Data Updated']);
        header('location:index.php?page=builder/kelurahan/index');
        return;
    }
}