<?php
require '../helpers/QueryBuilder.php';

$qb = new QueryBuilder();

$all_fields = $qb->columns("DAT_SUBJEK_PAJAK","SUBJEK_PAJAK_ID,NM_WP,JALAN_WP,RW_WP,RT_WP,KOTA_WP,KD_POS_WP,TELP_WP,NPWP,STATUS_PEKERJAAN_WP");

$data = $qb->select('DAT_SUBJEK_PAJAK')->where("SUBJEK_PAJAK_ID",$_GET['id'])->first();
$keys        = array_keys($data);
$fields      = [];

$kelurahans = $qb->select('REF_KELURAHAN')->get();

$bloks = $qb->select("DAT_PETA_BLOK","KD_BLOK")->leftJoin("REF_KELURAHAN","DAT_PETA_BLOK.KD_KELURAHAN","REF_KELURAHAN.KD_KELURAHAN")->where('REF_KELURAHAN.NM_KELURAHAN',$data["KELURAHAN_WP"])->groupBy("KD_BLOK")->get();

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

    $kels = explode("-",$_POST['KELURAHAN_WP']);

    $_POST['KELURAHAN_WP'] = trim($kels[1]);

    $update = $qb->update('DAT_SUBJEK_PAJAK',$_POST)->where("SUBJEK_PAJAK_ID",$_GET['id'])->exec();

    if($update)
    {
        set_flash_msg(['success'=>'Data Updated']);
        header('location:index.php?page=builder/subjek-pajak/index');
        return;
    }
}