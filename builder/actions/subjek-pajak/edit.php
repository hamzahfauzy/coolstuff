<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$all_fields = $qb->columns("DAT_SUBJEK_PAJAK","KELURAHAN_WP,SUBJEK_PAJAK_ID,NM_WP,JALAN_WP,RW_WP,RT_WP,KOTA_WP,KD_POS_WP,TELP_WP,NPWP,BLOK_KAV_NO_WP");

$data = $qb->select('DAT_SUBJEK_PAJAK')->where("SUBJEK_PAJAK_ID",$_GET['id'])->first();
$keys        = array_keys($data);
$fields      = [];

$pekerjaans = [
    '1' => 'PNS',
    '2' => 'TNI/Polri',
    '3' => 'Pensiunan',
    '4' => 'Badan',
    '5' => 'Lainnya'
];

$i = 0;
foreach($keys as $key => $val)
{

    if(empty($all_fields[$i]) || $all_fields[$i]['column_name'] != $val){
        continue;
    }

    $fields[$val] = [
        'type' => $all_fields[$i]['data_type'],
        'character_maximum_length' => $all_fields[$i]['character_maximum_length'],
        'value' => $data[$val],
    ];

    $i++;

}

if(request() == 'POST')
{   

    // $kels = explode("-",$_POST['KELURAHAN_WP']);

    // $_POST['KELURAHAN_WP'] = trim($kels[1]);

    $update = $qb->update('DAT_SUBJEK_PAJAK',$_POST)->where("SUBJEK_PAJAK_ID",$_GET['id'])->exec();

    if($update)
    {
        set_flash_msg(['success'=>'Data Updated']);
        header('location:index.php?page=builder/subjek-pajak/index');
        return;
    }
}